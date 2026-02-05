<?php
//se inicia la session sin da error
session_start();
// SE Importa la configuración y los modelos necesarios
require_once "../config/confDBPDODes.php"; 
require_once "../model/DBPDO.php";
require_once "../model/UsuarioPDO.php";
require_once "../model/Usuario.php";

// Se Indica al navegador que lo que viene es un JSON, no un HTML
header('Content-Type: application/json; charset=utf-8');

// SE Crea un array para la respuesta
$respuesta = [
    'status' => 'error',
    'data' => null
];

// Se Comprueba si nos pasan el código por la URL (ej: buscarUsuario.php?codUsuario=hermes)
if (isset($_GET['codUsuario'])) {
    $oUsuario = UsuarioPDO::buscarUsuarioPorCod($_GET['codUsuario']);

    if ($oUsuario) {
        $respuesta['status'] = 'success';
        $respuesta['data'] = [
            'codigo' => $oUsuario->getCodUsuario(),
            'descripcion' => $oUsuario->getDescUsuario(),
            'perfil' => $oUsuario->getPerfil(),
            'conexiones' => $oUsuario->getNumAccesos()
        ];
    } else {
        $respuesta['message'] = 'Usuario no encontrado en la base de datos.';
    }
} else {
    $respuesta['message'] = 'Falta el parámetro codUsuario.';
}

// Se Convierte el array en el formato JSON que entiende cualquier API
echo json_encode($respuesta, JSON_PRETTY_PRINT);