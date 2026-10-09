<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class Pages extends BaseController
{
    public function index(): string
    {
        $productModel  = new ProductModel();
        $customerModel = new CustomerModel();
        $userModel     = new UserModel();
        $saleModel     = new SaleModel();

        $data = [
            'title'      => 'Dashboard',
            'activePage' => 'home',
            'metrics'    => [
                'products'  => $productModel->countActive(),
                'customers' => $customerModel->countActive(),
                'staff'     => $userModel->countActive(),
                'sales'     => $saleModel->countRecorded(),
                'low_stock' => $productModel->countLowStock(),
            ],
            'recentSales' => $saleModel->findHistory(5),
        ];

        return view('home', $data);
    }

    public function about(): string
    {
        $data = [
            'title'      => 'About',
            'activePage' => 'about',
        ];

        return view('about', $data);
    }
}
