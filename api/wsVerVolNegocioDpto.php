<?php
require_once '../config/confDBPDODes.php';
require_once '../model/DepartamentoPDO.php';
require_once '../model/Departamento.php';
require_once '../model/DBPDO.php';
require_once '../core/libreriaValidacion.php';

header('Content-Type: application/json; charset=utf-8');

$resultado = [];

if (isset($_REQUEST['codDepartamento'])) {
    $codDepartamento = $_REQUEST['codDepartamento'];
    
    // Validación del codigo de departamtento
    if (empty(validacionFormularios::comprobarAlfabetico($codDepartamento, 3, 3, 1))) {
        $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod($codDepartamento);
        
        if ($oDepartamento) {
            $resultado = [
                'respuesta' => 'ok',
                'volumenDeNegocio' => $oDepartamento->getVolumenDeNegocio()
            ];
        } else {
            $resultado = [
                'respuesta' => 'error', 
                'msj' => 'Departamento no encontrado.'];
        }
    } else {
        $resultado = [
            'respuesta' => 'error', 
            'msj' => 'Código de departamento no válido (deben ser 3 letras).'];
    }
} else {
    $resultado = [
        'respuesta' => 'error', 
        'msj' => 'No se ha proporcionado el código.'];
}

echo json_encode($resultado, JSON_PRETTY_PRINT);
exit;