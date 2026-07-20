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
    $routes->get('/transaction/form', 'TransactionController::form');
    $routes->post('/transaction', 'TransactionController::transaction');

    // opérateur (id_role = 1)
    $routes->group('', ['filter' => 'role:1'], function($routes) {
        $routes->get('/home', 'HomeController::index');

        $routes->get('/operateurs', 'OperateurController::list');
        $routes->get('/operateurs/insert-form', 'OperateurController::insert_form');
        $routes->post('/operateurs/insert', 'OperateurController::save');
        $routes->get('/operateurs/edit-form/(:num)', 'OperateurController::edit_form/$1');
        $routes->post('/operateurs/update/(:num)', 'OperateurController::update/$1');
        $routes->get('/operateurs/delete/(:num)', 'OperateurController::delete/$1');

        $routes->get('/prefix', 'PrefixConfigController::list');
        $routes->get('/prefix/insert-form', 'PrefixConfigController::insert_form');
        $routes->post('/prefix/insert', 'PrefixConfigController::save');
        $routes->get('/prefix/edit-form/(:num)', 'PrefixConfigController::edit_form/$1');
        $routes->post('/prefix/update/(:num)', 'PrefixConfigController::update/$1');
        $routes->get('/prefix/delete/(:num)', 'PrefixConfigController::delete/$1');

        $routes->get('/commission-config', 'CommissionConfigController::list');
        $routes->get('/commission-config/insert-form', 'CommissionConfigController::insert_form');
        $routes->post('/commission-config/insert', 'CommissionConfigController::save');
        $routes->get('/commission-config/edit-form/(:num)', 'CommissionConfigController::edit_form/$1');
        $routes->post('/commission-config/update/(:num)', 'CommissionConfigController::update/$1');
        $routes->get('/commission-config/delete/(:num)', 'CommissionConfigController::delete/$1');

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

        $routes->get('historique', 'ClientController::historique');
    });
});
