<?php
/**
 * @author: Véro Grué
 * @since: 28/01/2026
 */


// Se comprueba si el botón "volver" ha sido pulsado.
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
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


// Se comprueba si el botón "borrar" ha sido pulsado.
// if (isset($_REQUEST['borrarDepartamento'])) {
//     $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
//     // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
//     $_SESSION['paginaEnCurso'] = 'borrarDepartamento';
//     header('Location: index.php');
//     exit;
// }

// Se comprueba si el botón "cancelar" ha sido pulsado.
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
    header('Location: index.php');
    exit;
}
if (isset($_REQUEST['cambiarPassword'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cambiarPasswordAdmin';
    header('Location: index.php');
    exit;
}



$oUsuarioEnCurso = $_SESSION['usuarioEnCurso'];
$modo = $_SESSION['modoVista']; // 'consultar' o 'modificar'
// Arrays para la gestión de errores y respuestas
$aErrores = [
    'perfil' => null
];
$aRespuestas = [
     'perfil' => $oUsuarioEnCurso->getPerfil()];
$entradaOK = true;

if (isset($_REQUEST['actualizarPerfil'])) {
    // Se Valida el campo usando la librería de validación
    $aErrores['perfil'] = validacionFormularios::comprobarAlfabetico($_REQUEST['perfil'],25,4,1);
    // SE Comprueba si hay errores
    
    if ( $aErrores['perfil'] !== null) {
        $entradaOK = false;
    }

    //  Si entradaOK se modifica el nombre del departamento
    if ($entradaOK) {
       $perfilNuevo=$_REQUEST['perfil'];
        

    $oUsuarioNuevo = UsuarioPDO::modificarUsuarioPorAdmin(
        $oUsuarioEnCurso, 
        $perfilNuevo
    );
        if ($oUsuarioNuevo) {
            // Actualizamos la sesión con el objeto que nos devuelve el modelo
            $_SESSION['usuarioEnCurso'] = $oUsuarioNuevo;
            
            // Redirigimos a la página de inicio
            $_SESSION['paginaEnCurso'] = 'mtoUsuarios';
            header('Location: index.php');
            exit;
        } else {
            // Error técnico en la base de datos (opcional)
            $aErrores['perfil'] = "No se pudo actualizar el nombre en la base de datos.";
        }
    }
}

if ($oUsuarioEnCurso->getNumAccesos() == 0) {
    $fechaAMostrar = 'Nunca';
} else {
    // Si tiene conexiones, obtenemos el objeto DateTime y lo formateamos
    $oFecha = $oUsuarioEnCurso->getFechaHoraUltimaConexion();
    $fechaAMostrar = ($oFecha) ? $oFecha->format('d/m/Y H:i:s') : 'Nunca';
}

$avVerModificarUsuario = [
    'codUsuario' => $oUsuarioEnCurso->getCodUsuario(),
    'descUsuario' => $oUsuarioEnCurso->getDescUsuario(),
    'password'=>$oUsuarioEnCurso->getPassword(),
    'fechaUltimaConexion' => $fechaAMostrar, 
    'perfil' => $oUsuarioEnCurso->getPerfil(),
    'modo' => $modo, 
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];

?>