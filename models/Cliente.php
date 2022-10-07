<?php

namespace Model;

class Cliente extends ActiveRecord { // extends: Herencia de ActiveRecord
    // Tabla
    protected static $tabla = 'clientes';

    // Columnas
    protected static $columnasDB = ['id' , 'nombre' , 'apellido' , 'visitas', 'fecha'];

    // Atributos
    public $id;
    public $nombre;
    public $apellido;    
    public $visitas;    
    public $fecha;

    // definir el constructor
    public function __construct( $args = [] ) 
    {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? '';
        $this -> apellido = $args['apellido'] ?? '';        
        $this -> visitas = $args['visitas'] ?? 0;        
        $this->fecha = date('Y/m/d');             
    }

    public function validar() {
        // lo que forma parte de la instancia que esta en un constructor etc. se hace referencia con this->
        if( !$this->nombre ) { 
            // para todo lo que este como estático siempre se va a hacer referencia con self::
            self::$errores[] = "El Nombre es obligatorio";
        }

        if( !$this->apellido ) { 
            // para todo lo que este como estático siempre se va a hacer referencia con self::
            self::$errores[] = "El Apellido es obligatorio";
        }

        /*
        if(!$this->imagen) {            
            self::$errores[] = 'La imagen del vendedor es Obligatoria';
        }        

        if( !$this->telefono ) { 
            // para todo lo que este como estático siempre se va a hacer referencia con self::
            self::$errores[] = "El Teléfono es obligatorio";
        }

        // Regular Expresion para validar que el telefono sean solo numeros del 0-9 y máximo 10 dígitos
        if( !preg_match('/[0-9]{10}/' , $this->telefono) ) {
            self::$errores[] = "Formato no válido";
        }

        if ( strlen( $this->telefono) > 10) {
            self::$errores[] = "Telefono no puede ser mayor a 10 dígitos";
        }
        */

        return self::$errores;
    }
}