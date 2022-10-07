<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

// require 'app.php'; // obtiene las propiedades de app.php

/* el parametro $inicio le llega true a la función solo desde el index.php, el resto de las páginas no lo envian 
   y la función se queda en false y no se muestra la foto que solo debe aparecer en el index.php */
function incluirTemplate( string $nombre , bool $inicio = false ) { 
    include TEMPLATES_URL . "/${nombre}.php"; // deben ser comillas dobles obligatoriamente
}

// para autenticación de usuarios
// function estaAutenticado() : bool
function estaAutenticado() {
    session_start(); // se debe iniciar sessión para tener acceso a la SuperGlobal $_SESSION

    // $auth = $_SESSION['login'] ?? false; // el login se creo asignandosélo a la SuperGLobal $_SESSION en la página login.php
    // if( $auth ) { // si esta autenticado se retorna true
    if( !$_SESSION['login'] ) { // si no se tiene la sesion de login (sino esta autenticado)
        // return true;
        header('Location: /'); // se redirecciona a la página principal
    }
    //return false; // sino se retorna false    
}

function debuguear( $variable ) {
    
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapar / Sanitizar
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
} 

// Validar tipo de Contenido
function validarTipoContenido( $tipo ) {
    $tipos = ['vendedor' , 'propiedad' , 'blog' , 'cliente'];

    // debuguear($tipos);

    return in_array($tipo , $tipos);
}

// Muestra los mensajes
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar( string $url) {
    
    // este paso es para evitar que el usuario vaya a estar escribiendo id's no validos en la la URL del navegador
    // Validar la URL por id válido      
    $id = $_GET['id']; // se captura el Id de la URL en el navegador
    
    $id = filter_var( $id , FILTER_VALIDATE_INT ); // se evalua el id escrito en la URL y si no es válido retorna FALSE
    
    /* si el id es FALSE, se redireccionara a la pagina principal enviado desde la funcion actualizar de la clase 
       del controlador ejemplo: PropiedadController.php */
    if( !$id ) { 
        header( "Location: ${url}" );
    }
    return $id;
}

function formatFecha( string $fecha ) {

    $fecha = date('d/m/Y' , strtotime( $fecha ) );
    return $fecha;
}
