<?php

/**
 * @author: Véro Grué
 * Creado el 28/01/2026
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
if (empty($_SESSION['InfoNasa'])) {
    // Se obtiene la fecha de hoy para valores.
    $oFotoNasa = REST::apiNasa($fechaHoyFormateada);
    $_SESSION['InfoNasa'] = $oFotoNasa;
    //SE guarda la fecha en curso
    $_SESSION['fechaEnCurso'] = $fechaHoyFormateada;
    if ($oFotoNasa !== "NoHayImagen" && $oFotoNasa !== null) {
        $_SESSION['fotosSerializadasNasa'][$fechaHoyFormateada] = $oFotoNasa;
    }
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

        // Se comprueba si tenemos las fotos en la session
        if (isset($_SESSION['fotosSerializadasNasa'][$fechaNueva])) {
            $_SESSION['InfoNasa'] = $_SESSION['fotosSerializadasNasa'][$fechaNueva];
        } else {
            // Si no está, llamamos a la API
            $oFotoNasa = REST::apiNasa($fechaNueva);
            $_SESSION['InfoNasa'] = $oFotoNasa;
            //Solo se guradan las fotos en el album de fotosSerializadas si el objeto es valido.
            //Si no lo fuera daría error
            if ($oFotoNasa instanceof FotoNasa) {
                $_SESSION['fotosSerializadasNasa'][$fechaNueva] = $oFotoNasa;
            }
        }
        $_SESSION['fechaEnCurso'] = $fechaNueva;
    }



    // if ($entradaOK) {
    //     $fechaNueva = $_REQUEST['fechaNasa'];
    //     // Llamada a la API de la NASA (con la fecha de hoy o la elegida)
    //     if ( $fechaNueva !== $_SESSION['fechaEnCurso']) {

    //         $oFotoNasa = REST::apiNasa($fechaNueva);
    //         $_SESSION['InfoNasa'] = $oFotoNasa;
    //         $_SESSION['fechaEnCurso'] = $fechaNueva;
    //     }

    //     //  Usamos los datos ya guardados
    //     // $fechaNasa = $_SESSION['fechaEnCurso'];
    // }
}



//se asgina las variables para la vista
$oFotoNasa = $_SESSION['InfoNasa'];
// $fechaNasa = $_SESSION['fechaEnCurso'];

//PAra que sea seguro se comprueba que oFotoNasa es un objeto.
//Se crea un booleano por seguridad.
$esObjetoNasa=($oFotoNasa instanceof FotoNasa);


// Habrá un mensaje de error si no hay imagen
$errorAPI = null;
if ($oFotoNasa === "NoImagen") {
    $errorAPI = "Hoy no hay foto. Puedes probar con otra fecha!";
}

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


if ($oFotoNasa === "NoImagen") {
    $avRest['errorNasa'] = "Hoy la NASA ha publicado un vídeo o contenido no visual. ¡Prueba con otra fecha!";
    $avRest['fotoNasa'] = "path/to/tu/imagen/por/defecto.png"; // O dejarlo vacío
}


// Array para la vista
$avRest = [
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'tituloNasa' => $esObjetoNasa ? $oFotoNasa->getTitulo() : "No hay datos",
    'fotoNasa' => $esObjetoNasa ? $oFotoNasa->getUrl() : "",
    'fechaNasa' => $_SESSION['fechaEnCurso'],
    'explicacionNasa' => $esObjetoNasa ? $oFotoNasa->getExplicacion() : "",
    'errorNasa' => $aErrores['fechaNasa'] ?? $errorAPI, // Muestra error de fecha o de API
    'fechaHoy' => $fechaHoyFormateada,
    'tituloLibro' => $oLibro->getTitulo(),
    'autorLibro' => $oLibro->getAutor(),
    'portadaLibro' => $oLibro->getPortada(),
    'anioPublicacion' => $oLibro->getAnioPublicacion(),
    'errorLibro' => $aErrores['tituloLibro'],
    //si oFotoNasa es un objeto se obtiene la imagen.
    'fotoSerializada' => $esObjetoNasa ? $oFotoNasa->getImagenBase64(): ""
];


// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
