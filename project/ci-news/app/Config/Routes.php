<?php

use App\Controllers\ConnexionController;
use App\Controllers\Home;
use App\Controllers\InscriptionController;
use App\Controllers\TerminalController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);

use App\Controllers\Pages;

$routes->get('logout', [ConnexionController::class, 'logout']);
$routes->post('command', [TerminalController::class, 'command']);
$routes->get('pages', [Pages::class, 'index']);
$routes->addRedirect('index.php/inscription', 'view' );
$routes->post('test/insc', [InscriptionController::class,'verifierInfo'], ['as' => 'inscrire']);
$routes->post('connexion', [ConnexionController::class,'verifierInfo'] );
$routes->get('(:segment)', [Pages::class, 'view'], ['as'=> 'view']);


