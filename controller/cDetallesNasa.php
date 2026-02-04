<?php
/**
 * @author: Véro Grué
 * Creado el 28/01/2026
 */


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


// $fechaNasa=$_SESSION['fechaEnCurso'];
$oFotoNasa= $_SESSION['InfoNasa'] ?? null;
// se crea un booleano para comprobar que oFotoNasa es un objeto
$esObjetoNasa = ($oFotoNasa instanceof FotoNasa);

$fechaNasa = new DateTime($oFotoNasa->getFecha());
$avDetallesNasa=[
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'tituloNasa' => $esObjetoNasa ? $oFotoNasa->getTitulo() : "No hay título",
    'fotoSerializadaHD' => $esObjetoNasa ? $oFotoNasa->getImagenHDBase64() : "",
    'fechaNasa' => $esObjetoNasa ? $fechaNasa->format('d/m/Y') : "No hay fecha",
    'explicacionNasa' => $esObjetoNasa ? $oFotoNasa->getExplicacion() : "No hay explicación"
];

// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>

