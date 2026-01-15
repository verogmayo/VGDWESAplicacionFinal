</header>
<main class="mainForm">
    <section class="formularioRegistro">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Cambiar contraseña en Login Logoff</p>
        </div>
        <form class="form" action="indexAplicacionFinal.php" method="post">
            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['passwordActual'] ?></a><br>
                <input name="passwordActual" id="passwordActual" type="password" placeholder=" " value=''>
                <label for="passwordActual">Contraseña actual: </label>
            </div>
            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['password'] ?></a><br>
                <input name="password" id="password" type="password" placeholder=" " value=''>
                <label for="password">Contraseña: </label>
            </div>
            <div class="contenedorInput">
                <a style='color:red'><?php echo $aErrores['confirmaPassword'] ?></a><br>
                <input name="confirmaPassword" id="confirmaPassword" type="password" placeholder=" " value=''>
                <label for="confirmaPassword">Confirmar contraseña: </label>
            </div>
            <div class="divBotones">
                <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Aceptar</button>
                <div class="botonVolverLogin">
                    <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Cancelar</button>
                </div>
            </div>
        </form>
    </section>
</main>