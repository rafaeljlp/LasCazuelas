<?php

namespace Model;

class ActiveRecord { // cuando se define una clase no se pone parentesis solo llaves

    /* Base de Datos: Es static porque no va a requerir una nueva instancia, siempre va a ser la misma conexión a la BD
       al ser protected no se puede acceder desde el objeto tiene que ser desde la clase y el metódo tambien debe ser static  */
       protected static $db;

       protected static $columnasDB = [];

       protected static $tabla = '';
   
       /* Errores (protectected porque se enviaran los datos a esta clase y solamente la clase validara si algo es valido o no  
                   static porque no se requiere una nueva instancia para saber si hay errores)       
       */
       protected static $errores = [];       
   
       // **** IMPORTANTE: todo lo que este como static se va a hacer referencia a el como self:: los atributos estaticos si llevan $
   
       // Definir la conexión a la Base de Datos
       public static function setDB($database) {        
           self::$db = $database; /* el self hace referencia a la clase Padre ActiveRecord, se debe mantener 
                                     en todo lo relacionado con la base de datos, solo se requiere una conexión, 
                                     no es necesario static para evitar estar haciendo llamadas innecesarias 
                                     al servidor para la conexión a la DB */
       }
   
       public function guardar() {
           if(!is_null($this->id)) { // para actualizar no debe ser NULL
               // Actualizar
               $this->actualizar();
           } else {
               // Creando un nuevo registro
               $this->crear();
           }
       }
   
       public function crear() {        
           // ************ IMPORTANTE: NO SE PUEDEN DEJAR ESPACIOS ENTRE $this->titulo PRODUCE ERRORES ************
   
           // Sanitizar los datos
           // para llamar un metódo dentro de otro metódo se hace con $this->
           $atributos = $this->sanitizarAtributos();
   
           // insertar en la base de datos
           $query = " INSERT INTO " . static::$tabla . " ( ";
           $query .= join(', ' , array_keys($atributos) );
           $query .= " ) VALUES (' ";  // se coloca comilla simple por ser un string
           $query .= join("', '" , array_values($atributos) );
           $query .=  "') "; // se coloca comilla simple por ser un string 

        //    debuguear($query);
   
           // ya la base de datos tiene una referencia, por lo tanto, se aplica self::$db por ser estatico y la forma orientada a objeto
           $resultado = self::$db->query($query);
   
           // Mensaje de exito o error (en caso que sea correcto el query (INSERT INTO)):
           if( $resultado ) {
               /* Redireccionar al usuario. Funciona mientras no haya HTML previo (porque ya habria HTML impreso por el servidor). 
                  Se debe usar poco para evitar erroes por redireccionamientos */       
               
               // header('Location: /admin?mensaje=Ragistrado Correctamente&registrado=1');
               header('Location: /admin?resultado=1');
           
               // echo "Insertado Correctamente"; 
           } else {
                   echo "NO Insertado Correctamente";            
           }
       }
   
       public function actualizar() {
           // Sanitizar los datos
           $atributos = $this->sanitizarAtributos();
   
           // arreglo que va al objeto en memoria para unir atributos con valores 
           $valores = [];
           foreach ($atributos as $key => $value) {
               $valores[] = "{$key}='{$value}'";
           }
           // debuguear( join(', ', $valores) ); // para visualizar todos los valores ya formateados en un string
   
           $query = "UPDATE " . static::$tabla . " SET ";
           $query .= join(', ', $valores); // para obtener todos los valores ya formateados en un string
           $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
           $query .= " LIMIT 1";
   
           // debuguear($query);
   
           $resultado = self::$db->query($query);
                       
           // en caso que sea correcto el query:
           if( $resultado ) {
               /* Redireccionar al usuario. Funciona mientras no haya HTML previo (porque ya habria HTML impreso por el servidor). 
                  Se debe usar poco para evitar erroes por redireccionamientos
               */
               // header('Location: /admin?mensaje=Ragistrado Correctamente&registrado=1');
               header('Location: /admin?resultado=2');
   
           // echo "Insertado Correctamente"; 
           } else {
               echo "NO Actualizado Correctamente";          
           }  
       }
   
       // Eliminar un registro
       public function eliminar() {
           // Elimina la propiedad
           $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

           // debuguear($query);

           $resultado = self::$db->query($query);
   
           if($resultado) {
               // $this->borrarImagen();
               header('location: /admin?resultado=3'); // se redirecciona con el mensaje nro. 3
           }
       }
       
       // identificar y unir los atributos de la BD - se va a encargar de iterar en todos los atributos de columnasDB
       public function atributos() {
           // se declara un arreglo para iterar en cada columna
           $atributos = [];
           foreach(static::$columnasDB as $columna) { // static porque columnasDB no tiene nada que ver con la conexión a la DB
               /* hace que se ignore el campo id porque no es necesario sanitizarlo por ser un AUTO_INCREMENT 
               y cuando se va a insertar el registro aún el id no existe */
               if ($columna==='id') continue; 
   
               $atributos[$columna] = $this->$columna;
           }
           return $atributos;
       }
       // se va a encargar de sanitizar cada atributo
       public function sanitizarAtributos() {
           // debuguear('Sanitizando...');
   
           // llamando al metódo para mapear las columnas con el objeto en memoria que tenemos
           $atributos = $this->atributos();
           // debuguear($atributos);
          
           $sanitizado = [];        
   
           // recorrer el arreglo de atributos $columnasDB
           // arreglo asociativo $key llave (campos de la BD) y $value (dato de cada campo de la BD)
           foreach($atributos as $key => $value) {
               // se va sanitizando cada valor y ya va a estar disponible en $atributos
               $sanitizado[$key] = self::$db->escape_string($value);
               // echo $key;
               // echo $value;
           }
           //debuguear($sanitizado);
           return $sanitizado;
       }
   
