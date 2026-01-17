<?php
/**
* @author: Véro Grué
* @since: 17/01/2026
* Clase para gestionar la foto de la nasa de la api
*/

class FotoNasa {
    private $titulo;
    private $url;
    private $fecha;

    public function __construct($titulo, $url, $fecha) {
        $this->titulo = $titulo;
        $this->url = $url;
        $this->fecha = $fecha;
    }
    
    public function getTitulo() { 
        return $this->titulo; 
    }
    public function getUrl() { 
        return $this->url; 
    }
    public function getfecha() { 
        return $this->fecha; 
    }
}

?>