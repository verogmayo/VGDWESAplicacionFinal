<?php
/**
* @author: Véro Grué
* @since: 15/12/2025
*/

// Se cargan los archivos de configuración
require_once  'config/confAPP.php';
require_once  'config/confDBPDODes.php';


// SE inicia session
session_start();

// si no esta la página en curso en la sesión la creamos con inicio público
if (!isset($_SESSION['paginaEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
}

// cargamos el controlador de la pagina en curso
require_once $controller[$_SESSION['paginaEnCurso']];
?>
