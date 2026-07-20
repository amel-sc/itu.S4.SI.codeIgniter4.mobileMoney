<?php

use CodeIgniter\Router\RouteCollection;


// main route
$routes->get('/', function() {
    return redirect()->to('/home');
});

// home route
$routes->get('/home', 'HomeController::index');

// auth controller
$routes->get('/login', 'AuthController::form');
$routes->post('/login', 'AuthController::login');

// prefix routes
$routes->get('/prefix', 'PrefixConfigController::list');
$routes->get('/prefix/insert-form', 'PrefixConfigController::insert_form');
$routes->post('/prefix/insert', 'PrefixConfigController::save');
$routes->get('/prefix/edit-form/(:num)', 'PrefixConfigController::edit_form/$1');
$routes->post('/prefix/update/(:num)', 'PrefixConfigController::update/$1');
$routes->get('/prefix/delete/(:num)', 'PrefixConfigController::delete/$1');

// frais routes
$routes->get('/frais', 'FraisController::list');
$routes->get('/frais/insert-form', 'FraisController::insert_form');
$routes->post('/frais/insert', 'FraisController::save');
$routes->get('/frais/edit-form/(:num)', 'FraisController::edit_form/$1');
$routes->post('/frais/update/(:num)', 'FraisController::update/$1');
$routes->get('/frais/delete/(:num)', 'FraisController::delete/$1');
