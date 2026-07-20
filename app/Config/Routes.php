<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// main route
$routes->get('/', function() {
    return redirect()->to('/home');
});

// home route
$routes->get('/home', 'HomeController::index');

// auth controller
$routes->get('/login', 'AuthController::form');
$routes->post('/login', 'AuthController::login');