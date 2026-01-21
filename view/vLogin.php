</header>
<main class="mainForm">
    <?php if (isset($_SESSION['errorRegistro'])): ?>
        <div class="errorRegistroDiv">
            <?php
            echo $_SESSION['errorRegistro'];
            // Se borra para que no se repita
            unset($_SESSION['errorRegistro']);
            ?>
        </div>
    <?php endif; ?>
    <section class="formulario">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Inicia Sesión en Aplicación Final</p>
        </div>
        <form class="form" action="index.php" method="post">
            <div class="contenedorInput">
                <a style='color:red'></a><br>
                <input name="codUsuario" id="codUsuario" type="text" placeholder=" " value=''>
                <label for="codUsuario">Usuario:</label>
            </div>
            <div class="contenedorInput">
                <a style='color:red'></a><br>
                <input name="password" id="password" type="password" placeholder=" " value=''>
                <label for="password">Contraseña: </label>
            </div>
            <div class="divBotones">
                <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Enviar</button>
                <div class="botonVolverLogin">
                    <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Volver</button>
                </div>
                <button id="botonCrearCuenta" class="botonAzul" type="submit" name="crearCuenta">Crear Cuenta</button>
            </div>
        </form>
    </section>
</main>