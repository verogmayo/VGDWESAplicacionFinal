<?php
/**
 * @author: Véro Grué
 * @since: 17/01/2026
 */
//Si no se iniciado session, se redirige a la pagina de inicio publico
if (empty($_SESSION['usuarioVGDAWAppAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
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
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "volver" ha sido pulsado.
if(isset($_REQUEST['volver'])){
     $_SESSION['paginaAnterior'] =$_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// Inicializamos variables de control y errores
$aErrores = [
    'fechaNasa' => null, 
    'tituloLibro' => null];
$oFotoNasa = null;
$oLibro = null; // IMPORTANTE: Inicializar para evitar el error de la línea 91

// Se obtiene la fecha de hoy para valores por defecto
$fechaHoy = new DateTime();
$fechaHoyFormateada = $fechaHoy->format('Y-m-d');
$fechaNasa = $fechaHoyFormateada; // Por defecto hoy

// validación al darle al boton enviar de la NAsa
if (isset($_REQUEST['enviarNasa'])) {
    $entradaOK = true;
    $aErrores['fechaNasa'] = validacionFormularios::validarFecha($_REQUEST['fechaNasa'], $fechaHoyFormateada, '1995-06-16', 1);

    if ($aErrores['fechaNasa'] != null) {
        $entradaOK = false;
    }

    if ($entradaOK) {
        $fechaNasa = $_REQUEST['fechaNasa'];
    }
}
// Llamada a la API de la NASA (con la fecha de hoy o la elegida)
$oFotoNasa = REST::apiNasa($fechaNasa);


// Validación al darle al boton de enviar de OpenLibrary
$aIsbns = [
    '9780141187761', '9780618260300', '9788420659404', '9788408176022',
    '9786073117364', '9788491051657', '9788445076736', '9788491221166',
    '9786073120319', '9789685146098'
];

if (isset($_REQUEST['enviarLibro'])) {
    $entradaOK = true;
    $aErrores['tituloLibro'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['tituloLibro'], 100, 1, 1);

    if ($aErrores['tituloLibro'] != null) {
        $entradaOK = false;
    }

    if ($entradaOK) {
        // Si la validación es correcta, intentamos buscar el libro
        $oLibro = REST::apiLibroPorTitulo($_REQUEST['tituloLibro']);
    }
}

// Si no se busca nada salen un libro por defecto
if (!$oLibro) {
    $indice = (int)$fechaHoy->format('d') % count($aIsbns);
    $isbnHoy = $aIsbns[$indice];
    $oLibro = REST::apiLibros($isbnHoy);
}


// Listado de departamentos
$aDptosWP = REST::apiDptos();


// PREPARACIÓN DEL ARRAY PARA LA VISTA
$avRest = [
    'inicial' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getInicial(),
    'tituloNasa' => ($oFotoNasa) ? $oFotoNasa->getTitulo() : "No hay datos",
    'fotoNasa' => ($oFotoNasa) ? $oFotoNasa->getUrl() : "",
    'fechaNasa' => $fechaNasa,
    'explicacionNasa' => ($oFotoNasa) ? $oFotoNasa->getExplicacion() : "",
    'errorNasa' => $aErrores['fechaNasa'],
    'fechaHoy' => $fechaHoyFormateada,
    'libro' => $oLibro,
    'errorLibro' => $aErrores['tituloLibro'],
    'dptos' => $aDptosWP
];


// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>