<div class="tituloCentralCuenta">
    <p>CONSULTA Y MODIFICACIÓN DE DEPARTAMENTO</p>
</div>
<form class="botonesDetalles">
    <div class="botonVolverLogin">
        <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avVerModificarDpto['inicial']; ?></button>
    <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sessión</button>
</form>
</header>
<main class="mainCuenta">
    <!-- Si existe el mensaje de exito en la session, se muestra  -->
    <?php if (isset($_SESSION['mensajeExito'])): ?>
        <div class="mensajeExitoDiv">
            <p class="mensajeExitoP">
                <?php
                echo $_SESSION['mensajeExito'];
                //SE borra el mensaje sino saldría siempre
                unset($_SESSION['mensajeExito']);
                ?>
            </p>
        </div>
    <?php endif; ?>
    <div class="cabeceraPerfil">
        <h1>Información Departamento</h1>
    </div>
    <div class="paginaCuentaContainer">
        <aside class="menuLateral">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="menuCuenta  activo">
                            <span class="iconoMenu li1"><i class="fa-regular fa-address-book"></i></span>
                            Información departamento
                        </a>
                    </li>
                    <form method="post">
                        <!-- <li>
                            <button type="submit" name="borrarCuenta" class="menuCuenta"
                                id="botonMenuCuenta">
                                <span class="iconoMenu li3"><i class="fa-solid fa-eraser"></i></span>
                                Borrar cuenta
                            </button>

                        </li> -->
                    </form>
                </ul>
            </nav>
        </aside>
        <section  class="contenidoPerfil">
           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="tablaDatosGrid">
        
        <div class="filaDato">
            <div class="etiqueta">CODIGO DEPARTAMENTO</div>
            <input name="codDepartamento" id="codDepartamento" type="text" 
                   value='<?php echo $avVerModificarDpto['codDepartamento'] ?>' disabled>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">DESCRIPCIÓN DEPARTAMENTO</div>
            <input name="descDepartamento" id="descDepartamento" type="text" 
                   value='<?php echo $avVerModificarDpto['descDepartamento'] ?>'
                   <?php echo ($avVerModificarDpto['modo'] === 'consultar') ? 'disabled' : ''; ?>>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">FECHA CREACIÓN DEPARTAMENTO</div>
            <input type="text" name="fechaCreacionDepartamento" id="fechaCreacionDepartamento" 
                   value='<?php echo $avVerModificarDpto['fechaCreacionDpto'] ?>' disabled>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">VOLUMEN DE NEGOCIO</div>
            <input name="volumenDeNegocio" id="volumenDeNegocio" type="number" step="0.01"
                   value='<?php echo $avVerModificarDpto['volumenDeNegocio'] ?>'
                   <?php echo ($avVerModificarDpto['modo'] === 'consultar') ? 'disabled' : ''; ?>>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">FECHA BAJA DEPARTAMENTO</div>
            <input type="text" name="fechaBajaDepartamento" id="fechaBajaDepartamento" 
                   value='<?php echo $avVerModificarDpto['fechaBajaDepartamento'] ?>' disabled>
            <div class="icono"><span></span></div>
        </div>
        
    </div>

    <div class="divBotones">
        <?php if ($avVerModificarDpto['modo'] === 'modificar'): ?>
            <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Aceptar</button>
        <?php endif; ?>

        <div class="botonVolverLogin">
            <button id="botonVolverLogin" class="botonAzul" type="submit" name="cancelar">Volver</button>
        </div>
    </div>
</form>

        </section>
    </div>

</main>