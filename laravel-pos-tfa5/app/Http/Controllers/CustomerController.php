<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = [
            ['id' => 'C001', 'full_name' => 'Amara Santos', 'email' => 'amara.santos@example.com', 'phone' => '+63 917 482 6301', 'joined' => '2026-01-12'],
            ['id' => 'C002', 'full_name' => 'Leo Navarro', 'email' => 'leo.navarro@example.com', 'phone' => '+63 918 735 2046', 'joined' => '2026-02-03'],
            ['id' => 'C003', 'full_name' => 'Mira Delgado', 'email' => 'mira.delgado@example.com', 'phone' => '+63 905 661 2984', 'joined' => '2026-03-18'],
            ['id' => 'C004', 'full_name' => 'Nico Reyes', 'email' => 'nico.reyes@example.com', 'phone' => '+63 922 147 8503', 'joined' => '2026-04-27'],
            ['id' => 'C005', 'full_name' => 'Tala Mendoza', 'email' => 'tala.mendoza@example.com', 'phone' => '+63 916 904 7128', 'joined' => '2026-05-09'],
        ];

        return view('customers.index', ['customers' => $customers]);
    }
}
