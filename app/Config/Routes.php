<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Login
$routes->get('/accueil', 'Home::accueil');
$routes->post('/login/auth', 'LoginController::auth');

// Operation

    // Depot 
$routes->post('/depot', 'MouvementController::depot');

    // Retrait 
$routes->post('/retrait', 'MouvementController::retrait');

    // Transfert
$routes->post('/transfert', 'MouvementController::transfert');