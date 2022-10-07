<main class="contenedor seccion">
    <h1 data-cy="heading-contacto">Contacto</h1>

    <?php if($mensaje) { ?>
            <p data-cy="alerta-envio-formulario" class='alerta exito'><?php echo $mensaje; ?></p>;
    <?php } ?>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2 data-cy="heading-formulario">Llene el Formulario de Contacto</h2>

    <form data-cy="formulario-contacto" class="formulario" action="/contacto" method="POST">
        <fieldset>
            <legend>Información Personal</legend>
            <!-- con la instrucción:  required los campos se hacen obligatorios para validar en el cliente
                 lo recomendable es tener validaciones en el cliente y en el servidor -->
            <label for="nombre">Nombre</label>
            <input data-cy="input-nombre" type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" >

            <label for="mensaje">Mensaje:</label>
            <textarea data-cy="input-mensaje" id="mensaje" name="contacto[mensaje]" ></textarea>
        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <label for="opciones">Vende o Compra:</label>
            <select data-cy="input-opciones" id="opciones" name="contacto[tipo]" >
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label data-cy="input-precio" for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" >

        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <p>Como desea ser contactado</p>
            <!-- en los input radio se coloca el mismo nombre en: name="contacto[contacto]" el value es lo que se envía -->
            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input data-cy="forma-contacto" type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" >

                <label for="contactar-email">E-mail</label>
                <input data-cy="forma-contacto" type="radio" value="email" id="contactar-email" name="contacto[contacto]" >
            </div>

            <div id="contacto"></div>            

        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>
