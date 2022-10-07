<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        // echo "Desde login"; // para probar el routing

        $errores = [];       

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Admin($_POST); // Nueva instancia de auth

            $errores = $auth->validar();

            if(empty($errores)) {
                // Verificar si el usuario existe
                $resultado = $auth->existeUsuario();

                if( !$resultado ) { // Si no hay un usuario se llama a errores
                    // Verificar si el usuario existe o no (mensaje de error)
                    $errores = Admin::getErrores();
                } else {
                    // Verificar el password
                    $autenticado = $auth->ComprobarPassword($resultado);

                    if($autenticado) {
                        // Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        // Password incorrecto mensaje de error
                        $errores = Admin::getErrores(); 
                    }
                }                
            }
        }       

        $router->render('auth/login' , [
            'errores' => $errores
        ]);
    }

    public static function logout() {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
}