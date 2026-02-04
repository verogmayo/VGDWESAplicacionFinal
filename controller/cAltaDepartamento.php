<?php

/**
 * @author: Véro Grué
 * Creado el 27/01/2026
 */

// Si se hace clic en el botón volver no sigue y redirige a mantenimiento departamentos
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}

// Arrays para errores y respuestas
$aErrores = [
    'codDepartamento' => null,
    'descDepartamento' => null,
    'fechaCreacionDepartamento' => null,
    'volumenDeNegocio' => null
];

$aRespuestas = [
    'codDepartamento' => '',
    'descDepartamento' => '',
    'fechaCreacionDepartamento' => '',
    'volumenDeNegocio' => ''
];

// Variable para controlar si la entrada es correcta
$entradaOK = true;



//  Validación del boton enviar
if (isset($_REQUEST['enviar'])) {

    // Guardar página anterior
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validar los campos del formulario
    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, 1);
    //Si la librería dice que está OK, se nuestra comprobación extra de mayúsculas. Si el usuario desactiva js y escribe en minúsculas sale el mensaje de error.
if ($aErrores['codDepartamento'] == null) {
    if (!preg_match('/^[A-Z]{3}$/', $_REQUEST['codDepartamento'])) {
        $aErrores['codDepartamento'] = "El código debe estar formado por 3 letras MAYÚSCULAS.";
        $entradaOK = false;
    }
}
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloatMonetarioES($_REQUEST['volumenDeNegocio'], PHP_FLOAT_MAX, -PHP_FLOAT_MAX, 1);


    // Guardar las respuestas para rellenar el formulario si hay algun error
    $aRespuestas['codDepartamento'] = $_REQUEST['codDepartamento'];
    $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
    $aRespuestas['fechaCreacionDepartamento'] = $_REQUEST['fechaCreacionDepartamento'];
    //conversion de la coma en punto en el float
    $volumenConPunto = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    // Asignación del valor al array 
    $aRespuestas['volumenDeNegocio'] = $volumenConPunto;

    // Verificar si hay errores de validación
    foreach ($aErrores as $valorCampo => $msjError) {
        if ($msjError != null) {
            $entradaOK = false;
        }
    }

    // Si la validación es correcta, se crea el nuevo departamento
    if ($entradaOK) {
        // Se comprueba si el código de departamento ya existe
        if (DepartamentoPDO::validarCodDepartamentoExiste($_REQUEST['codDepartamento'])) {
            $aErrores['codDepartamento'] = "El código de departamento ya existe.";
            $entradaOK = false;
        } else {
            // Si no existe, se crea el nuevo departamento
            $oDepartamento = DepartamentoPDO::altaDepartamento(
                $_REQUEST['codDepartamento'],
                $_REQUEST['descDepartamento'],
                $volumenConPunto
            );


            if ($oDepartamento === null) {
                $entradaOK = false;
                //Se crea el error en el caso de que no se pueda crear el departamento
                $_SESSION['errorAltaDepartamento'] = "Error al crear el departamento. Por favor, inténtalo de nuevo.";
                //Se redirige al login 
                $_SESSION['paginaEnCurso'] = 'dpto';
                header('Location: index.php');
                exit;
            } else {
                // si se ha creado correctamente, se redirige a mantenimiento departamentos
                $_SESSION['paginaEnCurso'] = 'dpto';
                header('Location: index.php');
                exit;
            }
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}
//Fecha de hoy para ponerla por defecto en el formulario
$fechaCreacionHoy = new DateTime();
$fechaCreacionHoyFormateada = $fechaCreacionHoy->format('Y-m-d');
$aRespuestas['fechaCreacionDepartamento'] = $fechaCreacionHoyFormateada;
// Si la entrada no es correcta, se carga el formulario
$avAltaDepartmento = [
    'codDepartamento' => $aRespuestas['codDepartamento'],
    'descDepartamento' => $aRespuestas['descDepartamento'],
    'fechaCreacionDepartamento' => $aRespuestas['fechaCreacionDepartamento'],
    'volumenDeNegocio' => $aRespuestas['volumenDeNegocio'],
    'aErrores' => $aErrores
];

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
