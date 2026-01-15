<?php

/**
 * @author: Véro Grué
 * @since: 07/01/2026
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Véro Grué - DWESAplicacionFinal</title>
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
            <?php if ($_SESSION['paginaEnCurso'] == 'cuenta' ) { ?>
                <!-- En la página cuenta aparecerá la palabra cuenta al ldo del logo -->
                <p id="textoCuentaLogo">LOGIN<span>&nbsp;</span>LOGOFF
                    <span id="textoCuenta">Cuenta</span>
                </p>
            <?php } else { ?>
                <p class="letras">
                    <span>L</span><span>O</span><span>G</span><span>I</span><span>N</span>
                    <span>&nbsp;</span>
                    <span>L</span><span>O</span><span>G</span><span>O</span><span>F</span><span>F</span>
                <?php } ?>
                </p>

        </div>
        <!-- </header> -->
        <?php require_once $view[$_SESSION['paginaEnCurso']]; ?>

        <footer>
            <div class="footer">
                <div class="pais">
                    <p>España</p>
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
                            <time datetime="2025-12-15"></time> 07-01-2026
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