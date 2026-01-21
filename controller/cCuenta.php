<?php

/**
 * @author: Véro Grué
 * @since: 14/01/2026
 */
//Si no se iniciado session, se redirige a la pagina de inicio publico
if (empty($_SESSION['usuarioVGDAWAppAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

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
$oUsuarioActual = $_SESSION['usuarioVGDAWAppAplicacionFinal'];
if (isset($_REQUEST['enviar'])) {
    //Se coge el nuevo nombre
    $nuevoNombre = $_REQUEST['descUsuario'];
    //Se llama al modelo para actualizar el nombre
    $oUsuarioNuevo = UsuarioPDO::modificarUsuario($oUsuarioActual, $nuevoNombre);
    //Se cambia la descrusuario de la session y se vuelve a  inicio privado
    if ($oUsuarioNuevo) {
        $_SESSION['usuarioVGDAWAppAplicacionFinal'] = $oUsuarioNuevo;
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: index.php');
        exit;
    }
}
$avCuenta = [
    'codUsuario' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getCodUsuario(),
    'descUsuario' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getDescUsuario(),
    'numAccesos' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexionAnterior' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getFechaHoraUltimaConexionAnterior()? $_SESSION['usuarioVGDAWAppAplicacionFinal']->getFechaHoraUltimaConexionAnterior()->format('d/m/Y H:i:s'):'Primera Conexión',
    'fechaHoraUltimaConexion' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getFechaHoraUltimaConexion()->format('d/m/Y H:i:s'),
    'perfil' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getPerfil(),
    'imagenUsuario' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getImagenUsuario(),
    'inicial' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
