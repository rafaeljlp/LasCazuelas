<main class="contenedor seccion contenido-centrado">
    <h1 data-cy="heading-login">Iniciar Sesión</h1>

    <?php foreach($errores as $error): ?>
        <div data-cy="alerta-login" class = "alerta error"><?php echo $error; ?></div>

    <?php endforeach; ?>

    <!-- el formulario debe tener el metódo POST para que pueda ejecutarse el REQUEST_METHOD -->
    <!-- <form method="POST" class="formulario" novalidate> --> <!-- en caso de no querer mostrar las validaciones por HTML
    se pueden deshabilitar quitando los requires de los campos y colocando novalidate en la primera etiqueta del formulario -->
    <!--  <form method="POST" class="formulario">  -->
    <form data-cy="formulario-login" method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email y Password</legend>                
            <!-- se deben agregar los name a estos inputs para que el array ya no este vacío  -->
            <label for="email">E-mail</label>
            <!-- <input type="email" name="email" placeholder="Tu Email" id="email" required> --> <!-- required para validar con HTML
            que el campo no este vacío  -->
            <input type="email" name="email" placeholder="Tu Email" id="email">

            <label for="password">Password</label>
            <!-- <input type="password" name="password" placeholder="Tu Password" id="password" required> -->
            <input type="password" name="password" placeholder="Tu Password" id="password">

        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">

    </form>

</main>