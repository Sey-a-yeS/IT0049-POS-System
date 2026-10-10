<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::index', ['filter' => 'auth']);
$routes->get('/about', 'Pages::about');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::authenticate');
$routes->post('/logout', 'Auth::logout', ['filter' => 'auth']);

$routes->group('products', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('', 'Products::index');
    $routes->get('new', 'Products::new');
    $routes->post('', 'Products::create');
    $routes->get('(:num)/edit', 'Products::edit/$1');
    $routes->post('(:num)', 'Products::update/$1');
    $routes->post('(:num)/archive', 'Products::archive/$1');
});

$routes->group('customers', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('', 'Customers::index');
    $routes->get('new', 'Customers::new');
    $routes->post('', 'Customers::create');
    $routes->get('(:num)/edit', 'Customers::edit/$1');
    $routes->post('(:num)', 'Customers::update/$1');
    $routes->post('(:num)/archive', 'Customers::archive/$1');
});

$routes->group('users', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('', 'Users::index');
    $routes->get('new', 'Users::new');
    $routes->post('', 'Users::create');
    $routes->get('(:num)/edit', 'Users::edit/$1');
    $routes->post('(:num)', 'Users::update/$1');
    $routes->post('(:num)/archive', 'Users::archive/$1');
});

$routes->group('sales', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('', 'Sales::index');
    $routes->get('new', 'Sales::new');
    $routes->post('', 'Sales::create');
});
