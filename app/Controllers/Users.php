<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $data = [
            'title'      => 'Profile',
            'activePage' => 'profile',
            'user'       => $userModel->first(),
        ];

        return view('profile', $data);
    }
}
