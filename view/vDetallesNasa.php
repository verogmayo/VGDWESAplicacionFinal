    <div class="tituloCentralDetalles">
        <h3>Detalles de la foto de la Nasa</h3>
    </div>
    <form class="botonesDetalles">
        <div class="botonVolverLogin">
            <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
        </div>
        <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avDetallesNasa['inicial']; ?></button>
        <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sessión</button>
    </form>
    </header>
    <main>
        <section class="sectionDetalles">
            <div class="containerDetallesNasa">
                <h1><?php echo $avDetallesNasa['tituloNasa']; ?></h1>
                <p style="color:blue; font-size:20px;"><?php echo $avDetallesNasa['fechaNasa']; ?></p>
                <div class="contenedorFotoHd">
                    <?php if (!empty($avDetallesNasa['fotoSerializadaHD'])): ?>
                        <img src="<?php echo $avDetallesNasa['fotoSerializadaHD']; ?>" alt="Foto NASA HD" style="max-width:100%; border-radius:10px;">
                    <?php else: ?>
                        <p>No hay versión en alta resolución disponible.</p>
                    <?php endif; ?>
                </div>
                <div class="explicacionNasa" style="margin-top:20px; text-align:justify; line-height:1.6; margin:0 5px 10px 5px">
                    <h3>Explicación: </h3>
                    <p><?php echo $avDetallesNasa['explicacionNasa']; ?></p>
                </div>
            </div>
        </section>
    </main>