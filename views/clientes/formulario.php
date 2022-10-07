<fieldset>
    <legend>Información General</legend>

    <!-- el name es lo que va a permitir leer con PHP lo que el usuario escriba en el formulario-->

    <label for="nombre">Nombre:</label> 
    <input type="text" id="nombre" name="cliente[nombre]" placeholder="Nombre Cliente" value="<?php echo s( $cliente->nombre ); ?>">

    <label for="apellido">Apellido:</label> 
    <input type="text" id="apellido" name="cliente[apellido]" placeholder="Apellido Cliente" 
        value="<?php echo s( $cliente->apellido ); ?>">
        
    <label for="visitas">Visitas:</label> 
    <input class="visitas" type="number" id="visitas" name="cliente[visitas]" min="0" placeholder="Visitas" 
        value="<?php echo s( $cliente->visitas ); ?>">

    <!-- <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg , image/png" name="cliente[imagen]"> -->

    <!-- IMPORTANTE: CON ARROBA (@) DELANTE DE $blog SE EVITA UN WARNING: Undefined Property -->
    <!-- <?php if(@$cliente->imagen) { ?>        
        <img src="/imagenes/<?php echo $cliente->imagen ?>" class="imagen-small">
    <?php } ?> -->

</fieldset>

<!-- <fieldset>
    <legend>Información Extra</legend>
    
    <label for="telefono">Teléfono:</label> 
    <input type="text" id="telefono" name="cliente[telefono]" placeholder="Teléfono cliente(a)" 
        value="<?php echo s( $cliente->telefono ); ?>">

</fieldset> -->