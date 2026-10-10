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
        $users = (new UserModel())
            ->select('id, username, full_name, avatar, created_at')
            ->where('is_archived', 0)
            ->orderBy('id', 'ASC')
            ->findAll();

        foreach ($users as &$user) {
            $user['avatar_url'] = $this->avatarUrl($user['avatar'] ?? null);
        }
        unset($user);

        return view('users/index', [
            'title'      => 'Staff',
            'activePage' => 'users',
            'users'      => $users,
        ]);
    }

    public function new(): string
    {
        return view('users/new', [
            'title'      => 'New Staff Member',
            'activePage' => 'users',
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        $avatar    = $this->request->getFile('avatar');
        $hasAvatar = $avatar instanceof UploadedFile && $avatar->getError() !== UPLOAD_ERR_NO_FILE;
        $response  = $this->rejectOversizedAvatar($avatar, $hasAvatar, 'users/new');

        if ($response !== null) {
            return $response;
        }

        $validation = service('validation');
        $validation->setRules($this->createRules($hasAvatar));

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('users/new'))
                ->with('staffOld', $this->nonSensitiveInput())
                ->with('errors', $validation->getErrors());
        }

        $filename = null;

        if ($hasAvatar) {
            try {
                $filename = $this->prepareAvatar($avatar);
            } catch (Throwable) {
                return redirect()->to(site_url('users/new'))
                    ->with('staffOld', $this->nonSensitiveInput())
                    ->with('errors', ['avatar' => 'The avatar could not be prepared. Please try another JPG or PNG image.']);
            }
        }

        try {
            (new UserModel())->insert([
                'username'    => trim((string) $this->request->getPost('username')),
                'full_name'   => trim((string) $this->request->getPost('full_name')),
                'password'    => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
                'avatar'      => $filename,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $exception) {
            if ($filename !== null) {
                $this->removePreparedAvatar($filename);
            }

            throw $exception;
        }

        return redirect()->to(site_url('users'))
            ->with('success', 'Staff account created successfully.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())
            ->select('id, username, full_name, avatar, created_at')
            ->where('is_archived', 0)
            ->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Active staff account not found.');
        }

        return view('users/edit', [
            'title'      => 'Edit Staff Member',
            'activePage' => 'users',
            'user'       => $user,
            'avatarUrl'  => $this->avatarUrl($user['avatar'] ?? null),
            'errors'     => session('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $userModel = new UserModel();
        $user      = $userModel
            ->select('id, username, full_name, avatar, created_at')
            ->where('is_archived', 0)
            ->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Active staff account not found.');
        }

        $avatar    = $this->request->getFile('avatar');
        $hasAvatar = $avatar instanceof UploadedFile && $avatar->getError() !== UPLOAD_ERR_NO_FILE;
        $response  = $this->rejectOversizedAvatar($avatar, $hasAvatar, "users/{$id}/edit");

        if ($response !== null) {
            return $response;
        }

        $password   = (string) $this->request->getPost('password');
        $validation = service('validation');
        $validation->setRules($this->updateRules($hasAvatar, $password !== ''));

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url("users/{$id}/edit"))
                ->with('staffOld', $this->nonSensitiveInput())
                ->with('errors', $validation->getErrors());
        }

        $username  = trim((string) $this->request->getPost('username'));
        $duplicate = $userModel->where('username', $username)->where('id !=', $id)->first();

        if ($duplicate !== null) {
            return redirect()->to(site_url("users/{$id}/edit"))
                ->with('staffOld', $this->nonSensitiveInput())
                ->with('errors', ['username' => 'That username is already in use.']);
        }

        $newAvatar = null;

        if ($hasAvatar) {
            try {
                $newAvatar = $this->prepareAvatar($avatar);
            } catch (Throwable) {
                return redirect()->to(site_url("users/{$id}/edit"))
                    ->with('staffOld', $this->nonSensitiveInput())
                    ->with('errors', ['avatar' => 'The avatar could not be prepared. Please try another JPG or PNG image.']);
            }
        }

        $data = [
            'username'  => $username,
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($newAvatar !== null) {
            $data['avatar'] = $newAvatar;
        }

        try {
            $userModel->update($id, $data);
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
            ->with('success', 'Staff account updated successfully.');
    }

    public function archive(int $id): RedirectResponse
    {
        if ((int) session('authUserId') === $id) {
            return redirect()->to(site_url('users'))
                ->with('error', 'You cannot archive the staff account currently signed in.');
        }

        $userModel = new UserModel();

        if ($userModel->findActive($id) === null) {
            throw PageNotFoundException::forPageNotFound('Active staff account not found.');
        }

        $userModel->update($id, ['is_archived' => 1]);

        return redirect()->to(site_url('users'))
            ->with('success', 'Staff account archived without changing historical sales.');
    }

    /** @return array<string, array<string, mixed>> */
    private function createRules(bool $hasAvatar): array
    {
        $rules = $this->identityRules();
        $rules['username']['rules'] .= '|is_unique[users.username]';
        $rules['username']['errors'] = ['is_unique' => 'That username is already in use.'];
        $rules += $this->passwordRules();

        if ($hasAvatar) {
            $rules['avatar'] = $this->avatarRule();
        }

        return $rules;
    }

    /** @return array<string, array<string, mixed>> */
    private function updateRules(bool $hasAvatar, bool $hasPassword): array
    {
        $rules = $this->identityRules();

        if ($hasPassword) {
            $rules += $this->passwordRules();
        }

        if ($hasAvatar) {
            $rules['avatar'] = $this->avatarRule();
        }

        return $rules;
    }

    /** @return array<string, array<string, mixed>> */
    private function identityRules(): array
    {
        return [
            'username' => ['label' => 'Username', 'rules' => 'required|max_length[50]'],
            'full_name' => ['label' => 'Full name', 'rules' => 'required|max_length[100]'],
        ];
    }

    /** @return array<string, array<string, mixed>> */
    private function passwordRules(): array
    {
        return [
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[12]|max_length[255]|matches[password_confirm]',
            ],
            'password_confirm' => [
                'label' => 'Password confirmation',
                'rules' => 'required|max_length[255]',
            ],
        ];
    }

    /** @return array<string, mixed> */
    private function avatarRule(): array
    {
        return [
            'label' => 'Avatar',
            'rules' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]',
            'errors' => [
                'uploaded' => 'Please choose a valid image to upload.',
                'max_size'  => 'The avatar must not exceed 2 MB.',
                'is_image'  => 'The selected file must be a genuine image.',
                'mime_in'   => 'Only JPG and PNG images are allowed.',
                'ext_in'    => 'Only JPG and PNG images are allowed.',
            ],
        ];
    }

    private function rejectOversizedAvatar(?UploadedFile $avatar, bool $hasAvatar, string $returnPath): ?RedirectResponse
    {
        if ($hasAvatar && $avatar !== null && in_array($avatar->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            return redirect()->to(site_url($returnPath))
                ->with('staffOld', $this->nonSensitiveInput())
                ->with('errors', ['avatar' => 'The avatar must not exceed 2 MB.']);
        }

        return null;
    }

    private function prepareAvatar(UploadedFile $avatar): string
    {
        $directory = FCPATH . self::AVATAR_DIRECTORY;

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the avatar upload directory.');
        }

        $size = getimagesize($avatar->getTempName());

        if ($size === false || $size[0] < 1 || $size[1] < 1) {
            throw new RuntimeException('Unable to read the uploaded image.');
        }

        $filename = $avatar->getRandomName();
        $path     = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            service('image', 'gd')->withFile($avatar->getTempName())->fit(256, 256, 'center')->save($path, 85);
        } catch (Throwable $exception) {
            if (is_file($path)) {
                unlink($path);
            }

            throw $exception;
        }

        if (! is_file($path)) {
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

    /** @return array{username: string, full_name: string} */
    private function nonSensitiveInput(): array
    {
        return [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];
    }
}
