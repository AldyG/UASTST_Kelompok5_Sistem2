<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Mahasiswa');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Mahasiswa::login'); // Set default route to login

$routes->group('mahasiswa', function ($routes) {
    $routes->add('login', 'Mahasiswa::login');
    $routes->add('login_process', 'Mahasiswa::login_process');
    $routes->add('logout', 'Mahasiswa::logout');
    $routes->add('index', 'Mahasiswa::index');
});