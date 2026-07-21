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
$routes->get('/operation', 'Home::listOperation');

// Préfixes 
$routes->get('/prefixe', 'OperateurController::listPrefixe');
$routes->get('prefixe/ajouter', 'OperateurController::formAddPrefixe');
$routes->post('prefixe/create', 'OperateurController::createPrefixe');
$routes->get('prefixe/delete/(:num)', 'OperateurController::deletePrefixe/$1');

// (Optionnel pour plus tard) Afficher la page de modification
$routes->get('prefixe/edit/(:num)', 'OperateurController::formEditPrefixe/$1');

$routes->post('/login/auth', 'LoginController::auth');
$routes->post('/login/authOpe', 'LoginController::authOpe');

// Operation

    // Depot 
$routes->post('/depot', 'MouvementController::depot');

    // Retrait 
$routes->post('/retrait', 'MouvementController::retrait');

    // Transfert
$routes->post('/transfert', 'MouvementController::transfert');
    
    // Historique 
$routes->post('/historique', 'MouvementController::historique');