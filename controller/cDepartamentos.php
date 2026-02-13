<?php

/**
 * @author: Véro Grué
 * Creado el 28/01/2026
 */


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
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'cuenta';
    header('Location: index.php');
    exit;
}
// Se comprueba si el botón "altaDpto" ha sido pulsado.
if (isset($_REQUEST['altaDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // Si se pulsa le damos el valor de la página solicitada a la variable $_SESSION.
    $_SESSION['paginaEnCurso'] = 'altaDpto';
    header('Location: index.php');
    exit;
}
//si se pulsa el boton del ojo de consultar
if (isset($_REQUEST['consultar'])) {
    //se busca el departamento por el codigo que se ha recogido en el value del botón de consultar
    // $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['consultar']);

    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['consultar'];
    $_SESSION['modoVista'] = 'consultar'; //se guarda la vista de consultar
    //se redirige a la página de consultar/modificar departamento
    $_SESSION['paginaEnCurso'] = 'modificarDpto';
    header('Location: index.php');
    exit;
}

// Si se pulsa el lápiz de modificar
if (isset($_REQUEST['modificar'])) {
    //se busca el departamento por el codigo que se ha recogido en el value del botón de modificar
    // $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod();

    // $_SESSION['departamentoEnCurso'] = $oDepartamento;
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['modificar'];
    $_SESSION['modoVista'] = 'modificar'; // se guarda la vista de modificar
    $_SESSION['paginaEnCurso'] = 'modificarDpto';
    header('Location: index.php');
    exit;
}

// Si se pulsa el lápiz de modificar
if (isset($_REQUEST['eliminar'])) {
    //se busca el departamento por el codigo que se ha recogido en el value del botón de eliminar
    $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['eliminar']);
    if ($oDepartamento) {
        $_SESSION['departamentoAEliminar'] = $oDepartamento;
        $_SESSION['paginaEnCurso'] = 'eliminarDpto';
        header('Location: index.php');
        exit;
    }
}

// baja logica
if (isset($_REQUEST['bajaLogica'])) {
    $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['bajaLogica']);
    // Creamos una fecha para la baja (hoy)
    // $oFecha = new DateTime();
    // $fechaBaja = $oFecha->format('d-m-Y');

    // Llamamos a una función del modelo que actualice solo la fecha
    if (DepartamentoPDO::bajaLogicaDepartamento($oDepartamento)) {
        $_SESSION['paginaEnCurso'] = 'dpto';
        header('Location: index.php'); // Refrescamos para ver los cambios
        exit;
    }
}

// alta logica
if (isset($_REQUEST['rehabilitar'])) {
    $oDepartamento = DepartamentoPDO::buscarDepartamentoPorCod($_REQUEST['rehabilitar']);

    // Rehabilitar es poner la fecha a NULL
    if (DepartamentoPDO::rehabilitarDepartamento($oDepartamento)) {
        $_SESSION['paginaEnCurso'] = 'dpto';
        header('Location: index.php');
        exit;
    }
}

// Inicialización de variables 
$descripcionBuscada = "";
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
    //Se recoge el estado
    $estado = $_REQUEST['rbDpto'] ?? 'alta';
    //Se guarda el estado en la session
    $_SESSION['estadoDptoEnCurso'] = $estado;
} else {
    //si  la entrada no es OK y hay una búsqueda en curso en sesión, se recoge la busqueda de la sesión
    if (isset($_SESSION['busquedaDptoEnCurso'])) {
        $descripcionBuscada = $_SESSION['busquedaDptoEnCurso'];
    }

    $estado = $_SESSION['estadoDptoEnCurso'] ?? 'alta';
}


$aListaDepartamentos = [];
//array de objetos de departamento
// $aObjetoDepartamentos = DepartamentoPDO::buscarDepartamentoPorDesc($descripcionBuscada);
$aObjetoDepartamentos = DepartamentoPDO::buscarDepartamentoPorDescYEstado($descripcionBuscada, $estado);

