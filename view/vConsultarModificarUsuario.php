<div class="tituloCentralCuenta">
    <p>CONSULTA Y MODIFICACIÓN DE USUARIO</p>
</div>
<form class="botonesDetalles">
    <div class="botonVolverLogin">
        <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avVerModificarUsuario['inicial']; ?></button>
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
                            Información Usuario
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
            <div class="etiqueta">CODIGO USUARIO</div>
            <input name="codUsuario" id="codUsuario" type="text" 
                   value='<?php echo $avVerModificarUsuario['codUsuario'] ?>' disabled>
            <div class="icono"><span></span></div>
        </div>
        <div class="filaDato">
            <div class="etiqueta">CONTRASEÑA </div>
            <input name="password" id="<?php echo ($avVerModificarUsuario['modo'] === 'consultar') ? 'passwordAdminGris' : 'passwordAdmin'; ?>" type="text" 
                   value='**********'
                   disabled>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">DESCRIPCIÓN DE USUARIO</div>
            <input name="descUsuario" id="<?php echo ($avVerModificarUsuario['modo'] === 'consultar') ? 'descUsuarioAdminGris' : 'descUsuarioAdmin'; ?>" type="text" 
                   value='<?php echo $avVerModificarUsuario['descUsuario'] ?>'
                   <?php echo ($avVerModificarUsuario['modo'] === 'consultar') ? 'disabled' : ''; ?>>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">FECHA ULTIMA CONEXION</div>
            <input type="text" name="fechaHoraUltimaConexion" id="fechaHoraUltimaConexion" 
                   value='<?php echo $avVerModificarUsuario['fechaUltimaConexion'] ?>' disabled>
            <div class="icono"><span></span></div>
        </div>

        <div class="filaDato">
            <div class="etiqueta">PERFIL</div>
            <input name="perfil" id="<?php echo ($avVerModificarUsuario['modo'] === 'consultar') ? 'perfilAdminGris' : 'perfilAdmin'; ?>" type="text"
                   value='<?php echo $avVerModificarUsuario['perfil'] ?>'
                   <?php echo ($avVerModificarUsuario['modo'] === 'consultar') ? 'disabled' : ''; ?>>
            <div class="icono"><span></span></div>
        </div>

                
    </div>

    <div class="divBotonesPassAdmin">
        <?php if ($avVerModificarUsuario['modo'] === 'modificar'): ?>
            <button id="botonSessionLogin" class="botonSession" type="submit" name="actualizarPerfil">Actualizar Perfil</button>
        <?php endif; ?>
        <?php if ($avVerModificarUsuario['modo'] === 'modificar'): ?>
            <button id="botonSessionLogin" class="botonSession" type="submit" name="cambiarPassword">ir a Cambiar Contraseña</button>
        <?php endif; ?>

        <div class="botonVolverLogin">
            <button id="botonVolverLogin" class="botonAzul" type="submit" name="cancelar">Volver</button>
        </div>

    </div>
</form>

        </section>
    </div>

</main>