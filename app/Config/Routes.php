<?php

use CodeIgniter\Router\RouteCollection;


// main route
$routes->get('/', function() {
    return redirect()->to('/home');
});

// home route
$routes->get('/home', 'HomeController::index');

// frais routes
$routes->get('/frais', 'FraisController::list');
$routes->get('/frais/insert-form', 'FraisController::insert_form');
$routes->post('/frais/insert', 'FraisController::save');
$routes->get('/frais/edit-form/(:num)', 'FraisController::edit_form/$1');
$routes->post('/frais/update/(:num)', 'FraisController::update/$1');
$routes->get('/frais/delete/(:num)', 'FraisController::delete/$1');
