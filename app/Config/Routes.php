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

        // CRUD Menu Makanan & Minuman
        $routes->get('menu', 'Admin\MenuController::index');
        $routes->get('menu/create', 'Admin\MenuController::create');
        $routes->post('menu/store', 'Admin\MenuController::store');
        $routes->get('menu/edit/(:num)', 'Admin\MenuController::edit/$1');
        $routes->post('menu/update/(:num)', 'Admin\MenuController::update/$1');
        $routes->get('menu/delete/(:num)', 'Admin\MenuController::delete/$1');
    });
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
