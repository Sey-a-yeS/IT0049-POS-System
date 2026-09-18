<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = [
            [
                'full_name' => 'Angela Reyes',
                'email'     => 'angela.reyes@example.com',
                'phone'     => '+63 917 245 8103',
            ],
            [
                'full_name' => 'Marco Villanueva',
                'email'     => 'marco.villanueva@example.com',
                'phone'     => '+63 918 632 4751',
            ],
            [
                'full_name' => 'Sofia Mendoza',
                'email'     => 'sofia.mendoza@example.com',
                'phone'     => '+63 905 381 9264',
            ],
            [
                'full_name' => 'Daniel Lim',
                'email'     => 'daniel.lim@example.com',
                'phone'     => '+63 922 714 5386',
            ],
            [
                'full_name' => 'Bianca Santos',
                'email'     => 'bianca.santos@example.com',
                'phone'     => '+63 916 849 2075',
            ],
        ];

        $data = [
            'title'      => 'Customer Accounts',
            'activePage' => 'customers',
            'customers'  => $customers,
        ];

        return view('customers/index', $data);
    }
}
