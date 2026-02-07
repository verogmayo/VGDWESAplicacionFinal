<?php

/**
 * @author: Véro Grué
 * Creado el 28/01/2026
 */


if (isset($_REQUEST['volver'])) {
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "cerrar" ha sido pulsado.
if (isset($_REQUEST['cerrar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "cuenta" ha sido pulsado.
if(isset($_REQUEST['cuenta'])){
    $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}
//si hay un usuarioen curso en la sesión se borra
if (isset($_SESSION['usuarioEnCurso'])) {
    unset($_SESSION['usuarioEnCurso']);
}
// Se comprueba si el botón "altaUsuario" ha sido pulsado.
if(isset($_REQUEST['altaUsuario'])){
    $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'altaUsuario';
    header('Location: index.php');
    exit;
}
//si se pulsa el boton del ojo de consultar
if (isset($_REQUEST['consultar'])) {
    //se busca el departamento por el codigo que se ha recogido en el value del botón de consultar
    $oUsuario = UsuarioPDO::buscarUsuarioPorCod($_REQUEST['consultar']);
    if ($oUsuario) {
        $_SESSION['usuarioEnCurso'] = $oUsuario;
        $_SESSION['modoVista'] = 'consultar'; //se guarda la vista de consultar
        //se redirige a la página de consultar/modificar departamento
        $_SESSION['paginaEnCurso'] = 'modificarUsuario'; 
        header('Location: index.php');
        exit;
    }
}

// Si se pulsa el lápiz de modificar
if (isset($_REQUEST['modificar'])) {
     //se busca el departamento por el codigo que se ha recogido en el value del botón de modificar
    $oUsuario = UsuarioPDO::buscarUsuarioPorCod($_REQUEST['modificar']);
    if ($oUsuario) {
        $_SESSION['usuarioEnCurso'] = $oUsuario;
        $_SESSION['modoVista'] = 'modificar'; // se guarda la vista de modificar
        $_SESSION['paginaEnCurso'] = 'modificarUsuario';
        header('Location: index.php');
        exit;
    }
}

// Si se pulsa a la papelera de borrar
if (isset($_REQUEST['eliminar'])) {
     //se busca el departamento por el codigo que se ha recogido en el value del botón de eliminar
    $oUsuario = UsuarioPDO::buscarUsuarioPorCod($_REQUEST['eliminar']);
    if ($oUsuario) {
        $_SESSION['usuarioAEliminar'] = $oUsuario;
        $_SESSION['paginaEnCurso'] = 'borrarUsuario';
        header('Location: index.php');
        exit;
    }
}




// Inicialización de variables 
$descripcionBuscada="";
$aErrores = [
    'descUsuario' => null
];

$entradaOK = true;

// Si se ha pulsado buscar
if (isset($_REQUEST['buscar'])) {
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 0, 0);

    if ($aErrores['descUsuario'] != null) {
        $entradaOK = false;
    }
} else {
    $entradaOK = false;
}

// Si la entrada es OK
if ($entradaOK) {
//se recoge la descripción buscada y se guarda en sesión
    $descripcionBuscada = $_REQUEST['descUsuario'] ?? '';
    $_SESSION['busquedaUsuarioEnCurso'] = $descripcionBuscada;
}else{
    //si  la entrada no es OK y hay una búsqueda en curso en sesión, se recoge la busqueda de la sesión
    if (isset($_SESSION['busquedaUsuarioEnCurso'])) {
        $descripcionBuscada = $_SESSION['busquedaUsuarioEnCurso'];
    }
}


$aListaUsuarios = [];   
//array de objetos de usuario
$aObjetoUsuarios = UsuarioPDO::buscarUsuariosPorDesc($descripcionBuscada);


if (!is_null($aObjetoUsuarios)) {
    foreach ($aObjetoUsuarios as $oUsuario) {
        $fechaUltimaConexion = $oUsuario->getFechaHoraUltimaConexion();     
        
        if ($fechaUltimaConexion != null) {
    $fechaFormateada = $fechaUltimaConexion->format('d/m/Y H:i:s');
} else {
    $fechaFormateada = "Nunca";
}
        $aListaUsuarios[] = [
            'codUsuario'           => $oUsuario->getCodUsuario(),
            'password'              =>$oUsuario->getPassword(),
            'descUsuario'          => $oUsuario->getDescUsuario(),
            'numAccesos'            =>$oUsuario->getNumAccesos(),
            'fechaUltimaConexion' => $fechaFormateada,
            'perfil'               => $oUsuario->getPerfil(),
            'inicial'               => $oUsuario->getInicial(),
            'imagenUsuario'        => $oUsuario->getImagenUsuario()
  
        ];
    }
}
//Para la api
// $urlAPI = "http://localhost/VGDWESAplicacionFinal/api/buscarUsuarios.php?descUsuario=" . urlencode($descripcionBuscada);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $urlAPI);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $resultadoJSON = curl_exec($ch);
// curl_close($ch);

// $datosRespuesta = json_decode($resultadoJSON, true);

// $aListaUsuarios = [];

// if ($datosRespuesta && $datosRespuesta['status'] === 'success') {
//     // Los datos ya vienen formateados de la API (incluida la fecha)
//     $aListaUsuarios = $datosRespuesta['data'];
// }
// // En confDBPDO.php
// define('URL_API', 'http://'.$_SERVER['HTTP_HOST'].'/VGDWESAplicacionFinal/api/');

// // En el controlador
// $urlAPI = URL_API . "buscarUsuarios.php?descUsuario=" . urlencode($descripcionBuscada);

$avMtoUsuarios = [
    'usuarios' => $aListaUsuarios,
    'errores' => $aErrores,
    'busqueda' => $descripcionBuscada,
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal
require_once $view['layout'];
