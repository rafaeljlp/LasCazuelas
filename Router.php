<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url , $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url , $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();
        $auth = $_SESSION['login'] ?? null;        

        // Arreglo de rutas protegidas...
        $rutas_protegidas = ['/admin', 
        //'/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', 
        // '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', 
        '/clientes/crear', '/clientes/actualizar', '/clientes/eliminar'];        

        $urlActual = ($_SERVER['REQUEST_URI'] === '') ? '/' :  $_SERVER['REQUEST_URI'] ;
        $method = $_SERVER['REQUEST_METHOD'];
            
        //dividimos la URL actual cada vez que exista un '?' eso indica que se están pasando variables por la url
        $splitURL = explode('?', $urlActual);
        // debuguear($splitURL);
        
        if ($method === 'GET') {
            $fn = $this->getRoutes[$splitURL[0]] ?? null; //$splitURL[0] contiene la URL sin variables 
        } else {
            $fn = $this->postRoutes[$splitURL[0]] ?? null;
        }

        // Proteger las rutas - in_array: permite revisar un elemento en un arreglo
        if( in_array( $urlActual , $rutas_protegidas ) && !$auth) { /* tiene que ser una ruta protegida y el user no tiene 
                                                                       que estar autenticado */ 
            header('Location: /');
        }

        // debuguear($this);        

        if($fn) {            
            // La URL existe y hay una función asociada            
            call_user_func($fn , $this);            
        } else {
            echo "Pagina No Encontrada";
        }
    }

    // Muestra una vista
    public function render($view , $datos = []) {        

        foreach($datos as $key => $value) {
            $$key = $value; // doble signo de dolar($$) significa: variable de variable (mantiene el nombre sin perder el valor)
        };

        ob_start(); // Inicia el almacenamiento en memoria

        include __DIR__ . "/views/$view.php"; // --> vista dinámica que inyecta contenido en $contenido de layout.php
      
        $contenido = ob_get_clean(); // Limpia Buffer: para no colapsar el servidor

        include __DIR__ . "/views/layout.php";
    }
}