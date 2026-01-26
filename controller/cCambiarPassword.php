<?php

/**
 * @author: Véro Grué
 * @since: 03/01/2026
 */

// Si se hace clic en el botón volver no sigue y redirige al ceunta
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}


// Arrays para errores y respuestas
$aErrores = [
    'passwordActual' => null,
    'password' => null,
    'confirmaPassword' => null
];

$aRespuestas = [
    'passwordActual' => '',
    'password' => '',
    'confirmaPassword' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación y login del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['passwordActual'] = validacionFormularios::validarPassword($_REQUEST['passwordActual'], 8, 4, 1, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
    $aErrores['confirmaPassword'] = validacionFormularios::validarPassword($_REQUEST['confirmaPassword'], 8, 4, 1, 1);

    // Guardar las respuestas para rellenar el formulario si hay algun error
    $aRespuestas['passwordActual'] = $_REQUEST['passwordActual'];
    $aRespuestas['password'] = $_REQUEST['password'];
    $aRespuestas['confirmaPassword'] = $_REQUEST['confirmaPassword'];

    // Verificar si hay errores de validación
    foreach ($aErrores as $valorCampo => $msjError) {
        if ($msjError != null) {
            $entradaOK = false;
        }
    }

    // Si la validación es correcta, validar con la BD
    if ($entradaOK) {
        // Se obtiene el usuario actual 
        $oUsuarioActual = $_SESSION['usuarioVGDAWAplicacionFinal'];

        // Se verifica que la contraseña actual es correcta
        $passwordActualHasheada = hash('sha256', $oUsuarioActual->getCodUsuario() . $_REQUEST['passwordActual']);

        if ($oUsuarioActual->getPassword() !== $passwordActualHasheada) {
            $aErrores['passwordActual'] = "La contraseña actual no es correcta.";
            $entradaOK = false;
        }
        // SE verifica que las nuevas contraseñas coinciden o no
        if ($_REQUEST['password'] !== $_REQUEST['confirmaPassword']) {
            $aErrores['confirmaPassword'] = "Las nuevas contraseñas no coinciden.";
            $entradaOK = false;
        } 
        
    }
    // Si todo es correcto, se cambia la contraseña
    if ($entradaOK) {
        $oUsuarioModificado = UsuarioPDO::cambiarPassword(
            $_SESSION['usuarioVGDAWAplicacionFinal'], 
            $_REQUEST['password']
        );
        // si se ha cambiado correctamente, se actualiza la sesión y se redirige a la página cuenta
        if ($oUsuarioModificado != null) {
            $_SESSION['usuarioVGDAWAplicacionFinal'] = $oUsuarioModificado;
            //para poner un mensaje de contraseña cambiada, en la pagina cuenta, hay que guardar el valoe en sesion porque sino se pierde al hacer el cmabio de pagina. 
            $_SESSION['mensajeExito']= "Contraseña cambiada correctamente.";
            $_SESSION['paginaEnCurso'] = 'cuenta';
            header('Location: index.php');
            exit;
        } else {
            $entradaOK = false;
            $errorCambioContraseña="No se ha podido cambiar la contraseña. Por favor, inténtalo de nuevo.";
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
