<?php
/**
* @author: Véro Grué
* @since: 28/01/2026
*/

// Se comprueba si el botón "volver" ha sido pulsado.
if(isset($_REQUEST['volver'])){
     $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// Comprobamos si el botón "cerrar" ha sido pulsado, cierra la session.
if(isset($_REQUEST['cerrar'])){
    $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Se comprueba si el botón "cuenta" ha sido pulsado.
if(isset($_REQUEST['cuenta'])){
    $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}
$avDetalles = [
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];

?>