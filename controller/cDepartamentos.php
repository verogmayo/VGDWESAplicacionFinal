<?php

/**
 * @author: Véro Grué
 * @since: 23/01/2026
 */
if (empty($_SESSION['usuarioVGDAWAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

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
//si se pulsa el boton del ojo de consultar
if (isset($_REQUEST['consultar'])) {
    $objDpto = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['consultar']);
    if ($objDpto) {
        $_SESSION['departamentoEnCurso'] = $objDpto;
        $_SESSION['modoVista'] = 'consultar'; //se guarda la vista de consultar
        //se redirige a la página de consultar/modificar departamento
        $_SESSION['paginaEnCurso'] = 'modificarDpto'; 
        header('Location: index.php');
        exit;
    }
}

// Si se pulsa el lápiz de modificar
if (isset($_REQUEST['modificar'])) {
    $objDpto = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['modificar']);
    if ($objDpto) {
        $_SESSION['departamentoEnCurso'] = $objDpto;
        $_SESSION['modoVista'] = 'modificar'; // se guarda la vista de modificar
        $_SESSION['paginaEnCurso'] = 'modificarDpto';
        header('Location: index.php');
        exit;
    }
}
// Inicialización de variables 
$descripcionBuscada="";
$aErrores = [
    'descDepartamento' => null
];

$entradaOK = true;

// Si se ha pulsado buscar
if (isset($_REQUEST['buscar'])) {
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 0, 0);

    if ($aErrores['descDepartamento'] != null) {
        $entradaOK = false;
    }
} else {
    $entradaOK = false;
}

// Si la entrada es OK
if ($entradaOK) {
//se recoge la descripción buscada y se guarda en sesión
    $descripcionBuscada = $_REQUEST['descDepartamento'] ?? '';
    $_SESSION['busquedaDptoEnCurso'] = $descripcionBuscada;
}else{
    //si  la entrada no es OK y hay una búsqueda en curso en sesión, se recoge la busqueda de la sesión
    if (isset($_SESSION['busquedaDptoEnCurso'])) {
        $descripcionBuscada = $_SESSION['busquedaDptoEnCurso'];
    }
}






$aListaDepartamentos = [];   
//array de objetos de departamento
$aObjDepartamentos = DepartamentoPDO::buscarDepartamentoPorDesc($descripcionBuscada);


if (!is_null($aObjDepartamentos)) {
    foreach ($aObjDepartamentos as $oDepartamento) {

        $fechaCreacion = new DateTime($oDepartamento->getFechaCreacionDepartamento());

        $fechaBajaFormateada = '';
        if (!is_null($oDepartamento->getFechaBajaDepartamento())) {
            $fechaBaja = new DateTime($oDepartamento->getFechaBajaDepartamento());
            $fechaBajaFormateada = $fechaBaja->format('d/m/Y');
        }

        $aListaDepartamentos[] = [
            'codDepartamento'           => $oDepartamento->getCodDepartamento(),
            'descDepartamento'          => $oDepartamento->getDescDepartamento(),
            'fechaCreacionDepartamento' => $fechaCreacion->format('d/m/Y'),
            'volumenDeNegocio'          => number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '.') . ' €',
            'fechaBajaDepartamento'     => $fechaBajaFormateada
        ];
    }
}


$avDepartamentos = [
    'dptos' => $aListaDepartamentos,
    'errores' => $aErrores,
    'busqueda' => $descripcionBuscada,
    'codUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getCodUsuario(),
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal
require_once $view['layout'];
