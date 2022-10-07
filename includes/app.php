<?php 

// APP.PHP ARCHIVO QUE MANDA A LLAMAR FUNCIONES BASES DE DATOS Y CLASES

// Incluyendo el Autoload de Composer
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // evita un error en caso de no existir el archivo .env

// app,php es el archivo principal para orquestar el llamado a funciones y clases   
require 'funciones.php';

// Conexión con la bases de datos
require 'config/databases.php';



// Conectarnos a la BD
$db = conectarDB();

// importar la clase propiedad con su repectivo namespace
use Model\ActiveRecord;

// no es necesario crear una nueva instancia de la propiedad solo el use
// $propiedad = new Propiedad; 

// var_dump( $propiedad );

// al ser un metódo estático no se requiere instanciar
ActiveRecord::setDB($db);
// todos los objetos que se vayan creando debajo de la clase de propiedad van a tener esta referencia a la BD
