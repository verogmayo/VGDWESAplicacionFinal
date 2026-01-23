<?php
/**
 * @author: Véro Grué
 * @since: 23/01/2026
 */
if (empty($_SESSION['usuarioVGDAWAppAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}
 
if(isset($_REQUEST['volver'])){
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}
$avDepartamentos = [
     'codUsuario' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getCodUsuario(),
     'inicial' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>