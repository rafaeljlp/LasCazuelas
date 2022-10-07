<?php

namespace Model;

class Admin extends ActiveRecord {
    // Base de Datos 
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id' , 'email' , 'password']; // atributos de esta clase
    // - son protected porque solo necesitamos acceder a ellos dentro de esta clase

    // se accede a los atributos tanto en el Modelo como en el Controlador por lo tanto deben ser Public
    public $id;
    public $email;
    public $password;

    // Constructor
    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        if( !$this->email) {
            self::$errores[] = 'El Email es obligatorio';
        }
        if( !$this->password) {
            self::$errores[] = 'El Password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario() {
        // Revisar si un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";

        //debuguear($query);

        $resultado = self::$db->query($query);

        if(!$resultado->num_rows) { // el num_rows propiene de las propiedades del objeto se puede verificar con debuguear
            self::$errores[] = 'El Usuario no existe';
            return; // para que el código deje de ejecutarse
        }
        return $resultado;
    }

    public function ComprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();
       
        /* password_verify función de PHP que revisa si el password escrito en el formulario es el mismo de la BD 
           $this->password: lo que el usuario escribio en el formulario y $usuario->password lo que esta en BD (hasheado) */
        $autenticado = password_verify($this->password , $usuario->password);

        if( !$autenticado ) {
            self::$errores[] = 'El Password incorrecto';            
        }
        return $autenticado;
    }

    public function autenticar() {
        // Iniciar sesión
        session_start();

        // Llenar el arreglo de sesión
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
    
}