<?php

use App\Controllers\InscriptionController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

use App\Controllers\Pages;

$routes->get('pages', [Pages::class, 'index']);
$routes->addRedirect('index.php/inscription', 'view' );
$routes->post('test/insc', [InscriptionController::class,'verifierInfo'], ['as' => 'inscrire']);
$routes->get('(:segment)', [Pages::class, 'view'], ['as'=> 'view']);


