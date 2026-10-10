<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Services\SaleService;
use CodeIgniter\HTTP\RedirectResponse;
use DomainException;
use Throwable;

class Sales extends BaseController
{
    public function index(): string
    {
        return view('sales/index', [
            'title'      => 'Sales History',
            'activePage' => 'sales',
            'sales'      => (new SaleModel())->findHistory(),
        ]);
    }

    public function new(): string
    {
        $saleNonce = bin2hex(random_bytes(32));
        session()->set('saleFormNonce', $saleNonce);

        return view('sales/new', $this->formData(session('errors') ?? []) + [
            'saleNonce' => $saleNonce,
        ]);
    }

    public function create(): RedirectResponse
    {
        $submittedNonce = (string) $this->request->getPost('sale_nonce');
        $expectedNonce  = session('saleFormNonce');

        if (! is_string($expectedNonce) || $submittedNonce === '' || ! hash_equals($expectedNonce, $submittedNonce)) {
            return redirect()->to(site_url('sales/new'))
                ->with('errors', ['sale' => 'This sale form has expired or was already submitted. Please review the transaction and try again.']);
        }

        $validation = service('validation');
        $validation->setRules([
            'product_id' => [
                'label' => 'Product',
                'rules' => 'required|integer|greater_than[0]',
            ],
            'customer_id' => [
                'label' => 'Customer',
                'rules' => 'permit_empty|integer|greater_than[0]',
            ],
            'quantity' => [
                'label' => 'Quantity',
                'rules' => 'required|integer|greater_than[0]',
            ],
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('sales/new'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $customerValue = trim((string) $this->request->getPost('customer_id'));

        try {
            $result = (new SaleService())->record(
                (int) $this->request->getPost('product_id'),
                $customerValue === '' ? null : (int) $customerValue,
                (int) $this->request->getPost('quantity'),
                (int) session('authUserId'),
            );
        } catch (DomainException $exception) {
            return redirect()->to(site_url('sales/new'))
                ->withInput()
                ->with('errors', ['sale' => $exception->getMessage()]);
        } catch (Throwable $exception) {
            log_message('error', 'Sale transaction failed: {message}', ['message' => $exception->getMessage()]);

            return redirect()->to(site_url('sales/new'))
                ->withInput()
                ->with('errors', ['sale' => 'The sale could not be completed. No stock was changed.']);
        }

        session()->remove('saleFormNonce');

        return redirect()->to(site_url('sales'))
            ->with('success', 'Sale #' . $result['id'] . ' recorded successfully for ₱' . number_format((float) $result['total_price'], 2) . '.');
    }

    /** @param array<string, string> $errors */
    private function formData(array $errors): array
    {
        return [
            'title'      => 'Record Sale',
            'activePage' => 'record-sale',
            'products'   => (new ProductModel())
                ->where('is_archived', 0)
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),
            'customers'  => (new CustomerModel())->findAllActive(),
            'errors'     => $errors,
        ];
    }
}
