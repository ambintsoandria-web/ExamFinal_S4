<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'ClientController::login');
$routes->get('connexion', 'ClientController::login');
$routes->post('connexion/client', 'ClientController::authenticate');
$routes->get('connexion/operateur', 'OperateurController::login');
$routes->post('connexion/operateur', 'OperateurController::authenticate');
$routes->post('deconnexion', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('client/espace', 'ClientController::dashboard', ['filter' => 'clientAuth']);
$routes->get('operateur/espace', 'OperateurController::dashboard', ['filter' => 'operateurAuth']);
$routes->get('operateur/frais', 'FraisController::index', ['filter' => 'operateurAuth']);
