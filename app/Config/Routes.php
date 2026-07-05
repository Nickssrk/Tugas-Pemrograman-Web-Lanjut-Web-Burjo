<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions - Warung Burjo
 * --------------------------------------------------------------------
 */

// Halaman publik (tampilan menu burjo)
$routes->get('/', 'Home::index');

// Halaman Pemesanan — diakses pelanggan
$routes->get('pesan', 'PesananController::index');
$routes->post('pesan/checkout', 'PesananController::checkout');
$routes->get('pesan/status/(:segment)', 'PesananController::status/$1');
$routes->get('bayar/(:segment)', 'PesananController::bayar/$1');
$routes->post('bayar/konfirmasi/(:segment)', 'PesananController::konfirmasiBayar/$1');

// Cart
$routes->get('cart', 'CartController::index');
$routes->post('cart/insert', 'CartController::insert');
$routes->post('cart/update', 'CartController::update');
$routes->get('cart/remove/(:num)', 'CartController::remove/$1');
$routes->get('cart/destroy', 'CartController::destroy');

// Area Admin
$routes->group('admin', function ($routes) {
    // Login & logout (tidak butuh filter)
    $routes->get('login', 'Admin\AuthController::login');
    $routes->post('login', 'Admin\AuthController::attemptLogin');
    $routes->get('logout', 'Admin\AuthController::logout');

    // Halaman yang wajib login (dilindungi filter "adminauth")
        $routes->group('', ['filter' => 'adminauth'], function ($routes) {
        $routes->get('/', 'Admin\DashboardController::index');
        $routes->get('dashboard', 'Admin\DashboardController::index');

        $routes->get('pelanggan', 'Admin\PelangganController::index');
        $routes->get('pelanggan/create', 'Admin\PelangganController::create');
        $routes->post('pelanggan/store', 'Admin\PelangganController::store');
        $routes->get('pelanggan/edit/(:num)', 'Admin\PelangganController::edit/$1');
        $routes->post('pelanggan/update/(:num)', 'Admin\PelangganController::update/$1');
        $routes->get('pelanggan/delete/(:num)', 'Admin\PelangganController::delete/$1');
    $routes->get('menu/export-pdf', 'Admin\MenuController::exportPdf');

        // CRUD Menu Makanan & Minuman
        $routes->get('menu', 'Admin\MenuController::index');
        $routes->get('menu/create', 'Admin\MenuController::create');
        $routes->post('menu/store', 'Admin\MenuController::store');
        $routes->get('menu/edit/(:num)', 'Admin\MenuController::edit/$1');
        $routes->post('menu/update/(:num)', 'Admin\MenuController::update/$1');
        $routes->get('menu/delete/(:num)', 'Admin\MenuController::delete/$1');

        // Kelola Pesanan & Transaksi
        $routes->get('pesanan', 'Admin\PesananController::index');
        $routes->get('pesanan/detail/(:num)', 'Admin\PesananController::detail/$1');
        $routes->post('pesanan/update-status/(:num)', 'Admin\PesananController::updateStatus/$1');
        $routes->get('pesanan/qr-warung', 'Admin\PesananController::qrWarung');
    });
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
