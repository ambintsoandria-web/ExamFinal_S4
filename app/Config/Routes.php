<?php

use CodeIgniter\Router\RouteCollection;
error_reporting(E_ALL);
ini_set('display_errors', 1);

/** @var RouteCollection $routes */
$routes->get('/', 'UserController::index');
$routes->get('login', 'UserController::index');
$routes->post('login', 'UserController::login');
$routes->get('logout', 'UserController::logout', ['filter' => 'auth']);

$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'DashboardController::admin');
    $routes->get('demandes', 'DashboardController::demandesAdmin');
    $routes->get('employes', 'DashboardController::employes');
    $routes->post('employes/addEmp', 'AdminController::addEmp');
    $routes->get('employes/filter', 'DashboardController::filter');
    $routes->post('employes/deleteEmp', 'AdminController::deleteEmp');
    $routes->get('departement', 'DashboardController::departement');
    $routes->post('departement/addDepart', 'AdminController::addDepart');
    $routes->get('recherche', 'DashboardController::recherche');
    $routes->get('getEmpByDept', 'DashboardController::getEmpByDept');
    $routes->get('getCongeByEmp', 'DashboardController::getCongeByEmp');
});
$routes->group('rh', ['filter' => 'role:rh'], static function ($routes) {
    $routes->get('/', 'DashboardController::rh');
});

$routes->group('employe', ['filter' => 'role:employe'], static function ($routes) {
    $routes->get('/', 'DashboardController::employe');
    $routes->get('demandes', 'DashboardController::demandes');
    $routes->get('demandes/nouvelle', 'DashboardController::nouvelleDemande');
    $routes->post('createDemande', 'EmployeController::createDemande');
});
