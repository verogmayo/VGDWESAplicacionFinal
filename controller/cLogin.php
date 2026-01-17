<?php

/**
 * @author: Véro Grué
 * @since: 03/01/2026
 */

// Si se hace clic en el botón volver no sigue y redirige a la página de inicio
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Si se hace clic en el botón crear cuenta no sigue y redirige a la página de registro
if (isset($_REQUEST['crearCuenta'])) {
    $_SESSION['paginaEnCurso'] = 'registro';
    header('Location: index.php');
    exit;
}

// Arrays para errores y respuestas
$aErrores = [
    'codUsuario' => null,
    'password' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación y login del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['codUsuario'], 255, 0, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 20, 2, 1, 1);


    // Verificar si hay errores de validación
    foreach ($aErrores as $valorCampo => $msjError) {
        if ($msjError != null) {
            $entradaOK = false;
        }
    }


    if ($entradaOK) {
        $oUsuario = UsuarioPDO::validarUsuario($_REQUEST['codUsuario'], $_REQUEST['password']);
        // si no esta en la base de datos entrada ok false
        if (!isset($oUsuario)) {
            $entradaOK = false;
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}
    if ($entradaOK) {
        $oUsuario = UsuarioPDO::actualizarUltimaConexion($oUsuario);
        // Login correcto, se crea el usuario en la sesión
        $_SESSION['usuarioVGDAWAppAplicacionFinal'] = $oUsuario;
        // Si el login es correcto, se redirige a la página de inicio privado
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: index.php');
        exit;
    }


// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
