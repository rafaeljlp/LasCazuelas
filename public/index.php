<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\BlogController;
use Controllers\LoginController;
// use Controllers\VendedorController;
use Controllers\ClienteController;
// use Controllers\PropiedadController;
use Controllers\PaginasController;
use Controllers\DashboardController;

$router = new Router();

// debuguear(PropiedadController::class);
// debuguear(ClienteController::class);

// Zona Privada (Se requiere Autenticación)
$router->get('/admin' , [DashboardController::class , 'index']);
/* $router->get('/propiedades/crear' , [PropiedadController::class , 'crear']);
$router->post('/propiedades/crear' , [PropiedadController::class , 'crear']);
$router->get('/propiedades/actualizar' , [PropiedadController::class , 'actualizar']);
$router->post('/propiedades/actualizar' , [PropiedadController::class , 'actualizar']);
$router->post('/propiedades/eliminar' , [PropiedadController::class , 'eliminar']);
*/
/*
$router->get('/vendedores/crear' , [VendedorController::class , 'crear']);
$router->post('/vendedores/crear' , [VendedorController::class , 'crear']);
$router->get('/vendedores/actualizar' , [VendedorController::class , 'actualizar']);
$router->post('/vendedores/actualizar' , [VendedorController::class , 'actualizar']);
$router->post('/vendedores/eliminar' , [VendedorController::class , 'eliminar']);
*/

$router->get('/clientes/crear' , [ClienteController::class , 'crear']);
$router->post('/clientes/crear' , [ClienteController::class , 'crear']);
$router->get('/clientes/actualizar' , [ClienteController::class , 'actualizar']);
$router->post('/clientes/actualizar' , [ClienteController::class , 'actualizar']);
$router->post('/clientes/eliminar' , [ClienteController::class , 'eliminar']);

$router->get('/blogs/crear' , [BlogController::class , 'crear']);
$router->post('/blogs/crear' , [BlogController::class , 'crear']);
$router->get('/blogs/actualizar' , [BlogController::class , 'actualizar']);
$router->post('/blogs/actualizar' , [BlogController::class , 'actualizar']);
$router->post('/blogs/eliminar' , [BlogController::class , 'eliminar']);


// Zona Pública
$router->get('/' , [PaginasController::class, 'index']); // estando en internet aqui tomaria el nombre del dominio
$router->get('/nosotros' , [PaginasController::class, 'nosotros']);
// $router->get('/propiedades' , [PaginasController::class, 'propiedades']);
// $router->get('/propiedad' , [PaginasController::class, 'propiedad']);
$router->get('/blogs' , [PaginasController::class, 'blogs']);
$router->get('/blog' , [PaginasController::class, 'blog']);
$router->get('/contacto' , [PaginasController::class, 'contacto']);
$router->post('/contacto' , [PaginasController::class, 'contacto']);

// Login y Autenticación
$router->get('/login', [LoginController::class, 'login']); // Mostrar el formulario
$router->post('/login', [LoginController::class, 'login']); // de tipo post para enviar datos al formulario
$router->get('/logout', [LoginController::class, 'logout']); // Cerrar sesión

$router->comprobarRutas();