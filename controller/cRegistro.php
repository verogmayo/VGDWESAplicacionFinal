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
    'confirmaPassword' => null,
    'preguntaSeguridad' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => '',
    'descUsuario' => '',
    'confirmaPassword' => '',
    'preguntaSeguridad' => ''
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
    //Valores validos para la pregunta de seguridad
    // $valoresValidos=['pimentel'];
    define("RSEGURIDAD", "pimentel");
    if (empty($_REQUEST['preguntaSeguridad']) ){
        $aErrores['preguntaSeguridad'] = "La pregunta de seguridad no puede estar vacía";
     }elseif($_REQUEST['preguntaSeguridad'] !== RSEGURIDAD) {
         $aErrores['preguntaSeguridad'] = "La pregunta de seguridad es incorrecta";
    } else {
        $aErrores['preguntaSeguridad'] = null;
    }
    // $aErrores['preguntaSeguridad'] = miLibreriaStatic::comprobarPreguntaSeguridad($_REQUEST['preguntaSeguridad'], $valoresValidos, 1);

    //se comprueba que las contraseñas coincidan
    if ($_REQUEST['password'] !== $_REQUEST['confirmaPassword']) {
        $aErrores['confirmaPassword'] = "Las nuevas contraseñas no coinciden.";
        $entradaOK = false;
    }

    // Guardar las respuestas para rellenar el formulario si hay algun error
    $aRespuestas['codUsuario'] = $_REQUEST['codUsuario'];
    $aRespuestas['password'] = $_REQUEST['password'];
    $aRespuestas['descUsuario'] = $_REQUEST['descUsuario'];
    $aRespuestas['confirmaPassword'] = $_REQUEST['confirmaPassword'];
    $aRespuestas['preguntaSeguridad'] = $_REQUEST['preguntaSeguridad'];

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
                $_SESSION['usuarioVGDAWAplicacionFinal'] = $oUsuario;
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
$avRegistro = [
    'codUsuario' => $aRespuestas['codUsuario'],
    'password' => $aRespuestas['password'],
    'descUsuario' => $aRespuestas['descUsuario'],
    'confirmaPassword' => $aRespuestas['confirmaPassword'],
    'preguntaSeguridad' => $aRespuestas['preguntaSeguridad'],
    'aErrores' => $aErrores
];

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
