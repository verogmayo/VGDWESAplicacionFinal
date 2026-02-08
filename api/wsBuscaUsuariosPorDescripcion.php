<?php


require_once "../config/confDBPDODes.php";
require_once "../model/DBPDO.php";
require_once "../model/UsuarioPDO.php";
require_once "../model/Usuario.php";
require_once "../core/libreriaValidacion.php";

// http://daw204.local.ieslossauces.es/VGDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php?descUsuario=vero


header('Content-Type: application/json; charset=utf-8');
$entradaOk = true;
if (isset($_REQUEST['DescUsuario'])) {
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 0, 0);

    if ($aErrores['descUsuario'] != null) {
        $entradaOK = false;
    }
} else {
    $entradaOK = false;
}



$aObjetosUsuarios = UsuarioPDO::buscarUsuariosPorDesc($_REQUEST['descUsuario'] ?? '');

$aUsuarios = [];

if ($aObjetosUsuarios) {
    foreach ($aObjetosUsuarios as $oUsuario) {
        // Preparamos los datos para el JSON
        $aUsuarios[] = [
            'codUsuario' => $oUsuario->getCodUsuario(),
            'descUsuario' => $oUsuario->getDescUsuario(),
            'numAccesos' => $oUsuario->getNumAccesos(),
            'fechaUltimaConexion' => $oUsuario->getFechaHoraUltimaConexion() ? $oUsuario->getFechaHoraUltimaConexion()->format('d/m/Y H:i:s') : 'Nunca',
            'perfil' => $oUsuario->getPerfil(),
            'imagenUsuario' => $oUsuario->getImagenUsuario()
        ];
    }
}

echo json_encode($aUsuarios, JSON_PRETTY_PRINT);
// }
