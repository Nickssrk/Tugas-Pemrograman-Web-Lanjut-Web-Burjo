<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\OrderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $menuModel  = new MenuModel();
        $orderModel = new OrderModel();

        $data = [
            'title'           => 'Dashboard Admin',
            // Statistik menu
            'totalMenu'       => $menuModel->countAllResults(),
            'totalMakanan'    => $menuModel->countByCategory('makanan'),
            'totalMinuman'    => $menuModel->countByCategory('minuman'),
            'totalHabis'      => $menuModel->where('status', 'habis')->countAllResults(),
            // Statistik pesanan
            'totalPesanan'    => $orderModel->countAll(),
            'pesananHariIni'  => $orderModel->countToday(),
            'pesananMenunggu' => $orderModel->countByStatus('menunggu'),
            'pesananLunas'    => $orderModel->countByStatus('lunas'),
        ];

        return view('admin/dashboard', $data);
    }
}
