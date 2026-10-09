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
            'user'       => $userModel
                ->select('id, username, full_name, email, created_at')
                ->first(),
        ];

        return view('profile', $data);
    }
}
