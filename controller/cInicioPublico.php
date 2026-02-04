<?php

/**
 * @author: Véro Grué
 * Creado el 14/01/2026
 */

//Si se pulsa el boton de login
if (isset($_REQUEST['login'])) {
  $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
  //La pagina en curso es la pagina de login
  $_SESSION['paginaEnCurso'] = 'login';
  header('Location: index.php');
  exit;
}

if (isset($_REQUEST['idioma'])) {
  setcookie("idioma", $_REQUEST['idioma'], time() + (3600 * 24 * 7)); // caducidad 1 semana
  header('Location: index.php');
  exit;
}
if (!isset($_COOKIE['idioma'])) {
  setcookie("idioma", "es", time() + (3600 * 24 * 7)); // caducidad 1 semana en segundos(1h(3600s)*24h*7dias)
  header('Location: index.php');
  exit;
}



// cargamos el layout principal, y cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];
