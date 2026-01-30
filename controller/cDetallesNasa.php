<?php
/**
 * @author: Véro Grué
 * @since: 20/01/2026
 */

//Si no se iniciado session, se redirige a la pagina de inicio publico
if (empty($_SESSION['usuarioVGDAWAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
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
// Se comprueba si el botón "volver" ha sido pulsado.
if(isset($_REQUEST['volver'])){
     $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
     $_SESSION['fechaAnterior'] = $_SESSION['fechaEncurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}
// $oFotoNasa = null;
// if(isset($_SESSION['fotoNasa'])){
//     $oFotoNasa = $_SESSION['InfoNasa'];
// }

// $fechaNasa=$_SESSION['fechaEnCurso'];
$oFotoNasa= $_SESSION['InfoNasa'] ?? null;
$avDetallesNasa=[
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'tituloNasa' => ($oFotoNasa) ? $oFotoNasa->getTitulo() : "No hay datos",
    'fotoNasaHD' => ($oFotoNasa) ? $oFotoNasa->getUrlhd(): "",
    // 'fechaNasa' => $fechaNasa,
    'fechaNasa' => ($oFotoNasa) ? $oFotoNasa->getFecha() : "No hay datos",
    'explicacionNasa' => ($oFotoNasa) ? $oFotoNasa->getExplicacion() : ""
];

// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>

