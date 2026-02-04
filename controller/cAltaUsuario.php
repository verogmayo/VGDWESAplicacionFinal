<?php

/**
 * @author: Véro Grué
 * Creado el 31/01/2026
 */

// Si se hace clic en el botón volver no sigue y redirige al login
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

// Arrays para errores y respuestas
$aErrores = [
    'codUsuario' => null,
    'password' => null,
    'descUsuario' => null,
    'confirmaPassword' => null,
    'perfil' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => '',
    'descUsuario' => '',
    'confirmaPassword' => '',
    'perfil' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación y login del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'], 8, 4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'], 255, 4, 1);
    $aErrores['perfil'] = validacionFormularios::comprobarAlfabetico($_REQUEST['perfil'], 15, 4, 1);
    $aErrores['confirmaPassword'] = validacionFormularios::validarPassword($_REQUEST['confirmaPassword'], 8, 4, 1, 1);
  
    

    //se comprueba que las contraseñas coincidan
   if ($aErrores['password'] == null && $aErrores['confirmaPassword'] == null) {
        if ($_REQUEST['password'] !== $_REQUEST['confirmaPassword']) {
            $aErrores['confirmaPassword'] = "Las contraseñas no coinciden.";
        }
    }
    // Guardar las respuestas para rellenar el formulario si hay algun error
    $aRespuestas['codUsuario'] = $_REQUEST['codUsuario'];
    $aRespuestas['password'] = $_REQUEST['password'];
    $aRespuestas['descUsuario'] = $_REQUEST['descUsuario'];
    $aRespuestas['confirmaPassword'] = $_REQUEST['confirmaPassword'];
    

    // Verificar si hay errores de validación
    foreach ($aErrores as $valorCampo => $msjError) {
        if ($msjError != null) {
            $entradaOK = false;
        }
    }

    // Si la validación es correcta, validar con la BD
    if ($entradaOK) {
        // Se comprueba si el código de usuario ya existe
        if (UsuarioPDO::validarCodUsuarioExiste($_REQUEST['codUsuario'])) {
            $aErrores['codUsuario'] = "El nombre de usuario ya existe.";
            $entradaOK = false;
        } else {
            // Si no existe, se crea el nuevo usuario
            $oUsuario = UsuarioPDO::crearUsuarioPorAdmin(
                $_REQUEST['codUsuario'],
                $_REQUEST['password'],
                $_REQUEST['descUsuario'],
                $_REQUEST['perfil']
            );

           if ($oUsuario) {
                $_SESSION['mensajeExito'] = "Usuario creado con éxito.";
                $_SESSION['paginaEnCurso'] = 'mtoUsuarios'; 
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['errorRegistro'] = "Error técnico al crear el usuario.";
            }
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}
$avAltaUsuario = [
    'codUsuario' => $aRespuestas['codUsuario'],
    'password' => $aRespuestas['password'],
    'descUsuario' => $aRespuestas['descUsuario'],
    'confirmaPassword' => $aRespuestas['confirmaPassword'],
    'aErrores' => $aErrores
];

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
