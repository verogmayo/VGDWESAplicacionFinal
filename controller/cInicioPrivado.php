<?php

/**
 * @author: Véro Grué
 * @since: 14/01/2026
 */
//Si no se iniciado session, se redirige a la pagina de inicio publico
if (empty($_SESSION['usuarioVGDAWAppAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: indexAplicacionFinal.php');
    exit;
}
// Se comprueba si el botón "detalles" ha sido pulsado.
if (isset($_REQUEST['detalles'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'detalles';
    header('Location: indexAplicacionFinal.php');
    exit;
}

// Se comprueba si el botón "cerrar" ha sido pulsado.
if (isset($_REQUEST['cerrar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: indexAplicacionFinal.php');
    exit;
}

// Se comprueba si el botón "cuenta" ha sido pulsado.
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: indexAplicacionFinal.php');
    exit;
}

// Se comprueba si el botón "error" ha sido pulsado.
if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: indexAplicacionFinal.php');
    exit;
}
// Se comprueba si el botón "dpto" ha sido pulsado.
if (isset($_REQUEST['dpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'wip';
    header('Location: indexAplicacionFinal.php');
    exit;
}

// Determinar el idioma (si no hubiera cookie, que sea 'es')
$idioma = $_COOKIE['idioma'] ?? 'es';

// Array de textos segun el idioma
$aTextos = [
    'es' => [
        'bienvenida' => "BIENVENIDO/A ",
        'primeraConexion' => "¡Esta es tu primera conexión!",
        'numConexiones' => "Esta es la vez número %d que se conecta.",
        'ultimaConexion' => "Usted se conectó por última vez el %s a las %s",
        'locale' => 'es_ES'
    ],
    'en' => [
        'bienvenida' => "WELCOME ",
        'primeraConexion' => "This is your first connection!",
        'numConexiones' => "This is the %d time you have connected.",
        'ultimaConexion' => "You last connected on %s at %s",
        'locale' => 'en_GB'
    ],
    'fr' => [
        'bienvenida' => "BIENVENUE ",
        'primeraConexion' => "C'est votre première connexion !",
        'numConexiones' => "C'est la %de fois que vous vous connectez.",
        'ultimaConexion' => "Votre dernière connexion remonte au %s à %s",
        'locale' => 'fr_FR'
    ]
];

//Se crea un array con los datos del usuario para pasarlos a la vista
$avInicioPrivado = [
    'descUsuario' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getDescUsuario(),
    'numAccesos' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getNumAccesos(),
    'fechaHoraUltimaConexionAnterior' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getFechaHoraUltimaConexionAnterior(),
    'inicial' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getInicial()
];


// Se Construye los mensajes
$avMensajeBienvenida = ['bienvenida' => $aTextos[$idioma]['bienvenida'] . $avInicioPrivado['descUsuario']];

if ($avInicioPrivado['numAccesos'] <= 1) {
    $avMensajeBienvenida['detalle'] = $aTextos[$idioma]['primeraConexion'];
} else {
    // SE Formatea el mensaje de número de conexiones
    //https://www.php.net/manual/es/function.sprintf.php
    $avMensajeBienvenida['detalle'] = sprintf($aTextos[$idioma]['numConexiones'], $avInicioPrivado['numAccesos']);

    // Se Formatea la fecha y hora si no es la primera conexion
    if ($avInicioPrivado['fechaHoraUltimaConexionAnterior'] instanceof DateTime) {
        $fechaformateada = new IntlDateFormatter($aTextos[$idioma]['locale'], IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        // Formatear la fecha y hora según la configuración regional española
        //IntlDateFormatter::FULL - muestra la fecha completa (día de la semana, día, mes y año)
        //IntlDateFormatter::LONG - mostraría la fecha (día, mes y año)
        //IntlDateFormatter::MEDIUM - mostraría la fecha abreviada (ejemplo:12 ene 2025)
        //IntlDateFormatter::NONE - no muestra la hora
        $avMensajeBienvenida['ultimaC'] = sprintf(
            $aTextos[$idioma]['ultimaConexion'],
            $fechaformateada->format($avInicioPrivado['fechaHoraUltimaConexionAnterior']),
            $avInicioPrivado['fechaHoraUltimaConexionAnterior']->format('H:i')
        );
        
    }
}

// Para las banderas de la vista (pasar cuál está seleccionada)
$idiomaActivo = $idioma;
$aConfigBandera = [
    'es' => ['img' => 'webroot/images/banderaEs.png'],
    'en' => ['img' => 'webroot/images/banderaGb.png'],
    'fr' => ['img' => 'webroot/images/banderaFr.png']
];
$banderaActual = $aConfigBandera[$idiomaActivo];

//Se cargará la vista y está dispondrá de los datos del usuario en el array $avInicioPrivado

// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
