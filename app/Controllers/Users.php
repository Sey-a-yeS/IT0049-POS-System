<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        $users = [
            [
                'username'  => 'acruz',
                'full_name' => 'Andrea Cruz',
                'role'      => 'Store Manager',
            ],
            [
                'username'  => 'jnavarro',
                'full_name' => 'Joshua Navarro',
                'role'      => 'Cashier',
            ],
            [
                'username'  => 'mpascual',
                'full_name' => 'Mikaela Pascual',
                'role'      => 'Inventory Clerk',
            ],
            [
                'username'  => 'rgonzales',
                'full_name' => 'Rafael Gonzales',
                'role'      => 'Sales Associate',
            ],
            [
                'username'  => 'tgarcia',
                'full_name' => 'Trisha Garcia',
                'role'      => 'Cashier',
            ],
        ];

        $data = [
            'title'      => 'User Accounts',
            'activePage' => 'users',
            'users'      => $users,
        ];

        return view('users/index', $data);
    }
}
