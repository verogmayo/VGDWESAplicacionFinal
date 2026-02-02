<?php
/**
 * @author: Véro Grué
 * @since: 28/01/2026
 */


// Se comprueba si el botón "volver" ha sido pulsado.
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}

// Comprobamos si el botón "cerrar" ha sido pulsado, cierra la session.
if (isset($_REQUEST['cerrar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}


// Se comprueba si el botón "borrar" ha sido pulsado.
// if (isset($_REQUEST['borrarDepartamento'])) {
//     $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
//     // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
//     $_SESSION['paginaEnCurso'] = 'borrarDepartamento';
//     header('Location: index.php');
//     exit;
// }

// Se comprueba si el botón "cancelar" ha sido pulsado.
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}



$oDepartamentoEnCurso = $_SESSION['departamentoEnCurso'];
$modo = $_SESSION['modoVista']; // 'consultar' o 'modificar'
// Arrays para la gestión de errores y respuestas
$aErrores = [
    'descDepartamento' => null,
    'volumenDeNegocio' => null
];
$aRespuestas = [
    'descDepartamento' => $oDepartamentoEnCurso->getDescDepartamento(), 'volumenDeNegocio' => $oDepartamentoEnCurso->getVolumenDeNegocio()];
$entradaOK = true;

if (isset($_REQUEST['enviar'])) {
    // Se Valida el campo usando la librería de validación
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloatMonetarioES($_REQUEST['volumenDeNegocio'], PHP_FLOAT_MAX, -PHP_FLOAT_MAX, 1);
    // SE Comprueba si hay errores
    
    if ($aErrores['descDepartamento'] !== null || $aErrores['volumenDeNegocio'] !== null) {
        $entradaOK = false;
    }

    //  Si entradaOK se modifica el nombre del departamento
    if ($entradaOK) {
        $descDepartamentoNueva = $_REQUEST['descDepartamento'];
        //Se convierte la coma en punto para el float
        $volumenDeNegocioNuevo = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
        
        // Llamamos al modelo
        $oDepartamentoNuevo = DepartamentoPDO::modificarDepartamento($oDepartamentoEnCurso, $descDepartamentoNueva, $volumenDeNegocioNuevo);
        if ($oDepartamentoNuevo) {
            // Actualizamos la sesión con el objeto que nos devuelve el modelo
            $_SESSION['departamentoEnCurso'] = $oDepartamentoNuevo;
            
            // Redirigimos a la página de inicio
            $_SESSION['paginaEnCurso'] = 'dpto';
            header('Location: index.php');
            exit;
        } else {
            // Error técnico en la base de datos (opcional)
            $aErrores['descDepartamento'] = "No se pudo actualizar el nombre en la base de datos.";
        }
    }
}

$fechaCreacionDpto = new DateTime($oDepartamentoEnCurso->getFechaCreacionDepartamento());
$fechaBajaFormateada = '';
if (!is_null($oDepartamentoEnCurso->getFechaBajaDepartamento())) {
    $fechaBaja = new DateTime($oDepartamentoEnCurso->getFechaBajaDepartamento());
    $fechaBajaFormateada = $fechaBaja->format('d/m/Y');
}

$avVerModificarDpto = [
    'codDepartamento' => $oDepartamentoEnCurso->getCodDepartamento(),
    'descDepartamento' => $oDepartamentoEnCurso->getDescDepartamento(),
    'fechaCreacionDpto' => $fechaCreacionDpto->format('d/m/Y'),
    'volumenDeNegocio' => $oDepartamentoEnCurso->getVolumenDeNegocio(),
    'fechaBajaDepartamento' => $oDepartamentoEnCurso->getFechaBajaDepartamento() ? $oDepartamentoEnCurso->getFechaBajaDepartamento() : 'Activo',
    'modo' => $modo, 
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial()
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];

?>