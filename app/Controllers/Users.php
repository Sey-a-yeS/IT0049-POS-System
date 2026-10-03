<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RedirectResponse;
use RuntimeException;
use Throwable;

class Users extends BaseController
{
    private const AVATAR_DIRECTORY = 'uploads/avatars';
    private const PLACEHOLDER_PATH = 'assets/images/avatar-placeholder.svg';

    public function index(): string
    {
        $userModel = new UserModel();
        $users     = $userModel->orderBy('id', 'ASC')->findAll();

        foreach ($users as &$user) {
            $user['avatar_url'] = $this->avatarUrl($user['avatar'] ?? null);
        }
        unset($user);

        return view('users/index', [
            'title'      => 'User Accounts',
            'activePage' => 'users',
            'users'      => $users,
        ]);
    }

    public function new(): string
    {
        return view('users/new', [
            'title'      => 'New User',
            'activePage' => 'users',
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        $validation = service('validation');
        $validation->setRules($this->createRules());

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('users/new'))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'username'   => trim((string) $this->request->getPost('username')),
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('users'))
            ->with('success', 'User created successfully.');
    }

    public function edit(int $id): string
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/edit', [
            'title'      => 'Edit User',
            'activePage' => 'users',
            'user'       => $user,
            'avatarUrl'  => $this->avatarUrl($user['avatar'] ?? null),
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $avatar    = $this->request->getFile('avatar');
        $hasAvatar = $avatar instanceof UploadedFile && $avatar->getError() !== UPLOAD_ERR_NO_FILE;
        $rules     = $this->updateRules($hasAvatar);

        if ($hasAvatar && in_array($avatar->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            return redirect()->to(site_url("users/{$id}/edit"))
                ->withInput()
                ->with('errors', ['avatar' => 'The avatar must not exceed 2 MB.']);
        }

        $validation = service('validation');
        $validation->setRules($rules);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url("users/{$id}/edit"))
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $duplicate = $userModel->where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($duplicate !== null) {
            return redirect()->to(site_url("users/{$id}/edit"))
                ->withInput()
                ->with('errors', ['username' => 'That username is already in use.']);
        }

        $newAvatar = null;

        if ($hasAvatar) {
            try {
                $newAvatar = $this->prepareAvatar($avatar);
            } catch (Throwable) {
                return redirect()->to(site_url("users/{$id}/edit"))
                    ->withInput()
                    ->with('errors', ['avatar' => 'The avatar could not be prepared. Please try another JPG or PNG image.']);
            }
        }

        $updateData = [
            'username'  => $username,
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        if ($newAvatar !== null) {
            $updateData['avatar'] = $newAvatar;
        }

        try {
            $userModel->update($id, $updateData);
        } catch (Throwable $exception) {
            if ($newAvatar !== null) {
                $this->removePreparedAvatar($newAvatar);
            }

            throw $exception;
        }

        $previousAvatar = $user['avatar'] ?? null;

        if ($newAvatar !== null && is_string($previousAvatar) && $previousAvatar !== '' && $previousAvatar !== $newAvatar) {
            $this->removePreparedAvatar($previousAvatar);
        }

        return redirect()->to(site_url('users'))
            ->with('success', 'User updated successfully.');
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function createRules(): array
    {
        return [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|max_length[50]|is_unique[users.username]',
                'errors' => ['is_unique' => 'That username is already in use.'],
            ],
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
        ];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function updateRules(bool $hasAvatar): array
    {
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[50]',
            ],
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
        ];

        if ($hasAvatar) {
            $rules['avatar'] = [
                'label' => 'Avatar',
                'rules' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Please choose a valid image to upload.',
                    'max_size'  => 'The avatar must not exceed 2 MB.',
                    'is_image'  => 'The selected file must be a valid image.',
                    'mime_in'   => 'Only JPG and PNG images are allowed.',
                    'ext_in'    => 'Only JPG and PNG images are allowed.',
                ],
            ];
        }

        return $rules;
    }

    private function prepareAvatar(UploadedFile $avatar): string
    {
        $uploadDirectory = FCPATH . self::AVATAR_DIRECTORY;

        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0755, true) && ! is_dir($uploadDirectory)) {
            throw new RuntimeException('Unable to create the avatar upload directory.');
        }

        $imageSize = getimagesize($avatar->getTempName());

        if ($imageSize === false) {
            throw new RuntimeException('Unable to read the uploaded image.');
        }

        $thumbnailSize = min(256, $imageSize[0], $imageSize[1]);

        if ($thumbnailSize < 1) {
            throw new RuntimeException('The uploaded image has invalid dimensions.');
        }

        $filename        = $avatar->getRandomName();
        $destinationPath = $uploadDirectory . DIRECTORY_SEPARATOR . $filename;

        try {
            service('image', 'gd')
                ->withFile($avatar->getTempName())
                ->fit($thumbnailSize, $thumbnailSize, 'center')
                ->save($destinationPath, 85);
        } catch (Throwable $exception) {
            if (is_file($destinationPath)) {
                unlink($destinationPath);
            }

            throw $exception;
        }

        if (! is_file($destinationPath)) {
            throw new RuntimeException('The prepared avatar was not created.');
        }

        return $filename;
    }

    private function avatarUrl(?string $filename): string
    {
        if ($filename !== null && $filename !== '' && basename($filename) === $filename) {
            $path = FCPATH . self::AVATAR_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

            if (is_file($path)) {
                return base_url(self::AVATAR_DIRECTORY . '/' . rawurlencode($filename));
            }
        }

        return base_url(self::PLACEHOLDER_PATH);
    }

    private function removePreparedAvatar(string $filename): void
    {
        if (basename($filename) !== $filename) {
            return;
        }

        $path = FCPATH . self::AVATAR_DIRECTORY . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            unlink($path);
        }
    }
}
