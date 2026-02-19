<?php

require_once '../config/confDBPDODes.php';
require_once '../model/UsuarioPDO.php';
require_once '../model/DBPDO.php';

header('Content-Type: application/json; charset=utf-8');

$res = ['respuesta' => 'error', 'msj' => 'No se han recibido los parámetros necesarios'];

if (isset($_GET['codUsuario']) && isset($_GET['perfil'])) {
    $codUsuario = $_GET['codUsuario'];
    $nuevoPerfil = $_GET['perfil'];

    // se llama la función
    $exito = UsuarioPDO::modificarPerfilPorCod($codUsuario, $nuevoPerfil);

    if ($exito) {
        $res = [
            'respuesta' => 'ok',
            'msj' => 'Perfil actualizado correctamente'
        ];
    } else {
        $res = [
            'respuesta' => 'error', 
            'msj' => 'No se realizaron cambios (puede que el usuario no exista o ya tuviera ese perfil)'
        ];
    }
}

echo json_encode($res);
exit;