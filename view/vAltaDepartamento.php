</header>
<main class="mainForm">
    <section class="formularioRegistro">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession"> Alta de Departamento</p>
        </div>
        <form class="form" action="index.php" method="post">
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avAltaDepartmento['aErrores']['codDepartamento'] ?></a><br>
                <!-- se incluye js en el input para que las letras se escriban en Mayusculas directamente y que lo vea el usuario y se recogen en mayusculas -->
                <input name="codDepartamento" id="codDepartamento" type="text" oninput="this.value = this.value.toUpperCase()" maxlength="3" placeholder=" " value='<?php echo $avAltaDepartmento['codDepartamento'] ?>'>
                <label for="codDepartamento">Código de Departamento:</label>
            </div>
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avAltaDepartmento['aErrores']['descDepartamento'] ?></a><br>
                <input name="descDepartamento" id="descDepartamentoAlta" type="text" placeholder=" " value='<?php echo $avAltaDepartmento['descDepartamento'] ?>'>
                <label for="descDepartamento">Descripción de Departamento:</label>
            </div>
            <div class="contenedorInputRegistro">
                <a style='color:red'><?php echo $avAltaDepartmento['aErrores']['fechaCreacionDepartamento'] ?></a><br>
                <input name="fechaCreacionDepartamento" id="fechaCreacionDepartamento" type="date" placeholder=" " value='<?php echo $avAltaDepartmento['fechaCreacionDepartamento'] ?>' readonly>
                <label for="fechaCreacionDepartamento">Fecha de Creación:</label>
        </form>
        <div class="contenedorInputRegistro">
            <a style='color:red'><?php echo $avAltaDepartmento['aErrores']['volumenDeNegocio'] ?></a><br>
            <input name="volumenDeNegocio" id="volumenDeNegocio" type="text" placeholder=" " value='<?php echo $avAltaDepartmento['volumenDeNegocio'] ?>'>
            <label for="volumenDeNegocio">Volumen de Negocio:</label>
        </div>
        <div class="divBotones">
            <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Enviar</button>
            <div class="botonVolverLogin">
                <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Volver</button>
            </div>
    </section>
</main>