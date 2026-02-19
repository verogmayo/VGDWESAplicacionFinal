<?php


require_once "../config/confDBPDODes.php";
require_once "../model/DBPDO.php";
require_once "../model/UsuarioPDO.php";
require_once "../core/libreriaValidacion.php";

header('Content-Type: application/json; charset=utf-8');

if (isset($_REQUEST['codUsuario'])) {
    $codUsuario = $_REQUEST['codUsuario'];
    
    if (empty(validacionFormularios::comprobarAlfaNumerico($codUsuario, 255, 0, 0))) {
        
        if (UsuarioPDO::validarCodUsuarioExiste($codUsuario)) {
            if (UsuarioPDO::borrarUsuarioPorCod($codUsuario)) {
                echo json_encode(['estadoRespuestaEliminar' => 'exito', 'msj' => 'Usuario eliminado correctamente']);
                exit; // <-- IMPORTANTE
            } else {
                echo json_encode(['estadoRespuestaEliminar' => 'error', 'msj' => 'No se pudo eliminar el usuario de la DB']);
                exit;
            }
        } else {
            // Si no existe, lo tratamos como éxito para el JS (ya no está)
            echo json_encode(['estadoRespuestaEliminar' => 'exito', 'msj' => 'El usuario no existe']);
            exit;
        }
    } else {
        echo json_encode(['estadoRespuestaEliminar' => 'error', 'msj' => 'Formato del código no válido']);
        exit;
    }
} else {
    echo json_encode(['estadoRespuestaEliminar' => 'error', 'msj' => 'No se ha introducido código de usuario']);
    exit;
}
?>