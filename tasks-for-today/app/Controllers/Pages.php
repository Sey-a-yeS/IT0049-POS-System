<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about(): string
    {
        $data = [
            'title'      => 'About',
            'activePage' => 'about',
        ];

        return view('about', $data);
    }
}
