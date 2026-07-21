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
$routes->get('logout', 'LoginController::logout');

// Préfixes 
$routes->get('/prefixe', 'OperateurController::listPrefixe');
$routes->get('prefixe/ajouter', 'OperateurController::formAddPrefixe');
$routes->post('prefixe/create', 'OperateurController::createPrefixe');
$routes->get('prefixe/delete/(:num)', 'OperateurController::deletePrefixe/$1');
$routes->get('prefixe/edit/(:num)', 'OperateurController::formEditPrefixe/$1');
$routes->post('prefixe/update/(:num)', 'OperateurController::updatePrefixe/$1');

// Barèmes
$routes->get('bareme', 'OperateurController::listBareme');
$routes->get('bareme/ajouter', 'OperateurController::formAddBareme');
$routes->post('bareme/create', 'OperateurController::create');
$routes->get('bareme/edit/(:num)', 'OperateurController::formEditBareme/$1');
$routes->post('bareme/update/(:num)', 'OperateurController::update/$1');
$routes->get('bareme/delete/(:num)', 'OperateurController::delete/$1');

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

//Epargne
$routes->get('/epargne','EpargneController::index');

$routes->post('/ajout/epargne','EpargneController::ajout');