<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): ?ResponseInterface
    {
        $session = service('session');

        if ($session->get('isLoggedIn') === true && is_numeric($session->get('authUserId'))) {
            $user = (new UserModel())
                ->select('id')
                ->where('id', (int) $session->get('authUserId'))
                ->where('is_archived', 0)
                ->first();

            if ($user !== null) {
                return null;
            }

            $session->destroy();
        }

        if (strtolower($request->getMethod()) === 'get') {
            $path = '/' . ltrim($request->getUri()->getPath(), '/');

            if (preg_match('#^/(?:$|products(?:/|$)|customers(?:/|$)|users(?:/|$)|sales(?:/|$))#', $path) === 1) {
                $session->set('intendedPath', $path);
            }
        }

        helper('url');

        return redirect()->to(site_url('login'))
            ->with('authError', 'Please sign in to access that page.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
    {
        $response->noCache();
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', '0');

        return $response;
    }
}
