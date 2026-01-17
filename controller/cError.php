<?php
/**
 * @author: Véro Grué
 * @since: 10/01/2026
 */

$avError = [
    'codError' => '',
    'descError' => '',
    'archivoError' => '',
    'lineaError' => '',
    'paginaSiguiente' => ''
];
//SE recoge los datos del error guardados en la sesión
if(isset($_SESSION['error'])){
$oError=$_SESSION['error'];
$avError=[
    'codError'=>$oError->getCodError(),
    'descError'=>$oError->getDescError(),
    'archivoError'=>$oError->getArchivoError(),
    'lineaError'=>$oError->getLineaError(),
    'paginaSiguiente'=>$oError->getPaginaSiguiente()
];
unset($_SESSION['error']);
}



if(isset($_REQUEST['volver'])){
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>