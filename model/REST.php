<?php
/**
 * Clase para consumir APIs REST externas
 * 
 * Proporciona métodos estáticos para realizar peticiones a diferentes
 * APIs públicas (NASA APOD, Open Library) y devolver objetos PHP
 * estructurados con la información obtenida
 *
 * @author Véro Grué
 * @since 20/01/2026
 * @version 1.0.0
 * @link https://api.nasa.gov/ Documentación API NASA
 * @link https://openlibrary.org/dev/docs/api/search Documentación Open Library
 */
class REST{
     /**
     * Clave de API para acceder al servicio NASA APOD
     * 
     * @var string
     * @link https://api.nasa.gov/ Obtener API Key
     */

    // const API_KEY_NASA = '083Uw36QI57jfPsnN7WLo6modct0fAyaxHzzaBNN';
/**
     * Obtiene la foto astronómica del día de la NASA para una fecha específica
     *
     * Realiza una petición a la API APOD (Astronomy Picture of the Day) de NASA
     * y devuelve un objeto FotoNasa con la información de la imagen
     *
     * @param string $fecha Fecha en formato YYYY-MM-DD
     * @return FotoNasa|null Objeto con los datos de la foto o null si falla
     */
   

    public static function apiNasa($fecha) {
    // URL de la API de NASA con la clave y la fecha
    $url = "https://api.nasa.gov/planetary/apod?api_key=". API_KEY_NASA ."&date=$fecha";
    
    // Inicializar cURL (una librería de PHP para hacer peticiones HTTP más robustas). 
    // https://www.php.net/manual/es/book.curl.php
    $ch = curl_init();
    
    // Configurar las opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $url);                    // URL a la que hacer la petición
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         // Devolver el resultado en lugar de imprimirlo
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);         // Seguir redirecciones si las hay
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);                  // Tiempo máximo de espera total (10 segundos)
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);           // Tiempo máximo para conectar (10 segundos)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);         // Verificar el certificado SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);            // Verificar que el certificado coincide con el host
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PHP-App'); // Identificarse como navegador
    
    // Ejecutar la petición
    $resultado = curl_exec($ch);
    
    // Obtener el código HTTP de respuesta (200 = OK, 404 = No encontrado, etc.)
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Cerrar la conexión cURL
    //curl_close($ch); está deprecated. Ahora ya no se utiliza
    
    // Si la petición falló o el código HTTP no es 200 (OK), retornar null
    if ($resultado === false || $httpCode !== 200) {
        return null;
    }
    
    // Decodificar el JSON recibido y convertirlo en un array de PHP
    $archivoApi = json_decode($resultado, true);
    
    // Si el JSON tiene los datos necesarios, crear el objeto FotoNasa. Si solo se pone if(isset($archivoApi)), devuelve siempre algo aunque no haya datos
    if(isset($archivoApi['title']) && isset($archivoApi['media_type']) && $archivoApi['media_type'] == 'image'){
     //Se descarga la imagen con curl para que funcione en explotación 
        $chImg = curl_init();
        curl_setopt($chImg, CURLOPT_URL, $archivoApi['url']);
        //devuelve el resultado en lugar de imprimirlo
        curl_setopt($chImg, CURLOPT_RETURNTRANSFER, true);
        //verifica el sertificado ssl
        curl_setopt($chImg, CURLOPT_SSL_VERIFYPEER, true);
        $imagenBinaria = curl_exec($chImg);

        // Se serializa: se para a imagenBase64 para guardar la imagen 
        $imagenBase64 = "";
        if ($imagenBinaria) {
            $imagenBase64 = 'data:image/jpeg;base64,' . base64_encode($imagenBinaria);
        }

        $chImgHD = curl_init();
        curl_setopt($chImgHD, CURLOPT_URL, $archivoApi['url']);
        //devuelve el resultado en lugar de imprimirlo
        curl_setopt($chImgHD, CURLOPT_RETURNTRANSFER, true);
        //verifica el sertificado ssl
        curl_setopt($chImgHD, CURLOPT_SSL_VERIFYPEER, true);
        $imagenBinariaHD = curl_exec($chImgHD);

        // Se serializa: se pasa a imagenBase64 para guardar la imagen 
        $imagenBase64HD = "";
        if ($imagenBinariaHD) {
            $imagenBase64HD = 'data:image/jpeg;base64,' . base64_encode($imagenBinariaHD);
        }
        // SE crea el objeto FotoNasa
        $fotoNasa = new FotoNasa(
            $archivoApi['title'],
            $archivoApi['url'], 
            $archivoApi['date'],
            $archivoApi['explanation'],
            $archivoApi['hdurl'] ?? '',
            $imagenBase64,
            $imagenBase64HD

        );
        
        return $fotoNasa;
    }
//Si la cadena no es una imagen retorna el texto NoHayImagen
    return "NoHayImagen"; 
}

/**
     * Busca información de un libro por su título en Open Library
     *
     * Realiza una búsqueda en la API de Open Library y devuelve
     * el primer resultado encontrado como objeto Libro
     *
     * @param string $titulo Título del libro a buscar
     * @return Libro|null Objeto Libro con la información encontrada o null si no hay resultados
     */

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




/**
     * Busca información sobre los usaurios de la Api de Gonzalo
     *
     * Realiza una búsqueda en la API de Gonzalo y devuelve
     * el resultado encontrado correspondiente al codigo de usuario introducido
     *
     * @param string $codUsuario Codigo del usaurio a buscar
     * @return Usuario|null Objeto Usuario con la información encontrada o null si no hay resultados
     */

 public static function apiUsuariosGonzalo($descUsuario) {
    // Se forma la url
    $url = "https://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php?api_key=aaa&descUsuario=" . urlencode($descUsuario);
    
    $resultado = @file_get_contents($url);
    
    if ($resultado) {
        $arrayUsuarios = json_decode($resultado, true);
        
        // Se verifica si el array tiene al menos un usuario
        if (isset($arrayUsuarios[0])) {
            $oUsuario = $arrayUsuarios[0]; // Cogemos el primer resultado

            // Se retorna una 
            return (object) [
                'codUsuario' => $oUsuario['codUsuario'],
                'descUsuario' => $oUsuario['descUsuario'],
                'numAccesos' => $oUsuario['numAccesos'],
                'ultimaConexion' => $oUsuario['fechaHoraUltimaConexion'],
                'perfil' => $oUsuario['perfil']
            ];
            
        }
    }
    return null;
}


public static function apiPropiaVolumenNegocio($codDepartamento) {
    // Se define la url
    $url = "http://192.168.0.22/VGDWESAplicacionFinal/api/wsVerVolNegocioDpto.php?codDepartamento=" . $codDepartamento;
    //$url = "http://veroniquegru.ieslossauces.es/VGDWESAplicacionFinal/api/wsVerVolNegocioDpto.php?codDepartamento=" . $codDepartamento;

    
    $json = @file_get_contents($url);
    
    if ($json !== false) {
        $data = json_decode($json, true);
        
        if (isset($data['respuesta']) && $data['respuesta'] === 'ok') {
            // Si todo va bien, se devuelve el dato
            return [
                'resultado' => $data['volumenDeNegocio'],
                'error' => null
            ];
        } else {
            // Si la API envia un mensaje de error
            return [
                'resultado' => null,
                'error' => $data['msj'] ?? "Error en la respuesta de la API propia"
            ];
        }
    }
    
    // Si no se puede conectar con la url
    return [
        'resultado' => null,
        'error' => "No se pudo conectar con el servicio propio"
    ];
}

}
?>