if (!is_null($aObjetoDepartamentos)) {
    foreach ($aObjetoDepartamentos as $oDepartamento) {
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
            //se formatea el volumen de negocio a 2 decimales con coma para los decimales y punto para los miles
            'volumenDeNegocio'          => number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '.') . ' €',
            'fechaBajaDepartamento'     => $fechaBajaFormateada
        ];
    }
}
//Si se pulsa el boton exportar
if (isset($_REQUEST['exportar'])) {
    $aoDepartamentosAExportar = DepartamentoPDO::buscarDepartamentoPorDesc($_SESSION['busquedaDptoEnCurso'] ?? '');
    //Array  a exportar en json
    $aAExportar = [];
    if (!is_null($aoDepartamentosAExportar) && is_array($aoDepartamentosAExportar)) {
        foreach ($aoDepartamentosAExportar as $oDepartamentoAExportar) {

            $aAExportar[] = [
                'codDepartamento'           => $oDepartamentoAExportar->getCodDepartamento(),
                'descDepartamento'          => $oDepartamentoAExportar->getDescDepartamento(),
                'fechaCreacionDepartamento' => $oDepartamentoAExportar->getFechaCreacionDepartamento(),
                'volumenDeNegocio'          => $oDepartamentoAExportar->getVolumenDeNegocio(),
                'fechaBajaDepartamento'     => $oDepartamentoAExportar->getFechaBajaDepartamento()
            ];
        }
    }

    //Se convierte a Json con el formato mas legible
    $jsonDptos = json_encode($aAExportar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    //tipo de contenido correcto para json: https://www.freecodecamp.org/espanol/news/cual-es-el-content-type-correcto-para-json-explicacion-del-mime-type-del-encabezado-de-la-solicitud/
    header('Content-Type: application/json');
    //El fichero será descargado y se llamará listaDpto.json https://developer.mozilla.org/es/docs/Web/HTTP/Reference/Headers/Content-Disposition
    header('Content-Disposition: attachment; filename="listaDptos.json"');
    //Se envía el contenido del json
    echo $jsonDptos;
    //y se sale pra que no pinte el resto de la pagina en el json
    exit;
}
//Si se pulsa el boton de importar
if (isset($_REQUEST['importar'])) {
    $archivoOK = true;

    if ($_FILES['listaDptos']['error'] !== UPLOAD_ERR_OK) {
        $aErrores['listaDptos'] = "Error al subir el archivo.";
        $archivoOK = false;
    } else {
        $jsonRaw = file_get_contents($_FILES['listaDptos']['tmp_name']);
        $aDatos = json_decode($jsonRaw, true);

        // Si el JSON es una lista directa entoces $aDatos  el array de dptos
        if (!$aDatos || !is_array($aDatos)) {
            $aErrores['listaDptos'] = "Formato JSON inválido.";
            $archivoOK = false;
        } else {
            // Campos del json
            $campos = ['codDepartamento', 'descDepartamento', 'fechaCreacionDepartamento', 'volumenDeNegocio'];

            foreach ($aDatos as $indice => $dpto) {
                foreach ($campos as $campo) {
                    if (!array_key_exists($campo, $dpto)) {
                        $archivoOK = false;
                        $aErrores['listaDptos'] = "Error en registro $indice: Falta '$campo'.";
                        break 2; //Cierra los 2 foreach
                    }
                }
            }
        }
    }

    if ($archivoOK) {
        // Pasamos $aDatos directamente a la funcion importar PAlabras
        if (DepartamentoPDO::importarDepartamentos($aDatos)) {
            $_SESSION['msgOK'] = "Importación realizada con éxito.";
            header('Location: index.php');
            exit;
        } else {
            $aErrores['listaDptos'] = "Error en la base de datos (posibles duplicados).";
        }
    }
}



$avDepartamentos = [
    'dptos' => $aListaDepartamentos,
    'errores' => $aErrores,
    'busqueda' => $descripcionBuscada,
    'codUsuario' => $_SESSION['usuarioVGDAWAplicacionFinal']->getCodUsuario(),
    'inicial' => $_SESSION['usuarioVGDAWAplicacionFinal']->getInicial(),
    'estado' => $estado
];
// cargamos el layout principal
require_once $view['layout'];
