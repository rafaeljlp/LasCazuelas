<?php
// 22/03/2022

namespace Model; // App es el nombre que se le dio en el archivo composer.json

class Blog extends ActiveRecord {
    // tabla
    protected static $tabla = 'blog';
    // columnas
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'autor' , 'resumen', 'imagen', 'texto'];
    // atributos
    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $resumen;
    public $imagen;
    public $texto;
    
    // definir el constructor
    public function __construct( $args = [] )
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->resumen = $args['resumen'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->texto = $args['texto'] ?? '';        
    }

    public function validar() {

        if( !$this->titulo ) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if( !$this->resumen ) {
            self::$errores[] = "Debes añadir un resumen";
        }

        if( !$this->autor ) {
            self::$errores[] = "Debes añadir un autor";
        }
        
        if( !$this->fecha ) {
            self::$errores[] = "Debes añadir una fecha";
        }
                
        if( !$this->imagen ) {
            self::$errores[] = "La imagen es Obligatoria";
        }        

        if( !$this->texto ) {
            self::$errores[] = "Debes añadir el texto";
        }

        return self::$errores;
    }

}