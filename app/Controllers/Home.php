<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Home extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        $data = [
            'title'   => 'Warung Burjo Barokah',
            'makanan' => $menuModel->getByCategory('makanan'),
            'minuman' => $menuModel->getByCategory('minuman'),
        ];

        return view('home', $data);
    }
}
