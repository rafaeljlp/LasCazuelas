<main class="contenedor seccion">
    <h1>Crear</h1>

    <!-- foreach se va a ejecutar al menos una vez por cada vez que haya un elemento en el arreglo 
    sino hay nada no se ejecuta nada -->
    <?php foreach( $errores as $error ) : ?> <!-- los dos puntos ( : ) hacen las veces de las llaves ( { } ) --> 
        <div class="alerta error">
            <?php echo $error; ?> <!-- mostrando los errores del array -->
        </div>            
    <?php endforeach; ?>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        
        <?php include __DIR__ . '/formulario.php'; ?>

        <input type="submit" value="Crear Blog" class="boton boton-verde">

    </form>
    
</main>