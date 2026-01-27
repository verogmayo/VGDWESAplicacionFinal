<?php
/**
* @author: Véro Grué
* @since: 20/01/2026
*/
// enlace para obtener la apikey de la nasa : https://api.nasa.gov/


class REST{

    const API_KEY_NASA = '083Uw36QI57jfPsnN7WLo6modct0fAyaxHzzaBNN';

     public static function apiNasa($fecha){
            // se accede a la url de la nasa
            $resultado = file_get_contents($url = "https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . self::API_KEY_NASA);
            $archivoApi=json_decode($resultado,true);
            //si el archivo se a descodificado correctamente, rotorna la foto
            if(isset($archivoApi)){
                 $oFotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date'],$archivoApi['explanation'],$archivoApi['hdurl']);
                 return $oFotoNasa;
            }
    }

//     public static function apiNasa($fecha) {
//     // URL de la API de NASA con la clave y la fecha
//     $url = "https://api.nasa.gov/planetary/apod?api_key=". self::API_KEY_NASA ."&date=$fecha";
    
//     // Inicializar cURL (una librería de PHP para hacer peticiones HTTP más robustas). 
//     // https://www.php.net/manual/es/book.curl.php
//     $ch = curl_init();
    
//     // Configurar las opciones de cURL
//     curl_setopt($ch, CURLOPT_URL, $url);                    // URL a la que hacer la petición
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // Devolver el resultado en lugar de imprimirlo
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);         // Seguir redirecciones si las hay
//     curl_setopt($ch, CURLOPT_TIMEOUT, 10);                  // Tiempo máximo de espera total (10 segundos)
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);           // Tiempo máximo para conectar (10 segundos)
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);         // Verificar el certificado SSL
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);            // Verificar que el certificado coincide con el host
//     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PHP-App'); // Identificarse como navegador
    
//     // Ejecutar la petición
//     $resultado = curl_exec($ch);
    
//     // Obtener el código HTTP de respuesta (200 = OK, 404 = No encontrado, etc.)
//     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
//     // Cerrar la conexión cURL
//     //curl_close($ch); está deprecated. Ahora ya no se utiliza
    
//     // Si la petición falló o el código HTTP no es 200 (OK), retornar null
//     if ($resultado === false || $httpCode !== 200) {
//         return null;
//     }
    
//     // Decodificar el JSON recibido y convertirlo en un array de PHP
//     $archivoApi = json_decode($resultado, true);
    
//     // Si el JSON tiene los datos necesarios, crear el objeto FotoNasa. Si solo se pone if(isset($archivoApi)), devuelve siempre algo aunque no haya datos
//     if(isset($archivoApi['title'])){
//         $fotoNasa = new FotoNasa(
//             $archivoApi['title'],
//             $archivoApi['url'], 
//             $archivoApi['date'],
//             $archivoApi['explanation'],
//             $archivoApi['hdurl'] ?? ''  
//         );
//         return $fotoNasa;
//     }
    
//     // Si no se pudo obtener la foto, retornar null
//     return null;
// }


    public static function apiLibroPorTitulo($titulo) {
    $tituloUrl = urlencode($titulo);
    // Buscamos en la API de búsqueda por titulo (se limita a 1)
    //https://openlibrary.org/dev/docs/api/search : urls según lo que se busques
    // el @ es para que no salga error si no devuelve nada la api.
    $resultado = @file_get_contents("https://openlibrary.org/search.json?title=$tituloUrl&limit=1");
    
    if ($resultado) {
        $archivoApi = json_decode($resultado, true);
        
        // Verificamos si hay resultados en 'docs'. (Array de resultados de la api) 
        if (isset($archivoApi['docs'][0])) {
            $libroJson = $archivoApi['docs'][0];

            //Título y Autor
            $tituloLibro = $libroJson['title'];
            $autorLibro = $libroJson['author_name'][0] ?? 'Autor desconocido';

            // Portada (Se usa el ID de la portada 'cover_i' si existe)
            $coverId = $libroJson['cover_i'] ?? null;
            $portadaLibro = $coverId 
                ? "https://covers.openlibrary.org/b/id/$coverId-L.jpg" 
                : "webroot/images/default.png"; // Imagen por defecto

            // Año de publicación
            $anioPublicacion = $libroJson['first_publish_year'] ?? 'n/a';

            // Retornamos el objeto Libro directamente
            return new Libro($tituloLibro, $autorLibro, $portadaLibro, $anioPublicacion);
        }
    }
    return null;
}

}

?>