<div class="tituloCentralCuenta">
    <h3></h3>
</div>
<form class="botonesCuenta">
    <div id="botonVolverCuentadiv">
        <button id="botonVolverCuenta" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avCuenta['inicial']; ?></button>
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
        <h1>Información personal</h1>
    </div>
    <div class="paginaCuentaContainer">
        <aside class="menuLateral">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="menuCuenta  activo">
                            <span class="iconoMenu li1"><i class="fa-regular fa-address-book"></i></span>
                            Información personal
                        </a>
                    </li>
                    <form method="post">
                        <li>
                            <button type="submit" name="borrarCuenta" class="menuCuenta"
                                id="botonMenuCuenta">
                                <span class="iconoMenu li3"><i class="fa-solid fa-eraser"></i></span>
                                Borrar cuenta
                            </button>

                        </li>
                    </form>
                </ul>
            </nav>
        </aside>
        <section class="contenidoPerfil">
            <form method="post">
                <div class="tablaDatosGrid">
                    <div class="filaDato filaDesplegable">
                        <div class="etiqueta">FOTO DE PERFIL</div>
                        <div class="valor">
                            <div class="contenedorFoto">
                                <?php if ($avCuenta['imagenUsuario']): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($avCuenta['imagenUsuario']); ?>"
                                       ">
                                <?php else: ?>
                                    <span class="inicialGrande"><?php echo $avCuenta['inicial']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="desplegable">
                                
                                <input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/*" style="display:block;" ">
                            </div>
                        </div>
                        <div class="icono"><span class="flecha">&rsaquo;</span></div>
                    </div>

                    <div class="filaDato">
                        <div class="etiqueta">NOMBRE</div>
                        <input name="descUsuario" id="descUsuario" type="text" placeholder=" " value='<?php echo $avCuenta['descUsuario'] ?>'>
                        <div class="icono"><span></span></div>
                    </div>

                    <div class="filaDato">
                        <div class="etiqueta">USUARIO</div>
                        <input name="codUsuario" id="codUsuario" type="text" placeholder=" " value='<?php echo $avCuenta['codUsuario'] ?>' disabled>
                        <div class="icono"><span></span></div>
                    </div>
                    <div class="filaDato filaDesplegable">
                        <div class="etiqueta">CONTRASEÑA</div>
                        <div class="valor">
                            <input type="password" name="passwordCuenta" id="passwordCuenta" value="********" disabled>
                            <div class="desplegable">
                                <button type="submit" name="cambiarPassword" class="botonCambiarPswd">Cambiar contraseña</button>
                            </div>
                        </div>
                        <div class="icono"><span class="flecha">&rsaquo;</span></div>
                    </div>

                    <div class="filaDato">
                        <div class="etiqueta">PERFIL</div>
                        <input name="perfil" id="perfil" type="text" placeholder=" " value='<?php echo $avCuenta['perfil'] ?>' disabled>
                        <div class="valor"></div>
                        <div class="icono"><span></span></div>
                    </div>
                    <div class="filaDato">
                        <div class="etiqueta">NUMERO DE CONEXIONES</div>
                        <input name="numAccesos" id="numAccesos" type="number" placeholder=" " value='<?php echo $avCuenta['numAccesos'] ?>' disabled>
                        <div class="icono"><span></span></div>
                    </div>
                    <div class="filaDato">
                        <div class="etiqueta">FECHA Y HORA DE LA ULTIMA CONEXIÓN</div>
                        <input type="datetime" name="fechaHoraUltimaConexion" id="fechaHoraUltimaConexion" value='<?php echo $avCuenta['fechaHoraUltimaConexion'] ?>' disabled>
                        <div class="icono"><span></span></div>
                    </div>
                    <div class="filaDato">
                        <div class="etiqueta">FECHA Y HORA DE LA ULTIMA CONEXIÓN ANTERIOR</div>
                        <input type="datetime" name="fechaHoraUltimaConexionAnterior" id="fechaHoraUltimaConexionAnterior" value='<?php echo $avCuenta['fechaHoraUltimaConexionAnterior'] ?>' disabled>
                        <div class="icono"><span></span></div>
                    </div>
                </div>
                <div class="divBotones">
                    <button id="botonSessionLogin" class="botonSession" type="submit" name="enviar">Enviar</button>
                    <div class="botonVolverLogin">
                        <button id="botonVolverLogin" class="botonAzul" type="submit" name="cancelar">Volver</button>
                    </div>
                </div>
            </form>

        </section>
    </div>

</main>