<?php

/**
 * @author: Véro Grué
 * @since: 14/01/2026
 */

//Si no se iniciado session, se redirige a la pagina de inicio publico
if (empty($_SESSION['usuarioVGDAWAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}
// Si se hace clic en el botón volver no sigue y redirige a la página de inicio
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}


//  Validación y login del boton enviar
if (isset($_REQUEST['borrar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $errorBorrar = "";
    //Si el usuario se borra correctamente, se vuelve a inicio público y sino se muestra un mensaje de error
    if (UsuarioPDO::borrarUsuario($_SESSION['usuarioVGDAWAplicacionFinal'])) {
        //Se limpia el array de sesión
        $_SESSION = array();
        //Se destruye la sesión
        session_destroy();
        //Redirige a la página de inicio público     
        //$_SESSION['paginaEnCurso'] = 'inicioPublico';
        header('Location: index.php');
        exit;
    } else {
        //Sino se ha podido borrar sale el mensaje
        $errorBorrar="El usuario no se ha podido borrar. Por favor, intentalo más tarde";
    };
}

// Si hay errores o no se ha enviado, cargar el layout 
require_once $view['layout'];
?>