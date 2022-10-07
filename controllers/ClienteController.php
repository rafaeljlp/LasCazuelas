<?php

namespace Controllers;

use MVC\Router;
use Model\Cliente;

// libreria para el manejo de para subir imagenes imagenes en PHP con Intervention Image
// use Intervention\Image\ImageManagerStatic as Image;

class ClienteController {

    public static function crear(Router $router) {

        $cliente = new Cliente;

        $errores = Cliente::getErrores();        

        if( $_SERVER["REQUEST_METHOD"] === "POST" ) {   

            // Crear una nueva instancia
            $cliente = new Cliente($_POST['cliente']);
    
            // $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // if($_FILES['cliente']['tmp_name']['imagen']) { // si existe la imagen se setea
            //     $image = Image::make($_FILES['cliente']['tmp_name']['imagen'])->fit(800 , 600);
            //     $cliente->setImage($nombreImagen); // en la DB se guarda el nombre de la imagen no la imagen ($image)                
            // }
            
            // Validar que no hayan campos vacíos
            $errores = $cliente->validar();
    
            // No hay errores
            if(empty($errores)) {

                // Crear la carpeta para subir imagenes
                // if(!is_dir(CARPETA_IMAGENES)) {                
                //     mkdir(CARPETA_IMAGENES);
                // }

                // // Guarda la imagen en el servidor
                // $image->save(CARPETA_IMAGENES . $nombreImagen);

                $cliente->guardar();
            }        
        }
       
        $router->render('clientes/crear' , [
            'cliente' => $cliente,
            'errores' => $errores            
        ]);
        
    }

    public static function actualizar(Router $router) {

        $id = validarORedireccionar('/admin');              

        // Obtener datos del cliente a actualizar
        $cliente = Cliente::find($id);

        $errores = Cliente::getErrores();  

        if( $_SERVER["REQUEST_METHOD"] === "POST" ) {

            // Asignar los valores
            $args = $_POST['cliente'];        
            
            // Sincronizar el objeto en memoria con lo que el usuario escribio
            $cliente->sincronizar($args);
    
            // Validación - se cambia validar debajo de la asignación del nombre
            // $errores = $cliente->validar();

            //** Subida de archivos **

            // Generar un nombre único para cada imagen evitando que el nombre se repita o existan dos archivos con el mismo nombre
            // $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg"; 
            
            /* 
            IMPORTANTE para las imagenes no puede faltar enctype="multipart/form-data en el form del archivo:
            /views/clientes/actualizar.php
            <form class="formulario" method="POST" enctype="multipart/form-data">
            */
            
            //debuguear($_FILES['cliente']['tmp_name']['imagen']);

            // if($_FILES['cliente']['tmp_name']['imagen']) { // si existe la imagen se setea
            //     $image = Image::make($_FILES['cliente']['tmp_name']['imagen'])->fit(200 , 300);
            //     $cliente->setImage($nombreImagen); // en la DB se guarda el nombre de la imagen no la imagen ($image)
            // } 
            
            // Validación
            $errores = $cliente->validar();
    
            if(empty($errores)) {

                // if($_FILES['cliente']['tmp_name']['imagen']) { // si hay una nueva imagen ó si existe la imagen                    
                //     // Almacenar la imagen
                //     $image->save(CARPETA_IMAGENES . $nombreImagen);
                // }

                $cliente->guardar();
            }
        }
        
        $router->render('clientes/actualizar' , [
            'cliente' => $cliente,
            'errores' => $errores          
        ]);
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Validar el id
            $id = $_POST['id'];
            $id = filter_var($id , FILTER_VALIDATE_INT);

            if($id) {
                // Valida el tipo a eliminar
                $tipo = $_POST['tipo'];

                // debuguear($tipo);

                if(validarTipoContenido($tipo)) {
                    $cliente = Cliente::find($id);

                    // debuguear($cliente);

                    $cliente->eliminar();
                }
            }

        }
    }

}

