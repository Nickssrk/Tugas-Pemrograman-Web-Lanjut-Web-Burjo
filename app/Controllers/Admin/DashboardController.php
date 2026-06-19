<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        $data = [
            'title'        => 'Dashboard Admin',
            'totalMenu'    => $menuModel->countAllResults(),
            'totalMakanan' => $menuModel->countByCategory('makanan'),
            'totalMinuman' => $menuModel->countByCategory('minuman'),
            'totalHabis'   => $menuModel->where('status', 'habis')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
