<?php

/**
 * @author: Véro Grué
 * @since: 27/01/2026
 */

// Si se hace clic en el botón volver no sigue y redirige a mantenimiento departamentos
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}

// Arrays para errores y respuestas
$aErrores = [
    'codDepartamento' => null,
    'descDepartamento' => null,
    'fechaCreacionDepartamento' => null,
    'volumenDeNegocio' => null
];

$aRespuestas = [
    'codDepartamento' => '',
    'descDepartamento' => '',
    'fechaCreacionDepartamento' => '',
    'volumenDeNegocio' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, 1);
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    $aErrores['fechaCreacionDepartamento'] = validacionFormularios::validarFecha($_REQUEST['fechaCreacionDepartamento'], null, null, 1);
    $aErrores['volumenDeNegocio'] = validacionFormularios::validarFloat($_REQUEST['volumenDeNegocio'], PHP_FLOAT_MAX, PHP_FLOAT_MIN, 1);
    $aErrores['preguntaSeguridad'] = miLibreriaStatic::comprobarPreguntaSeguridad($_REQUEST['preguntaSeguridad'], $valoresValidos, 1);

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
