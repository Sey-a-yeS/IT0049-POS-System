<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = [
            ['id' => 'U001', 'username' => 'aramos', 'full_name' => 'Avery Ramos', 'role' => 'Store Manager', 'status' => 'Active'],
            ['id' => 'U002', 'username' => 'bcruz', 'full_name' => 'Bianca Cruz', 'role' => 'Cashier', 'status' => 'Active'],
            ['id' => 'U003', 'username' => 'dlim', 'full_name' => 'Dylan Lim', 'role' => 'Inventory Clerk', 'status' => 'Active'],
            ['id' => 'U004', 'username' => 'esalazar', 'full_name' => 'Elena Salazar', 'role' => 'Sales Associate', 'status' => 'Active'],
            ['id' => 'U005', 'username' => 'jvaldez', 'full_name' => 'Joaquin Valdez', 'role' => 'Cashier', 'status' => 'Inactive'],
        ];

        return view('users.index', ['users' => $users]);
    }
}
