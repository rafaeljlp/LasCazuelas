<main class="contenedor seccion">
        <!-- <h1>Administrador de Clientes</h1>         -->
        <h1>Panel Administrativo</h1>        
        
        <?php
            if($resultado) {
                $mensaje = mostrarNotificacion( intval($resultado) );
                if($mensaje) { ?>
                    <p class="alerta exito"><?php echo s($mensaje) ?> </p>
                <?php }            
            }                                    
        ?>       

        <a href="/clientes/crear" class="boton boton-amarillo">Nuevo Cliente</a>

        <h2>Clientes</h2>

        <table class="dashboad">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="nombre-encabezado">Nombre</th>
                    <th class="visitas-encabezado">N° Visitas</th>
                    <!-- <th>Foto</th>
                    <th>Teléfono</th> -->
                    <th>Acciones</th>                    
                </tr>
            </thead>

            <tbody> <!-- 4/5 Mostrar los resultados -->                
                <?php foreach ( $clientes as $cliente ) : ?>
                <tr>
                    <td class="id"><?php echo $cliente->id; ?></td> 
                    <td class="nombre"><?php echo $cliente->nombre . " " . $cliente->apellido; ?></td>
                    <td class="numero-visitas"><?php echo $cliente->visitas; ?></td>
                    <!-- <td><img src="/imagenes/<?php echo $cliente->imagen; ?>" class="imagen-tabla"></td>
                    <td><?php echo $cliente->telefono; ?></td> -->
                    <td>
                        <a href="clientes/actualizar?id=<?php echo $cliente->id; ?>" 
                        class="boton-amarillo-block">Actualizar</a>

                        <form method="POST" class="w-100" action="/clientes/eliminar">
                            <!-- para enviar datos de forma oculta -->
                            <input type="hidden" name="id" value="<?php echo $cliente->id; ?>" >
                            <input type="hidden" name="tipo" value="cliente">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>               
                    </td>
                </tr>                
                <?php endforeach; ?>
            </tbody>

        </table>

</main>