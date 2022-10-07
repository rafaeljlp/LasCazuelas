<main class="contenedor seccion">

    <h1>Actualizar Cliente</h1>        

    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- foreach se va a ejecutar al menos una vez por cada vez que haya un elemento en el arreglo 
            sino hay nada no se ejecuta nada -->
    <?php foreach( $errores as $error ) : ?> <!-- los dos puntos ( : ) hacen las veces de las llaves ( { } ) --> 
        <div class="alerta error">
            <?php echo $error; ?> <!-- mostrando los errores del array -->
        </div>            
    <?php endforeach; ?>

    <!-- toda la información que se coloque en el formulario va a ser procesada en el archivo crear.php 
            enqtype="multipart/form-data" para enviar archivos desde el formulario -->
    <!-- <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php"> --> <!-- esta forma tambien esta bien -->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <!-- Para mandar a llamar y reutilizar el formulario_propiedades.php -->
        <?php include 'formulario.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>

</main>