<?php
session_start();
require_once "../config/confDBPDODes.php"; 
require_once "../model/DBPDO.php";
require_once "../model/UsuarioPDO.php";
require_once "../model/Usuario.php";

header('Content-Type: application/json; charset=utf-8');

// Se recoge la descripción si existe
$desc = $_GET['descUsuario'] ?? '';

// Se llama al modelo (que devuelve un array de objetos)
$aObjetoUsuarios = UsuarioPDO::buscarUsuariosPorDesc($desc);

$respuesta = ['status' => 'success', 'data' => []];

if ($aObjetoUsuarios) {
    foreach ($aObjetoUsuarios as $oUsuario) {
        // Preparamos los datos para el JSON
        $respuesta['data'][] = [
            'codUsuario' => $oUsuario->getCodUsuario(),
            'descUsuario' => $oUsuario->getDescUsuario(),
            'numAccesos' => $oUsuario->getNumAccesos(),
            'fechaUltimaConexion' => $oUsuario->getFechaHoraUltimaConexion() ? $oUsuario->getFechaHoraUltimaConexion()->format('d/m/Y H:i:s') : 'Nunca',
            'perfil' => $oUsuario->getPerfil(),
            'imagenUsuario' => $oUsuario->getImagenUsuario()
        ];
    }
}

echo json_encode($respuesta, JSON_PRETTY_PRINT);