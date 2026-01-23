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
                    <?php


                    echo "<h2>BIENVENIDO/A " . $avInicioPrivado['descUsuario'] . "</h2>";

                    if ($avInicioPrivado['numAccesos'] <= 1) {
                        echo "¡Esta es tu primera conexión!<br>";
                    } else {
                        // Si fechaAnterior ya es un objeto DateTime no hace falta hacer el "new DateTime", se puede usar:
                        if ($avInicioPrivado['fechaHoraUltimaConexionAnterior'] instanceof DateTime) {
                            // Formatear la fecha y hora según la configuración regional española
                            //IntlDateFormatter::FULL - muestra la fecha completa (día de la semana, día, mes y año)
                            //IntlDateFormatter::LONG - mostraría la fecha (día, mes y año)
                            //IntlDateFormatter::MEDIUM - mostraría la fecha abreviada (ejemplo:12 ene 2025)
                            //IntlDateFormatter::NONE - no muestra la hora
                            $oFormatoFecha = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE);

                            $fecha = $oFormatoFecha->format($avInicioPrivado['fechaHoraUltimaConexionAnterior']);
                            $hora = $avInicioPrivado['fechaHoraUltimaConexionAnterior']->format('H:i');
                            echo "Esta es la vez número " . $avInicioPrivado['numAccesos'] . " que se conecta.<br>";
                            echo "Usted se conectó por última vez el <br>";
                            echo $fecha . " a las " . $hora;
                        }
                    }
                    ?>
                </div>
                <div class="botones">
                    <form>
                        <button class="botonCentral" type="submit" name="rest" id="rest">REST</button>
                        <button class="botonCentral" type="submit" name="detalles" id="detalles">Detalles</button>
                        <button class="botonCentral" type="submit" name="error" id="error">Error</button>
                        <button class="botonCentral" type="submit" name="dpto" id="dpto">Mantenimiento de Departamentos</button>
                    </form>
                </div>
            </section>
        </main>