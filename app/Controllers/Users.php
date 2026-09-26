<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $data = [
            'title'      => 'User Accounts',
            'activePage' => 'users',
            'users'      => $userModel->findAll(),
        ];

        return view('users/index', $data);
    }
}
