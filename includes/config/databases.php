<?php

// va a retornar una conexión de mysqli
function conectarDB() : mysqli {

    // usando la forma de conexión orientada a objetos POO
    $db = mysqli_connect(
        $_ENV['DB_HOST'], 
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_BD']
    );

    // forma de conexión usando la función mysqli_connect y que no es POO
    // $db = mysqli_connect('localhost' , 'root' , 'root' , 'bienes_raices');  

    // colocar siempre esta línea de código para validar que los datos respeten palabras acentuadas y letras del idioma español
    $db->set_charset('utf8');

    // debuguear($_ENV);

    /* if ($db) {
        echo 'Se conectó';
    } else {
        echo 'No se conectó';
    } */

    // Si NO se puedo conectar...
    if(!$db) {
        echo "Error no se pudo conectar";
        exit; // si no se conecta, detiene la ejecucción, se encarga de que las siguientes líneas no se ejecuten
    } // else {
    //     echo "Conectado";
    // }
    // se retorna una instancia de la conexión.
    return $db;
}

