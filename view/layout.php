<?php

/**
 * @author: Véro Grué
 * Creado el 07/01/2026
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Véro Grué - AplicacionFinal</title>
    <!--Fuente de google font-->
    <!--Para descargar iconos. https://v2.boxicons.com/usage  (import the css)-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <?php if ($_SESSION['paginaEnCurso'] === 'error' || $_SESSION['paginaEnCurso'] === 'wip'): ?>
        <!-- estilos de la pagina de errores -->
        <link rel="stylesheet" href="webroot/css/errorStyle.css">
    <?php else: ?>
        <link rel="stylesheet" href="webroot/css/styles.css">
    <?php endif; ?>
    <!--https://cdnjs.com/libraries/font-awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- personalización del header en función de la pagina -->
    <header class="headerComun <?php echo ($_SESSION['paginaEnCurso'] == 'cuenta') ? 'headerCuenta' : ''; ?>">
        <div class="proyecto">
            <?php if ($_SESSION['paginaEnCurso'] == 'cuenta') { ?>
                <!-- En la página cuenta aparecerá la palabra cuenta al ldo del logo -->
                <p id="textoCuentaLogo">APLICACIÓN<span>&nbsp;</span>FINAL
                    <span id="textoCuenta">Cuenta</span>
                </p>
            <?php } else { ?>
                <p class="letras">
                <p class="letras"><span>A</span><span>P</span><span>L</span><span>C</span><span>A</span><span>C</span><span>I</span><span>O</span><span>N</span></p>
                <!-- <span>&nbsp;</span> -->
                <p class="letras"><span>F</span><span>I</span><span>N</span><span>A</span><span>L</span></p>

            <?php } ?>
            </p>

        </div>
        <!-- </header> -->
        <?php require_once $view[$_SESSION['paginaEnCurso']]; ?>

        <footer>
            <div class="footer">
                <div class="pais">
                    <p>España</p>
                    <div class="divCentral">
                        <div class="phpDoc">
                            <a href="doc/index.html" class="phpdoc" target="_blank">PHPDoc</a>
                        </div>
                        <div class="divCV">
                            <a href="webroot/doc/CV2026.pdf" class="cv" target="_blank">CV</a>
                        </div>
                    </div>
                    <div class="social-media">
                        <a href="https://github.com/verogmayo/VGDWESAplicacionFinal" target="_blank"><i class='bx bxl-github'></i></a>
                    </div>

                </div>
                <div class="footerInfo">
                    <div class="info">
                        <p>
                            2025-26 IES LOS SAUCES. &#169;Todos los derechos reservados.</p>
                        <address><a href="https://veroniquegru.ieslossauces.es/" target="_blank">Véronique Grué.</a>
                            Fecha de Actualización :
                            <time datetime="2026-01-15">15-01-2026</time>
                        </address>
                    </div>
                    <div class="google">
                        <a href="https://www.google.com/"><i class="fa-brands fa-google" style="color: #1a73e8;"></i></a>

                    </div>
                </div>
            </div>
        </footer>
</body>

</html>