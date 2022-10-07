<?php

namespace Controllers;
use MVC\Router;
// use Model\Propiedad;
use Model\Cliente;
use Model\Blog;

// libreria para el manejo de para subir imagenes imagenes en PHP con Intervention Image
// use Intervention\Image\ImageManagerStatic as Image;


class DashboardController {
    public static function index(Router $router) { /* con static no requerimos crear una nueva instancia 
                                                      Router $router importa el objeto para no perder su referencia  */

        /*** IMPORTANTE: En el index del Admin se deben llamar a los Modelos de Propiedades, Vendedores y Blogs
                         con el m+etodo all() para que se muestren los registros de la base de datos en la pantalla ***/
                                                      
        // Consultando la Base de Datos - Consultando todos los registros (para cada renglon Propiedades, Vendedores y Blogs)
        // $propiedades = Propiedad::all(); 

        $clientes = CLiente::all();

        $blogs = Blog::all();
        
        /* Muestra mensaje condicional para validar si $resultado esta vacío: ?? es el equivalente al isset() 
           si no existe colocale NULL - En MVC el $resultado se pasa a la vista */
        $resultado = $_GET['resultado'] ?? null;

        // Se pasan los datos a la vista
        $router->render('dashboard/admin' , [
            // 'propiedades' => $propiedades,
            'resultado' => $resultado,      
            'clientes' => $clientes,
            'blogs' => $blogs
        ]);
    }    
}