</header>
<main class="mainForm">
    <section class="formulario">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Borrar cuenta en Login Logoff</p>
        </div>
        <form class="form" action="indexAplicacionFinal.php" method="post">

            <div class="contenedorInput">
                <div class="textoBorrarUsuario">¿Estás seguro de que quieres borrar tu cuenta?
                    Los datos se borrarán de forma permanente y no podrás recuperarlos.
                </div>
                <!-- Mensaje de error si no se pouede borrar el usuario -->
                <?php if (!empty($errorBorrar)): ?>
                    <div class="errorBorrar">
                        <p><?php echo $errorBorrar; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="divBotones">
                <button id="botonSessionLogin" class="botonSession" type="submit" name="borrar">Borrar cuenta</button>
                <div class="botonVolverLogin">
                    <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Volver</button>
                </div>

            </div>
        </form>
    </section>
</main>