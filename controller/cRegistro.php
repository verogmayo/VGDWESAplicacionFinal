<?php

/**
 * @author: Véro Grué
 * @since: 03/01/2026
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
    'confirmaPassword' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => '',
    'descUsuario' => '',
    'confirmaPassword' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación y login del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['codUsuario'], 8, 4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 4, 1);
    $aErrores['confirmaPassword'] = validacionFormularios::validarPassword($_REQUEST['confirmaPassword'], 8, 4, 1, 1);

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
        if (UsuarioPDO::validarCodigoNoExiste($_REQUEST['codUsuario'])) {
            $aErrores['codUsuario'] = "El nombre de usuario ya existe.";
            $entradaOK = false;
        if ($_REQUEST['password'] !== $_REQUEST['confirmaPassword']) {
            $aErrores['confirmaPassword'] = "Las nuevas contraseñas no coinciden.";
            $entradaOK = false;
        } 
        } else {
            // Si no existe, se crea el nuevo usuario
            $oUsuario = UsuarioPDO::crearUsuario(
                $_REQUEST['codUsuario'],
                $_REQUEST['password'],
                $_REQUEST['descUsuario']
            );

            if ($oUsuario === null) {
                $entradaOK = false;
                //Se crea el error en el caso de que no se pueda crear el usuario
                $_SESSION['errorRegistro'] = "Error al crear el usuario. Por favor, inténtalo de nuevo.";
                //Se redirige al login 
                $_SESSION['paginaEnCurso'] = 'login';
                header('Location: index.php');
                exit;
            } else {
                // Login correcto
                $_SESSION['usuarioVGDAWAppAplicacionFinal'] = $oUsuario;
                // Se saca la inicial del usuario aqui para poder utilizarla en el boton de cuenta.
                // Se saca el nombre del usuario.
                // $nombre = $oUsuario->getDescUsuario();
                // //Se saca la inicial. https://www.php.net/manual/fr/function.mb-strtoupper.php  (caracteres en mayúsculas)
                // //https://www.php.net/manual/fr/function.mb-strtoupper.php (primer caracter)
                // $_SESSION['inicialVGDAW'] = mb_strtoupper(mb_substr($nombre, 0, 1));
                $_SESSION['paginaEnCurso'] = 'inicioPrivado';
                header('Location: index.php');
                exit;
            }
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
