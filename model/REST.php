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
                 $fotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date'],$archivoApi['explanation'],$archivoApi['hdurl']);
                 return $fotoNasa;
            }
    }

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

    public static function apiDptos(){
            // Se accede a la api de dptos de wordpress
            $resultado = file_get_contents($url = "https://veroniquegru.ieslossauces.es/VG-api-dept/wp-json/wp/v2/departamento");

            $aDepartamentos=[]; //SE inicializa el array de departamentos
            
            if($resultado){
                $archivoApi=json_decode($resultado,true);

            //si el archivo se a descodificado correctamente, retorna la lista de departamentos
            if(isset($archivoApi)){
                //Como devuelve la lista de departamentos tenemos que hacer un foreach para recorlos
                foreach ($archivoApi as $dpto) {
                   $oDepartamento = new Departamento(
                        $dpto['acf']['t02_coddepartamento'],
                        $dpto['acf']['t02_descdepartamento'], 
                        $dpto['acf']['t02_fechacreaciondepartamento'],
                        $dpto['acf']['t02_volumendenegocio'],
                        $dpto['acf']['t02_fechabajadepartamento'] ?? null);
                   //se añade al array de dptos
                   $aDepartamentos[]=$oDepartamento;
                }
            }
        }
        return $aDepartamentos;
    }
}

?>