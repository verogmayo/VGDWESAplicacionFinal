<?php

require_once "../config/confDBPDODes.php";
require_once "../model/DBPDO.php";
require_once "../model/UsuarioPDO.php";
require_once "../core/libreriaValidacion.php";

header('Content-Type: application/json; charset=utf-8');

// Variable para la respuesta que leerá el codigo de javascript
$responseJs = [
    'estadoCambiarPswd' => 'error',
    'msj' => '',
    'errores' => []
];

$aErrores = [
    'password' => null,
    'confirmaPassword' => null
];

$entradaOK = true;

//Se recogen los datos 
$codUsuario = $_REQUEST['codUsuario'] ?? '';
$password = $_REQUEST['password'] ?? '';
$confirmaPassword = $_REQUEST['confirmaPassword'] ?? '';

if ($codUsuario) {
    // Se n
    $aErrores['password'] = validacionFormularios::validarPassword($password, 8, 4, 1, 1);
    $aErrores['confirmaPassword'] = validacionFormularios::validarPassword($confirmaPassword, 8, 4, 1, 1);

    // Se verifica si hay errores de validación
    foreach ($aErrores as $msjError) {
        if ($msjError != null) {
            $entradaOK = false;
        }
    }

    // Si el formato es correcto, se mira si coinciden las contraseñas
    if ($entradaOK) {
        if ($password !== $confirmaPassword) {
            $aErrores['confirmaPassword'] = "Las nuevas contraseñas no coinciden.";
            $entradaOK = false;
        }
    }

    // Si está todo bien se hace el cambio en la db
    if ($entradaOK) {
        // Se llama al modelo
        if (UsuarioPDO::cambiarPasswordPorCod($codUsuario, $password)) {
            $responseJs['estadoCambiarPswd'] = 'exito';
            $responseJs['msj'] = "Contraseña de $codUsuario actualizada correctamente.";

                      
        } else {
            $responseJs['msj'] = "Error técnico: No se pudo actualizar en la base de datos.";
        }
    } else {
        $responseJs['msj'] = "Hay errores en los datos enviados.";
        $responseJs['errores'] = $aErrores;
    }
} else {
    $responseJs['msj'] = "Faltan datos.";
}

echo json_encode($responseJs, JSON_PRETTY_PRINT);
?>