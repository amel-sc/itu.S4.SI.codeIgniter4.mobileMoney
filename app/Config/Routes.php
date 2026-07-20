<?php

use CodeIgniter\Router\RouteCollection;


// main route
$routes->get('/', function() {
    $user = session()->get('user');

    if (!$user) {
        return redirect()->to('/login');
    }

    return ((int) ($user['id_role'] ?? 0) === 2)
        ? redirect()->to('/client/dashboard')
        : redirect()->to('/home');
});

// auth controller
$routes->get('/login', 'AuthController::form');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// routes accessibles aux utilisateurs connectés (après login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // opérateur (id_role = 1)
    $routes->group('', ['filter' => 'role:1'], function($routes) {
        $routes->get('/home', 'HomeController::index');

        $routes->get('/transaction/form', 'TransactionController::form');
        $routes->post('/transaction', 'TransactionController::transaction');

        $routes->get('/prefix', 'PrefixConfigController::list');
        $routes->get('/prefix/insert-form', 'PrefixConfigController::insert_form');
        $routes->post('/prefix/insert', 'PrefixConfigController::save');
        $routes->get('/prefix/edit-form/(:num)', 'PrefixConfigController::edit_form/$1');
        $routes->post('/prefix/update/(:num)', 'PrefixConfigController::update/$1');
        $routes->get('/prefix/delete/(:num)', 'PrefixConfigController::delete/$1');

        $routes->get('/frais', 'FraisController::list');
        $routes->get('/frais/insert-form', 'FraisController::insert_form');
        $routes->post('/frais/insert', 'FraisController::save');
        $routes->get('/frais/edit-form/(:num)', 'FraisController::edit_form/$1');
        $routes->post('/frais/update/(:num)', 'FraisController::update/$1');
        $routes->get('/frais/delete/(:num)', 'FraisController::delete/$1');

        $routes->get('/gains', 'GainsController::index');
        $routes->get('/clients', 'ClientsController::index');
        $routes->get('/historique', 'HistoriqueController::index');
    });

    // client (id_role = 2)
    $routes->group('client', ['filter' => 'role:2'], function($routes) {
        $routes->get('', 'ClientController::dashboard');
        $routes->get('dashboard', 'ClientController::dashboard');

        $routes->get('depot', 'ClientController::formDepot');
        $routes->post('depot', 'ClientController::depot');

        $routes->get('retrait', 'ClientController::formRetrait');
        $routes->post('retrait', 'ClientController::retrait');

        $routes->get('transfert', 'ClientController::formTransfert');
        $routes->post('transfert', 'ClientController::transfert');

        $routes->get('historique', 'ClientController::historique');
    });
});
