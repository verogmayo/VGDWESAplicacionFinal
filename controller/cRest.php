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

//se obtiene la fecha de hoy para la foto del día de la Nasa
$fechaHoy = new DateTime();
$fechaHoyFormateada = $fechaHoy->format('Y-m-d');
//se llama a la api con la fecha formateada
$oFotoNasa = REST::apiNasa($fechaHoyFormateada);
//Listado de isbn para que cambien los libros todos los días.
$aIsbns = [
    '9780141187761', // 1984
    '9780618260300', // El Hobbit
    '9788420659404',  // El Principito
    '9788408176022',  //El codigo Da Vinci
    '9786073117364', //El retrato de Dorian Gray
    '9788491051657', //Las aventuras de Huckelberry Finn
    '9788445076736', //El Hobit
    '9788491221166',  //Charlie y la fabrica de chocolate
    '9786073120319',  //La ladrona de libros
    '9789685146098', //Romero y Julieta
];
//Se va a usar el día de la fecha "elegir"el isbn.
$indice = $fechaHoy->format('d') % count($aIsbns); //el indice será el resto de dividir el numero del día por el numero de isbns de la lista.
$isbnHoy = $aIsbns[$indice];
$oLibro=REST::apiLibros($isbnHoy);

$aDptosWP = REST::apiDptos(); //aqui se retorna un array de objetos dptos

//Se crea un array con los datos del usuario para pasarlos a la vista
$avRest = [
    'inicial' => $_SESSION['usuarioVGDAWAppAplicacionFinal']->getInicial(),
    'fotoNasa'=>$oFotoNasa,
    'libro'=>$oLibro,
    'dptos'=>$aDptosWP
];



// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
?>