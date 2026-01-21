<?php

/**
 * @author: Véro Grué
 * @since: 20/01/2026
 */

require_once 'core/libreriaValidacion.php';
require_once 'core/miLibreriaStatic.php';
//Cargamos la definición de la clase
require_once 'model/Usuario.php'; 
require_once 'model/UsuarioPDO.php';
require_once 'model/AppError.php';
require_once 'model/REST.php';
require_once 'model/FotoNasa.php';
require_once 'model/Libro.php';
require_once 'model/Departamento.php';

$controller = [
  'inicioPublico' => 'controller/cInicioPublico.php',
  'login' => 'controller/cLogin.php',
  'inicioPrivado' => 'controller/cInicioPrivado.php',
  'detalles' => 'controller/cDetalles.php',
  'registro' => 'controller/cRegistro.php',
  'cuenta' => 'controller/cCuenta.php',
  'cambiarPassword' => 'controller/cCambiarPassword.php',
  'borrarCuenta' => 'controller/cBorrarCuenta.php',
  'error' => 'controller/cError.php',
  'wip' => 'controller/cWIP.php',
  'rest' => 'controller/cRest.php',
  'detallesNasa' => 'controller/cDetallesNasa.php'
];

$view = [
  'inicioPublico' => 'view/vInicioPublico.php',
  'layout' => 'view/layout.php',
  'login' => 'view/vLogin.php',
  'inicioPrivado' => 'view/vInicioPrivado.php',
  'detalles' => 'view/vDetalles.php',
  'registro' => 'view/vRegistro.php',
  'cuenta' => 'view/vCuenta.php',
  'cambiarPassword' => 'view/vCambiarPassword.php',
  'borrarCuenta' => 'view/vBorrarCuenta.php',
  'error' => 'view/vError.php',
  'wip' => 'view/vWIP.php',
  'rest' => 'view/vRest.php',
  'detallesNasa' => 'view/vDetallesNasa.php'
];  
?>