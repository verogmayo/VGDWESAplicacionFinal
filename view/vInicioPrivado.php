        <div class="tituloCentral">
            <p>INICIO PRIVADO</p>

        </div>
        <nav>
            <form class="botonesDetalles" action="">
                <button class="idioma seleccionado" type="submit" name="<?php echo $idiomaActivo; ?>" id="<?php echo $idiomaActivo; ?>">
                    <img src="<?php echo $banderaActual['img']; ?>" alt="" />
                </button>

                <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta">
                    <?php echo $avInicioPrivado['inicial']; ?>
                </button>

                <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sesión</button>
            </form>
        </nav>

        </header>
        <main>
            <section>
                <div class="titulo2">
                    <h2><?php echo $avMensajeBienvenida['bienvenida']; ?></h2>
                    <p><?php echo $avMensajeBienvenida['detalle']; ?></p>

                    <?php if (isset($avMensajeBienvenida['ultimaC'])): ?>
                        <p><?php echo $avMensajeBienvenida['ultimaC']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="botones">
                    <form>
                        <button class="botonCentral" type="submit" name="rest" id="rest">REST</button>
                        <button class="botonCentral" type="submit" name="detalles" id="detalles">Detalles</button>
                        <button class="botonCentral" type="submit" name="error" id="error">Error</button>
                        <button class="botonCentral" type="submit" name="dpto" id="dpto">Mantenimiento de Departamento</button>
                    </form>
                </div>
            </section>
        </main>