<?php

/**
 * @author: Véro Grué
 * Creado el 28/01/2026
 */


// Se comprueba si el botón "volver" ha sido pulsado.
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// Comprobamos si el botón "cerrar" ha sido pulsado, cierra la session.
if (isset($_REQUEST['cerrar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Se comprueba si el botón "cambiarPassword" ha sido pulsado.
if (isset($_REQUEST['cambiarPassword'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cambiarPassword';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "borrar" ha sido pulsado.
if (isset($_REQUEST['borrarCuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'borrarCuenta';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "cancelar" ha sido pulsado.
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}


// Ususario de la session
$oUsuarioActual = $_SESSION['usuarioVGDAWAplicacionFinal'];

// Arrays para la gestión de errores y respuestas
$aErrores = ['descUsuario' => null];
$aRespuestas = ['descUsuario' => $oUsuarioActual->getDescUsuario()];
$entradaOK = true;

if (isset($_REQUEST['enviar'])) {
    // Se Valida el campo usando tu librería de validación
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 4, 1);

    // SE Comprueba si hay errores
    if ($aErrores['descUsuario'] !== null) {
        $entradaOK = false;
    }

    //  Si entradaOK se modifica el nombre del usuario
    if ($entradaOK) {
        $nuevoNombre = $_REQUEST['descUsuario'];
        
        // Llamamos al modelo
        $oUsuarioNuevo = UsuarioPDO::modificarUsuario($oUsuarioActual, $nuevoNombre);

        if ($oUsuarioNuevo) {
            // Actualizamos la sesión con el objeto que nos devuelve el modelo
            $_SESSION['usuarioVGDAWAplicacionFinal'] = $oUsuarioNuevo;
            
            // Redirigimos a la página de inicio
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
            // Error técnico en la base de datos (opcional)
            $aErrores['descUsuario'] = "No se pudo actualizar el nombre en la base de datos.";
        }
    }
}



$avCuenta = [
    'codUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getCodUsuario(),
    'descUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getDescUsuario(),
    'numAccesos' => $_SESSION['usuarioVGDAWAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexionAnterior' => $_SESSION['usuarioVGDAWAplicacionFinal']->getFechaHoraUltimaConexionAnterior() ? $_SESSION['usuarioVGDAWAplicacionFinal']->getFechaHoraUltimaConexionAnterior()->format('d/m/Y H:i:s') : 'Primera Conexión',
    'fechaHoraUltimaConexion' => $_SESSION['usuarioVGDAWAplicacionFinal']->getFechaHoraUltimaConexion()->format('d/m/Y H:i:s'),
    'perfil' => $_SESSION['usuarioVGDAWAplicacionFinal']->getPerfil(),
    'imagenUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getImagenUsuario(),
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
