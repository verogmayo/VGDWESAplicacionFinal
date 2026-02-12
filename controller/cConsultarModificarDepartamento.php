<?php
/**
 * @author: Véro Grué
 * Creado el 28/01/2026
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



// Se comprueba si el botón "cancelar" ha sido pulsado.
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}

//se busca el dpto en curso gracias al codigo en curso
$oDepartamentoEnCurso = DepartamentoPDO::buscarDepartamentoPorCod($_SESSION['codDepartamentoEnCurso']);
// SE recoge el modo de la sesion
$modo = $_SESSION['modoVista']; // 'consultar' o 'modificar'

//Si el usuario ha puslado modificar pero el dpto está de baja logica, se fuerza la vista consultar y se pone un mensaje
if ($modo === 'modificar' && !is_null($oDepartamentoEnCurso->getFechaBajaDepartamento())) {
    $modo = 'consultar';
    $mensajeErrorBaja = "No se puede modificar un departamento que no está en alta física.";
}

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
    //se sutituye el pnto cpor la 
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
    'volumenDeNegocio' => number_format($oDepartamentoEnCurso->getVolumenDeNegocio(), 2, ',', ''),
    'fechaBajaDepartamento' => $oDepartamentoEnCurso->getFechaBajaDepartamento() ? $fechaBajaFormateada : 'Activo',
    'modo' => $modo, 
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    //mensaje de error del dpto en baja fisica
    'mensajeErrorBaja' => $mensajeErrorBaja ?? null
];
// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];



?>