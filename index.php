<?php

/**
 * @author: Véro Grué
 * Creado el 15/12/2025
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

//Se definen la pagina actual
$paginaActual = $_SESSION['paginaEnCurso'];
//se comprueba si la pagina es publica o privada. Si la pagina es publica se va directamente al controlador
if (!in_array($paginaActual, $aPaginasPublicas)) {
    // Si la página no es pública comprobamos si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuarioVGDAWAplicacionFinal'])) {
        // Si no ha iniciado sesión, redirigimos a la página de inicio público
        $_SESSION['paginaEnCurso'] = 'inicioPublico';
        header('Location: index.php');
        exit;
    }
    //Si está iniciada la sesión
    // Se recoge  el perfil del usuario de la sesión y se comprueba si tiene permiso para la página solicitada
    $perfilEnCurso = $_SESSION['usuarioVGDAWAplicacionFinal']->getPerfil();
    if (!in_array($paginaActual, $aRolPerfil[$perfilEnCurso])) {
        // Si el perfil no tiene permiso para la página solicitada, redirigimos a la página de inicio privado
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: index.php');
        exit;
    }
};


// cargamos el controlador de la pagina en curso
require_once $controller[$_SESSION['paginaEnCurso']];
?>
