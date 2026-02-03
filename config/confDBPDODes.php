<?php
//    define('DNS', 'mysql:host=' . $_SERVER['SERVER_ADDR'] . ';dbname=DBVGDWESAplicacionFinalTema5');
// configuración para plesk
    define('DSN', 'mysql:host=localhost;dbname=DBVGDWESAplicacionFinal;charset=utf8');
    define('USUARIODB', 'userVGDWESAplicacionFinal');
    define('PSWD', 'paso');

    //Definicion del archivo de log 
    ini_set('log_errors', 'On');
    ini_set('error_log', '/var/www/html/VGDWESAplicacionFinal/tmp/php-error.log');
?>

