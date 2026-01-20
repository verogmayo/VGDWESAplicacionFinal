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
            $resultado = file_get_contents($url = "https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . self::API_KEY_NASA);
            $archivoApi=json_decode($resultado,true);
            //si el archivo se a descodificado correctamente, rotorna la foto
            if(isset($archivoApi)){
                 $fotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date'],$archivoApi['explanation'],$archivoApi['hdurl']);
                 return $fotoNasa;
            }
    }

    public static function apiLibros($isbn){
            // se accede a la url de la Opent Library
            // https://openlibrary.org/developers/api
            $resultado = file_get_contents($url = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data");
            
            if($resultado){
                $archivoApi=json_decode($resultado,true);
                $claveIsbn="ISBN:$isbn";

            //si el archivo se a descodificado correctamente, retorna los datos del libro
            //Aqui se pueden ver un json para sacar la infomración:https://openlibrary.org/api/books?bibkeys=ISBN:9788491051657&format=json&jscmd=data
            if(isset($archivoApi[$claveIsbn])){
                //Se forma el archivo completo, con el isbn en la url
                 $archivoApiCompleto= $archivoApi[$claveIsbn];
       
                //Creamos el objeto libros
                 $olibro = new Libro($archivoApiCompleto['title'],$archivoApiCompleto['authors'][0]['name'], $archivoApiCompleto['cover']['medium'],$archivoApiCompleto['number_of_pages']);
                 return $olibro;
            }
        }
        return null;
    }

    public static function apiLibroPorTitulo($titulo) {
    $tituloUrl = urlencode($titulo);
    // Buscamos en la API de búsqueda por titulo
    $resultado = @file_get_contents("https://openlibrary.org/search.json?title=$tituloUrl&limit=1");
    
    if ($resultado) {
        $archivoApi = json_decode($resultado, true);
        
        // La API de búsqueda devuelve los resultados en un array llamado 'docs'
        if (isset($archivoApi['docs'][0]['isbn'][0])) {
            // Extraemos el primer ISBN que encuentre para ese título
            $isbnEncontrado = $archivoApi['docs'][0]['isbn'][0];
            
            // REUTILIZACIÓN: Llamamos a la función que ya tenemos pasándole el ISBN
            return self::apiLibros($isbnEncontrado);
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