<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Login
$routes->get('/', 'Home::index');
$routes->get('/client', 'Home::client');
$routes->get('/accueil', 'Home::accueil');
$routes->get('/operator', 'Home::operator');

$routes->post('/login/auth', 'LoginController::auth');

// Operation

    // Depot 
$routes->post('/depot', 'MouvementController::depot');

    // Retrait 
$routes->post('/retrait', 'MouvementController::retrait');

    // Transfert
$routes->post('/transfert', 'MouvementController::transfert');
    
    // Historique 
$routes->post('/historique', 'MouvementController::historique');