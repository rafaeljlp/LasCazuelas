<?php

namespace Controllers;

use MVC\Router;
// use Model\Propiedad; // se importa el modelo propiedad para invocarlo en los métodos o funciones
use Model\Blog;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    
    public static function index( Router $router ) {

        // $propiedades = Propiedad::get(3); // se pasan solo 3 propiedades a mostrar en la página principal
        $blogs = Blog::get(2);
        $inicio = true; // llenando la variable que espera el layout para mostrar la foto de la página principal

        // render es el método para mostrar una vista (aqui se le pasan los datos a la vista para mostrarlos)
        $router->render('paginas/index' , [
            // 'propiedades' => $propiedades,
            'inicio' => $inicio, // Pasándole a la vista la variable para mostrar la foto en la página principal
            'blogs' => $blogs
        ]);
    }

    public static function nosotros( Router $router ) {

        $router->render('paginas/nosotros'); // no requiere pasarle más nada siendo una vista estática (solo HTML)
    }

    /*
    public static function propiedades( Router $router ) {

        $propiedades = Propiedad::all(); // Model\ActiveRecord::all() se trae todas las propiedades

        $router->render('paginas/propiedades' , [ // este si es dinámico
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad( Router $router ) {

        // 1.- Validar que sea un id válido
        $id = validarORedireccionar('/propiedades');

        // 2.- si pasa la validación se busca la propiedad por su id
        $propiedad = Propiedad::find($id);
        
        // 3.- se le pasan los datos a la vista
        $router->render('paginas/propiedad' , [
            'propiedad' => $propiedad 
        ]);
    }
    */
    public static function blogs( Router $router ) {
        // $router->render('paginas/blog'); // es estático (se recomienda hacer dinámico)
        
        $blogs = Blog::all();

        $router->render('paginas/blogs' , [
            'blogs' => $blogs
        ]);
    }

    public static function blog( Router $router) {
        // $router->render('paginas/entrada');

        // 1.- Validar que sea un id válido
        $id = validarORedireccionar('/blogs');

        // debuguear($id);

        // 2.- si pasa la validación se busca la propiedad por su id
        $blog = Blog::find($id);
        
        // 3.- se le pasan los datos a la vista
        $router->render('paginas/blog' , [
            'blog' => $blog 
        ]);        
    } 


    public static function entrada( Router $router) {
        // $router->render('paginas/entrada');

        // 1.- Validar que sea un id válido
        $id = validarORedireccionar('/blog');

        // debuguear($id);

        // 2.- si pasa la validación se busca la propiedad por su id
        $blog = Blog::find($id);
        
        // 3.- se le pasan los datos a la vista
        $router->render('paginas/entrada' , [
            'blog' => $blog 
        ]);        
    }    

    public static function contacto( Router $router ) { // para enviar un email

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $respuestas = $_POST['contacto'];
            
            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP (protocolo usado para el envío de emails) utilizando un servicio como MailTrap
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; // estos datos se extraen de la consfiguración del protocolo SMTP en la cuenta de MailTrap
            $mail->SMTPAuth = true; // para autenticar
            $mail->Username = '0acaf3d38550b4';
            $mail->Password = '0b59277437f7b4';
            $mail->SMTPSecure = 'tls'; // Transport Layer Security (tls): emails que van por un tunel seguro
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com' , 'bienesraices.com');
            $mail->Subject = 'Tienes un nuevo mensaje en acción';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // para mostrar letras y acentos propios del lenguahe español

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje (prueba de acentuación)</p>';
            $contenido .= '<p>Nombre: ' .  $respuestas['nombre']  . ' </p>';
            

            // Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas['contacto'] === 'telefono' ) {
                $contenido .= '<p>Eligió ser contactado por teléfono</p>';
                $contenido .= '<p>Telefóno: ' .  $respuestas['telefono']  . ' </p>';
                $contenido .= '<p>Fecha Contacto: ' .  $respuestas['fecha']  . ' </p>';
            $contenido .= '<p>Hora: ' .  $respuestas['hora']  . ' </p>';
            } else {
                // Es email, entonces agregamos el campo de email
                $contenido .= '<p>Eligió ser contactado por email</p>';                
                $contenido .= '<p>EMail: ' .  $respuestas['email']  . ' </p>';
            }
            
            $contenido .= '<p>Mensaje: ' .  $respuestas['mensaje']  . ' </p>';
            $contenido .= '<p>Vende o Compra: ' .  $respuestas['tipo']  . ' </p>';
            $contenido .= '<p>Precio o Presupuesto: $' .  $respuestas['precio']  . ' </p>';
            $contenido .= '<p>Prefiere ser contactado por: ' .  $respuestas['contacto']  . ' </p>';            
            $contenido .= '</html>'; // para concatenar de forma dinámica se utiliza: .= (punto =)';


            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML (prueba de acentuación)';

            // Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje =  "El mensaje no se pudo enviar...";
            }
        }
        // envío de datos a la vista
        $router->render('paginas/contacto' , [
            'mensaje' => $mensaje
        ]);
    }
}
