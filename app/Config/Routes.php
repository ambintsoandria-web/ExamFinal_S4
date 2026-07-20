<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'ClientController::login');
$routes->get('connexion', 'ClientController::login');
$routes->post('connexion/client', 'ClientController::authenticate');
$routes->get('connexion/operateur', 'OperateurController::login');

$routes->post('connexion/operateur', 'OperateurController::authenticate'); //post
$routes->post('deconnexion', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('client/espace', 'ClientController::dashboard', ['filter' => 'clientAuth']);
$routes->get('operateur/espace', 'OperateurController::dashboard', ['filter' => 'operateurAuth']);

$routes->get('operateur/goToprefixe', 'OperateurController::goToPrefixe', ['filter' => 'operateurAuth']);
$routes->get('operateur/prefixes', 'OperateurController::goToPrefixe', ['filter' => 'operateurAuth']);
$routes->post('operateur/prefixes/add', 'OperateurController::addPrefixe', ['filter' => 'operateurAuth']);
