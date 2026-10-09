<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RedirectResponse;
use RuntimeException;
use Throwable;

class Products extends BaseController
{
    private const IMAGE_DIRECTORY = 'uploads/products';
    private const PLACEHOLDER_PATH = 'assets/images/product-placeholder.svg';

    public function index(): string
    {
        $products = (new ProductModel())->findAllActive();

        foreach ($products as &$product) {
            $product['image_url'] = $this->imageUrl($product['image'] ?? null);
        }
        unset($product);

        return view('products/index', [
            'title'      => 'Products',
            'activePage' => 'products',
            'products'   => $products,
        ]);
    }

    public function new(): string
    {
        return view('products/new', [
            'title'      => 'New Product',
            'activePage' => 'products',
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        $image    = $this->request->getFile('image');
        $hasImage = $image instanceof UploadedFile && $image->getError() !== UPLOAD_ERR_NO_FILE;
        $response = $this->rejectOversizedUpload($image, $hasImage, 'products/new');

        if ($response !== null) {
            return $response;
        }

        $validation = service('validation');
        $validation->setRules($this->productRules($hasImage));

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('products/new'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $filename = null;

        if ($hasImage) {
            try {
                $filename = $this->prepareImage($image);
            } catch (Throwable) {
                return redirect()->to(site_url('products/new'))
                    ->withInput()
                    ->with('errors', ['image' => 'The product image could not be prepared. Please use another JPG or PNG image.']);
            }
        }

        try {
            (new ProductModel())->insert([
                'name'           => trim((string) $this->request->getPost('name')),
                'price'          => $this->normalizePrice((string) $this->request->getPost('price')),
                'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
                'image'          => $filename,
                'is_archived'    => 0,
                'created_at'     => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $exception) {
            if ($filename !== null) {
                $this->removeImage($filename);
            }

            throw $exception;
        }

        return redirect()->to(site_url('products'))
            ->with('success', 'Product created successfully.');
    }

    public function edit(int $id): string
    {
        $product = (new ProductModel())->findActive($id);

        if ($product === null) {
            throw PageNotFoundException::forPageNotFound('Active product not found.');
        }

        return view('products/edit', [
            'title'      => 'Edit Product',
            'activePage' => 'products',
            'product'    => $product,
            'imageUrl'   => $this->imageUrl($product['image'] ?? null),
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $productModel = new ProductModel();
        $product      = $productModel->findActive($id);

        if ($product === null) {
            throw PageNotFoundException::forPageNotFound('Active product not found.');
        }

        $image    = $this->request->getFile('image');
        $hasImage = $image instanceof UploadedFile && $image->getError() !== UPLOAD_ERR_NO_FILE;
        $response = $this->rejectOversizedUpload($image, $hasImage, "products/{$id}/edit");

        if ($response !== null) {
            return $response;
        }

        $validation = service('validation');
        $validation->setRules($this->productRules($hasImage));

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url("products/{$id}/edit"))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $newImage = null;

        if ($hasImage) {
            try {
                $newImage = $this->prepareImage($image);
            } catch (Throwable) {
                return redirect()->to(site_url("products/{$id}/edit"))
                    ->withInput()
                    ->with('errors', ['image' => 'The product image could not be prepared. Please use another JPG or PNG image.']);
            }
        }

        $data = [
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => $this->normalizePrice((string) $this->request->getPost('price')),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
        ];

        if ($newImage !== null) {
            $data['image'] = $newImage;
        }

        try {
            $productModel->update($id, $data);
        } catch (Throwable $exception) {
            if ($newImage !== null) {
                $this->removeImage($newImage);
            }

            throw $exception;
        }

        $previousImage = $product['image'] ?? null;

        if ($newImage !== null && is_string($previousImage) && $previousImage !== '' && $previousImage !== $newImage) {
            $this->removeImage($previousImage);
        }

        return redirect()->to(site_url('products'))
            ->with('success', 'Product updated successfully.');
    }

    public function archive(int $id): RedirectResponse
    {
        $productModel = new ProductModel();

        if ($productModel->findActive($id) === null) {
            throw PageNotFoundException::forPageNotFound('Active product not found.');
        }

        $productModel->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('products'))
            ->with('success', 'Product archived without changing historical sales.');
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function productRules(bool $hasImage): array
    {
        $rules = [
            'name' => [
                'label' => 'Product name',
                'rules' => 'required|max_length[100]',
            ],
            'price' => [
                'label' => 'Price',
                'rules' => 'required|regex_match[/^\d{1,8}(?:\.\d{1,2})?$/]',
                'errors' => ['regex_match' => 'Enter a nonnegative price with no more than two decimal places.'],
            ],
            'stock_quantity' => [
                'label' => 'Stock quantity',
                'rules' => 'required|integer|greater_than_equal_to[0]',
            ],
        ];

        if ($hasImage) {
            $rules['image'] = [
                'label' => 'Product image',
                'rules' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpeg,image/png]|ext_in[image,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Please choose a valid product image.',
                    'max_size'  => 'The product image must not exceed 2 MB.',
                    'is_image'  => 'The selected file must be a genuine image.',
                    'mime_in'   => 'Only JPG and PNG product images are allowed.',
                    'ext_in'    => 'Only JPG and PNG product images are allowed.',
                ],
            ];
        }

        return $rules;
    }

    private function rejectOversizedUpload(?UploadedFile $image, bool $hasImage, string $returnPath): ?RedirectResponse
    {
        if ($hasImage && $image !== null && in_array($image->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            return redirect()->to(site_url($returnPath))
                ->withInput()
                ->with('errors', ['image' => 'The product image must not exceed 2 MB.']);
        }

        return null;
    }

    private function prepareImage(UploadedFile $image): string
    {
        $directory = FCPATH . self::IMAGE_DIRECTORY;

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the product image directory.');
        }

        $size = getimagesize($image->getTempName());

        if ($size === false || $size[0] < 1 || $size[1] < 1) {
            throw new RuntimeException('Unable to read the product image.');
        }

        $filename = $image->getRandomName();
        $path     = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            service('image', 'gd')
                ->withFile($image->getTempName())
                ->fit(720, 540, 'center')
                ->save($path, 86);
        } catch (Throwable $exception) {
            if (is_file($path)) {
                unlink($path);
            }

            throw $exception;
        }

        if (! is_file($path)) {
            throw new RuntimeException('The prepared product image was not created.');
        }

        return $filename;
    }

    private function imageUrl(?string $filename): string
    {
        if ($filename !== null && $filename !== '' && basename($filename) === $filename) {
            $path = FCPATH . self::IMAGE_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

            if (is_file($path)) {
                return base_url(self::IMAGE_DIRECTORY . '/' . rawurlencode($filename));
            }
        }

        return base_url(self::PLACEHOLDER_PATH);
    }

    private function removeImage(string $filename): void
    {
        if (basename($filename) !== $filename) {
            return;
        }

        $path = FCPATH . self::IMAGE_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function normalizePrice(string $price): string
    {
        [$whole, $fraction] = array_pad(explode('.', trim($price), 2), 2, '');
        $whole    = ltrim($whole, '0');
        $whole    = $whole === '' ? '0' : $whole;
        $fraction = str_pad($fraction, 2, '0');

        return $whole . '.' . $fraction;
    }
}
