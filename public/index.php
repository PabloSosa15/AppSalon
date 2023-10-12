<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\AppointmentController;
use Controllers\ServiceController;

$router = new Router();

// Log in
$router->get('/', [LoginController::class,'login']);
$router->post('/', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);

// Recover password
$router->get('/forget' , [LoginController::class, 'forget']);
$router->post('/forget' , [LoginController::class, 'forget']);
$router->get('/recover' , [LoginController::class, 'recover']);
$router->post('/recover' , [LoginController::class, 'recover']);

// Create account
$router->get('/create-account' , [LoginController::class, 'create']);
$router->post('/create-account' , [LoginController::class, 'create']);

//Confirmate account
$router->get('/confirm-account', [LoginController::class, 'confirmate']);
$router->get('/message', [LoginController::class, 'message']);

//Private Area
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// API for appointment
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointments', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// Service CRUD
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/create', [ServiceController::class, 'create']);
$router->post('/services/create', [ServiceController::class, 'create']);
$router->get('/services/update', [ServiceController::class, 'update']);
$router->post('/services/update', [ServiceController::class, 'update']);
$router->post('/services/delete', [ServiceController::class, 'delete']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkRoutes();