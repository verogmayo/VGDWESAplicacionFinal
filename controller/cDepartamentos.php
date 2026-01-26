<?php

/**
 * @author: Véro Grué
 * @since: 23/01/2026
 */
if (empty($_SESSION['usuarioVGDAWAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
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
// Inicialización de variables 
$aErrores = [
    'descDepartamento' => null
];

$entradaOK = true;

// Si se ha pulsado buscar
if (isset($_REQUEST['buscar'])) {
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 0, 0);

    if ($aErrores['descDepartamento'] != null) {
        $entradaOK = false;
    }
} else {
    $entradaOK = false;
}

// Si la entrada es OK, se hace la busqueda
if ($entradaOK) {
    $descripcionBuscada = $_REQUEST['descDepartamento'];
}else{
    $descripcionBuscada="";
}

$listaDepartamentos = DepartamentoPDO::buscarDepartamentoPorDesc($descripcionBuscada);
$avDepartamentos = [
    'dptos' => $listaDepartamentos,
    'errores' => $aErrores,
    'busqueda' => $descripcionBuscada,
    'codUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getCodUsuario(),
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal
require_once $view['layout'];
