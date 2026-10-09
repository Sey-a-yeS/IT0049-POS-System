<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    private const MAX_LOGIN_FAILURES = 5;
    private const LOCK_SECONDS = 60;

    public function login(): ResponseInterface
    {
        $session = service('session');

        if ($session->get('isLoggedIn') === true) {
            return redirect()->to(site_url('/'));
        }

        $body = view('auth/login', [
            'title'       => 'Staff Login',
            'activePage'  => 'login',
            'errors'      => $session->getFlashdata('errors') ?? [],
            'authError'   => $session->getFlashdata('authError'),
            'oldUsername' => $session->getFlashdata('oldUsername') ?? '',
        ]);

        return $this->response->noCache()->setBody($body);
    }

    public function authenticate(): RedirectResponse
    {
        $session  = service('session');
        $username = trim((string) $this->request->getPost('username'));

        $validation = service('validation');
        $validation->setRules([
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[50]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|max_length[255]',
            ],
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->to(site_url('login'))
                ->with('oldUsername', $username)
                ->with('errors', $validation->getErrors());
        }

        $lockedUntil = (int) ($session->get('loginLockedUntil') ?? 0);

        if ($lockedUntil > time()) {
            return redirect()->to(site_url('login'))
                ->with('oldUsername', $username)
                ->with('authError', 'Too many unsuccessful attempts. Please wait one minute and try again.');
        }

        if ($lockedUntil !== 0) {
            $session->remove(['loginFailures', 'loginLockedUntil']);
        }

        $userModel = new UserModel();
        $user      = $userModel
            ->select('id, username, password')
            ->where('username', $username)
            ->where('is_archived', 0)
            ->first();

        $password   = (string) $this->request->getPost('password');
        $storedHash = is_array($user) ? (string) ($user['password'] ?? '') : '';
        $hashToTest = $storedHash !== ''
            ? $storedHash
            : password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

        if (! password_verify($password, $hashToTest) || $storedHash === '' || $user === null) {
            return $this->rejectCredentials($username);
        }

        if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
            $userModel->update((int) $user['id'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        $intendedPath = $session->get('intendedPath');

        $session->remove(['loginFailures', 'loginLockedUntil', 'intendedPath']);
        $session->regenerate(true);
        $session->set([
            'authUserId'   => (int) $user['id'],
            'authUsername' => (string) $user['username'],
            'isLoggedIn'   => true,
        ]);

        if (! is_string($intendedPath) || preg_match('#^/(?:$|products(?:/|$)|customers(?:/|$)|users(?:/|$)|sales(?:/|$))#', $intendedPath) !== 1) {
            $intendedPath = '/';
        }

        return redirect()->to(site_url(ltrim($intendedPath, '/')));
    }

    public function logout(): RedirectResponse
    {
        $session = service('session');
        $session->remove([
            'authUserId',
            'authUsername',
            'isLoggedIn',
            'intendedPath',
            'loginFailures',
            'loginLockedUntil',
        ]);
        $session->destroy();

        return redirect()->to(site_url('login'));
    }

    private function rejectCredentials(string $username): RedirectResponse
    {
        $session  = service('session');
        $failures = (int) ($session->get('loginFailures') ?? 0) + 1;

        if ($failures >= self::MAX_LOGIN_FAILURES) {
            $session->set([
                'loginFailures'    => 0,
                'loginLockedUntil' => time() + self::LOCK_SECONDS,
            ]);
        } else {
            $session->set('loginFailures', $failures);
        }

        return redirect()->to(site_url('login'))
            ->with('oldUsername', $username)
            ->with('authError', 'The username or password is incorrect.');
    }
}
