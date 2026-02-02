<?php

/**
 * @author: Véro Grué
 * @since:28/01/2026
 */

// Se comprueba si el botón "detalles" ha sido pulsado.
if (isset($_REQUEST['detalles'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'detalles';
    header('Location: index.php');
    exit;
}

// Se comprueba si el botón "cerrar" ha sido pulsado.
if (isset($_REQUEST['cerrar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Se comprueba si el botón "cuenta" ha sido pulsado.
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}

// Se comprueba si el botón "error" ha sido pulsado.
if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "dpto" ha sido pulsado.
if (isset($_REQUEST['dpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'dpto';
    $_SESSION['busquedaEnCurso'] = $_SESSION['busquedaDepartamentos'];
    header('Location: index.php');
    exit;
}
//se compueba si se ha pulsado el boton "rest"
if (isset($_REQUEST['rest'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}


if (isset($_REQUEST['mtoUsuarios'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
    header('Location: index.php');
    exit;
}
// Determinar el idioma (si no hubiera cookie, que sea 'es')
$idioma = $_COOKIE['idioma'] ?? 'es';

//SE obtiene el perfil del usuario
$perfilActual = $_SESSION['usuarioVGDAWAplicacionFinal']->getPerfil();


//Se crea un array con los datos del usuario para pasarlos a la vista
$avInicioPrivado = [
    'descUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getDescUsuario(),
    'numAccesos' => $_SESSION['usuarioVGDAWAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexionAnterior' => $_SESSION['usuarioVGDAWAplicacionFinal']->getFechaHoraUltimaConexionAnterior(),
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'perfil' => $aRolPerfil[$perfilActual]
];


// Para las banderas de la vista (pasar cuál está seleccionada)
$idiomaActivo = $idioma;
$aConfigBandera = [
    'es' => ['img' => 'webroot/images/banderaEs.png'],
    'en' => ['img' => 'webroot/images/banderaGb.png'],
    'fr' => ['img' => 'webroot/images/banderaFr.png']
];
$banderaActual = $aConfigBandera[$idiomaActivo];

//Se cargará la vista y está dispondrá de los datos del usuario en el array $avInicioPrivado

// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
