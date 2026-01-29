</header>
<main class="mainForm">
    <section class="formularioRegistro">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Alta de Departamento</p>
        </div>
        <form class="form" action="index.php" method="post">
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avRegistro['aErrores']['codUsuario'] ?></a><br>
                <input name="codUsuario" id="codUsuario" type="text" placeholder=" " value='<?php echo $avRegistro['codUsuario'] ?>'>
                <label for="codUsuario">Usuario:</label>
            </div>
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avRegistro['aErrores']['descUsuario'] ?></a><br>
                <input name="descUsuario" id="descUsuario" type="text" placeholder=" " value='<?php echo $avRegistro['descUsuario'] ?>'>
                <label for="descUsuario">Nombre Completo:</label>
            </div>

            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avRegistro['aErrores']['password'] ?></a><br>
                <input name="password" id="password" type="password" placeholder=" " value=''>
                <label for="password">Contraseña: </label>
            </div>
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avRegistro['aErrores']['confirmaPassword'] ?></a><br>
                <input name="confirmaPassword" id="confirmaPassword" type="password" placeholder=" " value=''>
                <label for="confirmaPassword">Confirmar contraseña: </label>
            </div>
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avRegistro['aErrores']['preguntaSeguridad'] ?></a><br>
                <input name="preguntaSeguridad" id="preguntaSeguridad" type="text" placeholder=" " value=''>
                <label for="preguntaSeguridad">Respuesta de seguridad: </label>
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