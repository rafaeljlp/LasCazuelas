<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $blog->titulo; ?></h1>

    <picture>
        <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog">
    </picture>

    <p class="informacion-meta">
            Escrito el: <span><?php echo formatFecha($blog->fecha); ?></span> 
            por: <span><?php echo $blog->autor; ?></span> 
    </p>

    <div class="resumen-propiedad">
        <p class="justify-text paragraphs"><?php echo $blog->texto; ?></p>
    </div>
</main>