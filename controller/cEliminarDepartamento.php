<?php

/**
 * @author: Véro Grué
 * Creado el 30/01/2026
 */


// Si se hace clic en el botón volver no sigue y redirige a la página mantenimiento de departamentos
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'dpto';
    header('Location: index.php');
    exit;
}


//  Validación 
if (isset($_REQUEST['eliminar'])) {


    $errorBorrar = "";
    //Si el departamento se borra correctamente, se vuelve a mantenimineto de dpto y sino se muestra un mensaje de error
    if (DepartamentoPDO::borrarDepartamento($_SESSION['departamentoAEliminar'])) {
        //Si se ha borra correctamente el dpto, se limpia la variable de sesión
        unset($_SESSION['departamentoAEliminar']);
        //Se redirige a la página de mantenimiento de 
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = 'dpto';
        header('Location: index.php');
        exit;
    } else {
        //Sino se ha podido borrar, sale el mensaje
        $errorBorrar = "El departamento no se ha podido borrar. Por favor, intentalo más tarde";
    };
}
$avEliminarDepartamento = [
    'dptoAEliminar'=>$_SESSION['departamentoAEliminar']->getDescDepartamento()
];

// Si hay errores o no se ha enviado, cargar el layout 
require_once $view['layout'];