       // Subida de Archivos con la libreria Intervention Image
       public function setImage($imagen) {
           // Elimina la imagen previa (solo para el caso de actualizar)
           
           // COmprobar que sea un directorio y no una imagen para actualizar
           $esDirectorio = is_dir(CARPETA_IMAGENES . $this->imagen);  // @scandir(CARPETA_IMAGENES . $this->imagen);
           //debuguear(CARPETA_IMAGENES . $this->imagen);
                 
           if( !is_null($this->id) && !$esDirectorio ) { // si el id de la imagen NO es NULL y no es un Directorio 
                             
               $this->borrarImagen();
           }
   
           // Asignar al atributo de la imagen el nombre de la imagen (para tener la referencia y guardarlol en la DB)        
           if($imagen) { // si hay una imagen entonces...
               $this->imagen = $imagen;                              
           }
       }
   
       // Elimina el archivo de imagen
       public function borrarImagen() {
           // debuguear('Eliminando Imagen....'. $this->imagen);  
   
           // Comprobar si existe el archivo --- REFORZAR VALIDACIÓN PARA CUANDO EL CAMPO IMAGE EN BD SEA NULL
           $existeArchivo = file_exists( CARPETA_IMAGENES . $this->imagen );
           //debuguear(CARPETA_IMAGENES . $this->imagen);
           if($existeArchivo) {
               unlink( CARPETA_IMAGENES . $this->imagen );
           }
       }
   
       // Validaciòn (se va usar este metódo para obtener el resultado de $errores = [] )
       public static function getErrores() {

           return static::$errores;
       }
   
       public function validar() {

           static::$errores = []; // se limpia el arreglo y se van a generar nuevos errores de ser necesario
           return static::$errores;
       }
   
       // Lista todas los registros (este es el metódo que se manda a llamar desde admin/index.php)
       public static function all() {
           // echo "Consultando todas las propiedades";
           // exit;
           $query = 'SELECT * FROM ' . static::$tabla; /* static busca el metodo de donde se este Heredando           
                                                          puede ser Propiedad ó Vendedor  */                                        
           $resultado = self::consultarSQL($query);
   
           return $resultado;
              
           // debuguear($resultado->fetch_assoc());
       }

       // Obtiene determinado numero de registros
       public static function get($cantidad) {
            /* static busca el metodo de donde se este Heredando           
            puede ser Propiedad ó Vendedor  */           
            $query = 'SELECT * FROM ' . static::$tabla . " LIMIT " . $cantidad; 

            // debuguear('$cantidad: ' . $cantidad);
                                        
            $resultado = self::consultarSQL($query);

            return $resultado;      
        }       

   
       /* Busca un registro por su id (es public porque se accede al metódo desde el actualizar.php 
          y es static porque no requiere una nueva instancia ya que solo se va a consultar nuevamente 
          la base de datos al entrar en actualizar.php ) */ 
       public static function find($id) {
           
           $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";           
   
           $resultado = self::consultarSQL($query); /* se mantiene el self:: porque es un metodo que conecta con DB
                                                       y no existe en las clases Propiedad y Vendedor         */
   
           // debuguear($resultado[0]);
           // debuguear( array_shift($resultado) );
           return array_shift( $resultado );
       }
   
       /* debido a que es un arreglo en Active Record se debe crear un metódo para el manejo de objetos 
          que sean iguales a lo que hay en memoria */
       public static function consultarSQL($query) {
           
           // Consultar la base de datos
           $resultado = self::$db->query($query);
   
           // Iterar los resultados
           $array = [];
           while($registro = $resultado->fetch_assoc()) {
               // $array[] = $registro['titulo'];
               $array[] = static::crearObjeto($registro); /* tiene que ser static:: porque tiene la referencia al $registro 
                                                             que es un arreglo que viene de fetch_assoc() y se esta convirtiendo 
                                                             en objeto para seguir los principios de ActiveRecord. Al ser static 
                                                             va a heredar de las clases hijos Propiedad y Vendedor, sus atributos
                                                             y su constructor respectivamente  */
           }
           //debuguear($array); // muestra arreglos de objetos
   
           // Liberar la memoria
           $resultado->free();
   
           // retornar los resultados
           return $array;
       }
   
       // en Active Record se deben tener Onjetos no arreglos. Se crea un metódo que convierta el array en Objetos
   
       // protected porque únicamente se va a poder acceder en esta clase
       protected static function crearObjeto($registro) { // el registro que viene como arreglo lo va a estar convirtiendo a objeto
           // instanciar para crear nuevos objetos
           $objeto = new static; // static que cree un nuevo objeto en la clase que se esta heredando
   
           // debuguear($registro); // para visualizar el tipo de arreglo (Asociativo llave => valor)   
           //debuguear($objeto);
   
           foreach($registro as $key => $value) {
   
               // se crea un objeto en memoria que es un espejo de lo que hay en la base de datos
   
               // property_exists() verifica que una propiedad exista
               if( property_exists( $objeto , $key )) { // si existe el objeto y la clave ...
                   $objeto->$key = $value; // se asigna el valor
               } 
               // debuguear($key);            
           }
           // debuguear($objeto);
   
           return($objeto);
       }
       
       // Sincroniza el objeto em memoria con los cambios realizados por el usuario
       public function sincronizar( $args = [] ) {
           foreach($args as $key => $value) {
               if (property_exists($this, $key) && !is_null($value) ) { // si existen y si no estan vacíos vamos asignando algo
                   $this->$key = $value; 
               }
           }
       } 
}