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