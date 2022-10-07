<article class="entrada-blog">

    <?php foreach( $blogs as $blog ) { ?>
        
            <div class="imagen">
                <picture>            
                    <img loading="lazy" src="/imagenes/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="/blog?id=<?php echo $blog->id; ?>">
                    <h4><?php echo $blog->titulo; ?></h4>
                    <p class="informacion-meta">
                        Escrito el: <span><?php echo formatFecha($blog->fecha); ?></span> 
                        por: <span><?php echo $blog->autor; ?></span> 
                    </p>
                    <p class=justify-text><?php echo $blog->resumen; ?></p>
                </a>
            </div>
        
    <?php } ?>

</article>