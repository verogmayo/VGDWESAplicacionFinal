</header>
<main class="mainForm">
    <section class="formularioRegistro">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Inicia Sesión en Login Logoff</p>
        </div>
        <form class="form" action="index.php" method="post">
            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['usuario'] ?></a><br>
                <input name="usuario" id="usuario" type="text" placeholder=" " value=''>
                <label for="usuario">Usuario:</label>
            </div>
            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['nombreCompleto'] ?></a><br>
                <input name="nombreCompleto" id="nombreCompleto" type="text" placeholder=" " value=''>
                <label for="nombreCompleto">Nombre Completo:</label>
            </div>

            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['password'] ?></a><br>
                <input name="password" id="password" type="password" placeholder=" " value=''>
                <label for="password">Contraseña: </label>
            </div>
            <div class="divBotones">
                <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Enviar</button>
                <div class="botonVolverLogin">
                    <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Volver</button>
                </div>

            </div>
        </form>
    </section>
</main>