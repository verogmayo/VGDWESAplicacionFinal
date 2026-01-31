<?php

/**
 * @author: Véro Grué
 * @since: 28/01/2026
 */


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
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}
// Se obtiene la fecha de hoy
$oFechaHoy = new DateTime();
$fechaHoyFormateada = $oFechaHoy->format('Y-m-d');
// si se pulsa el boton detalles Nasa, redirige a la vista de detalles de la nasa
if (isset($_REQUEST['detallesNasa'])) {
    // se guarda la pagina anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
     // se guarda la fecha para utilizarla en la detalle
    // $_SESSION['fechaDetalleNasa'] = $_REQUEST['fechaNasa'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'detallesNasa';
    header('Location: index.php');
    exit;
}
if(empty($_SESSION['InfoNasa'])){
    // Se obtiene la fecha de hoy para valores.
    $_SESSION['InfoNasa'] = REST::apiNasa($fechaHoyFormateada);
    //SE guarda la fecha en curso
    $_SESSION['fechaEnCurso'] = $fechaHoyFormateada;
}



// Inicializamos variables de control y errores
$aErrores = [
    'fechaNasa' => null,
    'tituloLibro' => null
];

// Se obtiene la fecha de hoy para valores por defecto

// $oFotoNasa = $_SESSION['InfoNasa'] ?? null;
// $fechaNasa = $_SESSION['fechaDetalleNasa'] ?? $fechaHoyFormateada;

// validación al darle al boton enviar de la NAsa
if (isset($_REQUEST['enviarNasa'])) {
    $entradaOK = true;
    $aErrores['fechaNasa'] = validacionFormularios::validarFecha($_REQUEST['fechaNasa'], $fechaHoyFormateada, '1995-06-16', 1);

    if ($aErrores['fechaNasa'] != null) {
        $entradaOK = false;
    }


    if ($entradaOK) {
        $fechaNueva = $_REQUEST['fechaNasa'];
        // Llamada a la API de la NASA (con la fecha de hoy o la elegida)
        if ( $fechaNueva !== $_SESSION['fechaEnCurso']) {

            $oFotoNasa = REST::apiNasa($fechaNueva);
            $_SESSION['InfoNasa'] = $oFotoNasa;
            $_SESSION['fechaEnCurso'] = $fechaNueva;
        }

        //  Usamos los datos ya guardados
        // $fechaNasa = $_SESSION['fechaEnCurso'];
    }
}

// if (isset($_SESSION['InfoNasa'])) {
//     $oFotoNasa = $_SESSION['InfoNasa'];
// } else {
//     //se llama a la api con la fecha formateada
//     $oFotoNasa = REST::apiNasa($fechaHoyFormateada);
//     $_SESSION['InfoNasa']= $oFotoNasa;
// }

//se asgina las variables para la vista
$oFotoNasa = $_SESSION['InfoNasa'];
$fechaNasa = $_SESSION['fechaEnCurso'];



// Validación al darle al boton de enviar de OpenLibrary
$aTitulos = [
    '1984',
    'El Hobbit',
    'El Principito',
    'El codigo Da Vinci',
    'El retrato de Dorian Gray',
    'Las aventuras de Huckleberry Finn',
    'Charlie y la fabrica de chocolate',
    'La ladrona de libros',
    'Romeo y Julieta'
];

$oLibro = null;

// Si el usuario ha buscado un título
if (isset($_REQUEST['enviarLibro'])) {
    $entradaOK = true;
    $aErrores['tituloLibro'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['tituloLibro'], 100, 1, 1);

    if ($aErrores['tituloLibro'] != null) {
        $entradaOK = false;
    }

    if ($entradaOK) {
        $oLibro = REST::apiLibroPorTitulo($_REQUEST['tituloLibro']);
    }
}

// Si no se ha buscado nada o la búsqueda no dio resultados, se pone el un libro del día
if (!$oLibro) {
    $indice = (int)$oFechaHoy->format('d') % count($aTitulos);
    $tituloHoy = $aTitulos[$indice];
    $oLibro = REST::apiLibroPorTitulo($tituloHoy);
}




// Array para la vista
$avRest = [
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'tituloNasa' => ($oFotoNasa) ? $oFotoNasa->getTitulo() : "No hay datos",
    'fotoNasa' => ($oFotoNasa) ? $oFotoNasa->getUrl() : "",
    'fechaNasa' => $fechaNasa,
    'explicacionNasa' => ($oFotoNasa) ? $oFotoNasa->getExplicacion() : "",
    'errorNasa' => $aErrores['fechaNasa'],
    'fechaHoy' => $fechaHoyFormateada,
    'tituloLibro' => $oLibro->getTitulo(),
    'autorLibro' => $oLibro->getAutor(),
    'portadaLibro' => $oLibro->getPortada(),
    'anioPublicacion' => $oLibro->getAnioPublicacion(),
    'errorLibro' => $aErrores['tituloLibro']
];


// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
