<?php


namespace Controllers;

// ESTAS DOS LINEAS DESACTIVAN LOS MENSAJES DE WARNING
// ini_set('display_errors',0); 
// error_reporting(E_ALL);

// Pero declarando las variables se pueden evitar errores de Undefined variable
// $image = isset($_GET['image']) ? $_GET['image'] : null; 


use MVC\Router;
use Model\Blog;
use Intervention\Image\ImageManagerStatic as Image;

class BlogController {
    
    public static function crear( Router $router ) {

        $blog = new Blog;

        // Arreglo con mensajes de errores 
        $errores = Blog::getErrores();

        if( $_SERVER["REQUEST_METHOD"] === "POST" ) {
            
            $blog = new Blog( $_POST['blog'] );            
            
            // Generar un nombre único para cada imagen evitando que el nombre se repita o existan dos archivos con el mismo nombre
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";            

            // Setear la imagen
            if($_FILES['blog']['tmp_name']['imagen']) { // si existe la imagen se setea
                $image = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(800 , 600);
                $blog->setImage($nombreImagen); // en la DB se guarda el nombre de la imagen no la imagen ($image)                
            }
            
            $errores = $blog->validar();

            if( empty( $errores ) ) {
                
                // Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {                
                    mkdir(CARPETA_IMAGENES);
                }  

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);                

                $blog->guardar();
            }            
        }

        $router->render('blogs/crear' , [
            'blog' => $blog,
            'errores' => $errores              
        ]);
    }
    
    public static function actualizar( Router $router ) {
        
        $id = validarORedireccionar('/admin');

        $blog = Blog::find($id);

        $errores = Blog::getErrores();


        // Ejecutar el código después que el usuario envía el formulario (solo si es llamado el método POST solo para Crear)
        if( $_SERVER["REQUEST_METHOD"] === "POST" ) {

            // Asignar los atributos
            $args = $_POST['blog']; /* con una sola linea de código se tienen todos los campos del formulario colocandole
                                            blog a todos los campos en el name del HTML del formulario_blog.php  */

            $blog->sincronizar($args);

            // Validación
            $errores = $blog->validar();

            //** Subida de archivos **

            // Generar un nombre único para cada imagen evitando que el nombre se repita o existan dos archivos con el mismo nombre
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";            

            if($_FILES['blog']['tmp_name']['imagen']) { // si existe la imagen se setea
                $image = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(800 , 600);
                $blog->setImage($nombreImagen); // en la DB se guarda el nombre de la imagen no la imagen ($image)
            }

            // Revisar que el arrary de errores este vacío
            if( empty( $errores ) ) {
                if($_FILES['blog']['tmp_name']['imagen']) { // si hay una nueva imagen ó si existe la imagen
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $blog->guardar();           
            }   
        }

        $router->render('blogs/actualizar' , [
            'blog' => $blog,
            'errores' => $errores
        ]);        
    }

    public static function eliminar() {        
        // se valida que el REQUEST_METHOD = POST para evitar un error Undefined o variable no definida
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {       
            // Validar id
            $id = $_POST['id']; // asignamos el valor del id a una variable
            $id = filter_var($id , FILTER_VALIDATE_INT); // valida que solo sea un numero entero lo que se pasa como id

            if($id) { // si la variable id esta llena se borra el registro que pertenece a ese id

                $tipo = $_POST['tipo'];                
                
                // debuguear($tipo);
                if(validarTipoContenido($tipo)) {                
                    $blog = Blog::find($id);                                     
                    $blog->eliminar();
                }            
            }
        }       
    }
}