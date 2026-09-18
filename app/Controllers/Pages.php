<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'      => 'Home',
            'activePage' => 'home',
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
