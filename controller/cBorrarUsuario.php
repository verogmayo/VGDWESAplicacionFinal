<?php

/**
 * @author: Véro Grué
 * @since: 31/01/2026
 */


// Si se hace clic en el botón volver no sigue y redirige a la página de inicio
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
    header('Location: index.php');
    exit;
}

$oUsuarioEnCurso = $_SESSION['usuarioAEliminar'];
//  Validación y login del boton enviar
if (isset($_REQUEST['borrar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $errorBorrar = "";
    //Si el usuario se borra correctamente, se vuelve a inicio público y sino se muestra un mensaje de error
    if (UsuarioPDO::borrarUsuario($oUsuarioEnCurso)) {
        //Se limpia la variable de usuario en Curso
        unset($_SESSION['usuarioAEliminar']); 
        //SE guarda el mensaje en la session
        $_SESSION['mensajeExito'] = "Usuario eliminado.";
        //se vuelve al la pagina de movimientos Usuarios
        $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
        header('Location: index.php');
        exit;
    } else {
        //Sino se ha podido borrar sale el mensaje
        $errorBorrar="El usuario no se ha podido borrar. Por favor, intentalo más tarde";
    };
}

$avBorrarUsuario = [
    'descUsuario' => $oUsuarioEnCurso->getDescUsuario()
];
// Si hay errores o no se ha enviado, cargar el layout 
require_once $view['layout'];
?>