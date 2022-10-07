<?php
    // Si la variable NO existe o NO esta definida
    if ( !isset($_SESSION) ) {
        session_start(); // arrancamos la sesión
    }
    //var_dump($_SESSION);

    // si existe retorna true sino retorna false
    $auth = $_SESSION['login'] ?? false;

    if(!isset($inicio)) {
        $inicio = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Las Cazuelas</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>
    <!-- 
    operador ternario: con isset se evalua si una variable esta definida, el signo "?" es un IF que condiciona si es true
    le concatena inicio al header del HTML para que muestre la foto de fondo solo para pagina principal //(index) el 
    operador ":" es un ELSE sino esta definida le concatenamos blanco al header del HTML para para que no muestre la
    fondo que es solo para pagina principal //(index) 
    
    <header class="header <?php //echo isset( $inicio ) ? 'inicio' : ''; ?> "> 
    -->

    <!-- con la función // (funciones.php) ya no hace falta la comprobación con isset  -->
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?> "> 
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/"> <!-- Pagina Principal index con MVC-->
                    <!-- <img src="/build/img/logo.svg" class="logo-header" alt="Logotipo de Bienes Raices"> -->
                    <h1 class="logo-header">Las Cazuelas</h1>                  
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    <nav class="navegacion" data-cy="navegacion-header"> 
                        <!--se coloca "/" delante de cada pagina para que se redireccione a las encuentre en la raíz del proyecto -->
                        <a href="/nosotros">Nosotros</a>
                        <!-- <a href="/propiedades">Propiedades</a>
                        <a href="/blogs">Blog</a>
                        <a href="/contacto">Contacto</a>  -->
                        <a href="/">Menu</a>
                        <a href="/">Blog</a>
                        <a href="/">Contacto</a>
                        <?php if( $auth ): ?> <!--si el usuario esta auténticado se muestran los links a admin y cerrar sesión-->
                            <a href="/admin">Admin</a> <!-- solo para redireccionar al administrador desde cualquier página -->
                            <a href="/logout">Cerrar Sesión</a>
                        <?php else: ?> <!-- si el usuario no esta auténticado se muestra el link a la página login para auténticarse -->
                            <a href="/login">Login</a>
                        <?php endif; ?>
                    </nav>
                </div>
                
            </div> <!--.barra-->
            <!--
            <?php
                // if($inicio) {
                //     echo "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>";
                // }
            ?> -->
            <!-- usando un operador ternario en una sola linea de código: -->
            <?php echo $inicio ? "<h1 data-cy='heading-sitio'>Las Mejores Comidas Corridas Hechas Como en Casa</h1>" : ''; ?> 
            <!-- sirve para que el eslogan se muestre solo en la página principal gracias al $inicio = true
            que esta en el index de la raiz del proyecto -->   

        </div>
    </header>

    <?php echo $contenido; ?>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav data-cy="navegacion-footer" class="navegacion">
                <!--se coloca "/" delante de cada pagina para que se redireccione a las encuentre en la raíz del proyecto -->
                <a href="/nosotros">Nosotros</a>
                <!-- <a href="/propiedades">Propiedades</a>
                <a href="/blogs">Blog</a>
                <a href="/contacto">Contacto</a> -->
                <a href="/">Menu</a>
                <a href="/">Blog</a>
                <a href="/">Contacto</a>
            </nav>
        </div>

        <p data-cy="copyright" class="copyright">Todos los derechos Reservados <?php echo date('Y') ?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>

</body>
</html>