<?php
/**
* @author: Véro Grué
* @since: 17/01/2026
*/
// enlace para obtener la apikey de la nasa : https://api.nasa.gov/


class REST{
    const API_KEY_NASA = '083Uw36QI57jfPsnN7WLo6modct0fAyaxHzzaBNN';

    public static function apiNasa($fecha){
            // se accede a la url de la nasa
            $resultado = file_get_contents($url = "https://api.nasa.gov/planetary/apod?api_key=" . self::API_KEY_NASA);
            $archivoApi=json_decode($resultado,true);
            //si el archivo se a descodificado correctamente, rotorna la foto
            if(isset($archivoApi)){
                 $fotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date']);
                 return $fotoNasa;
            }
    }
}

?>