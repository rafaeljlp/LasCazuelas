<fieldset>
    <legend>Información General</legend>

    <!-- el name es lo que va a permitir leer con PHP lo que el usuario escriba en el formulario-->

    <label for="titulo">Titulo:</label> 
    <input type="text" id="titulo" name="blog[titulo]" placeholder="Titulo Blog" value="<?php echo s( $blog->titulo ); ?>">

    <label for="resumen">Resumen:</label> 
    <input type="text" id="resumen" name="blog[resumen]" placeholder="resumen Blog" value="<?php echo s( $blog->resumen ); ?>">

    <label for="titulo">Autor:</label> 
    <input type="text" id="autor" name="blog[autor]" placeholder="Autor Blog" value="<?php echo s( $blog->autor ); ?>">

    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" min="2020-11-20" >

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg , image/png" name="blog[imagen]">
    
    <!-- IMPORTANTE: CON ARROBA (@) DELANTE DE $blog SE EVITA UN WARNING: Undefined Property -->
    <?php if(@$blog->imagen) { ?>        
        <img src="/imagenes/<?php echo $blog->imagen ?>" class="imagen-small">
    <?php } ?>   

    <label for="texto">Texto:</label>
    <textarea id="texto" name="blog[texto]"><?php echo s($blog->texto); ?></textarea>


</fieldset>