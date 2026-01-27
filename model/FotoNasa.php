<?php
/**
 * Clase entidad para representar una foto astronómica de la NASA
 * 
 * Encapsula la información de una imagen del servicio de la 
 * foto del día de la NASA
 *
 * @author Véro Grué
 * @since 17/01/2026
 * @version 1.0.0
 */
class FotoNasa {
    
    /**
     * Título de la foto
     *
     * @var string
     */
    private $titulo;
    
    /**
     * URL de la imagen en resolución estándar
     *
     * @var string
     */
    private $url;
    
    /**
     * Fecha de la foto
     *
     * @var string Formato YYYY-MM-DD
     */
    private $fecha;
    
    /**
     * Explicación o descripción de la foto
     *
     * @var string
     */
    private $explicacion;
    
    /**
     * URL de la imagen en alta definición
     *
     * @var string
     */
    private $urlhd;

    /**
     * Constructor de la clase FotoNasa
     *
     * @param string $titulo Título de la foto
     * @param string $url URL de la imagen estándar
     * @param string $fecha Fecha de la foto
     * @param string $explicacion Descripción de la foto
     * @param string $urlhd URL de la imagen en HD
     */
    public function __construct($titulo, $url, $fecha, $explicacion, $urlhd) {
        $this->titulo = $titulo;
        $this->url = $url;
        $this->fecha = $fecha;
        $this->explicacion = $explicacion;
        $this->urlhd = $urlhd;
    }
    
    /**
     * Obtiene el título de la foto
     *
     * @return string Título
     */
    public function getTitulo() { 
        return $this->titulo; 
    }
    
    /**
     * Obtiene la URL de la imagen estándar
     *
     * @return string URL
     */
    public function getUrl() { 
        return $this->url; 
    }
    
    /**
     * Obtiene la fecha de la foto
     *
     * @return string Fecha
     */
    public function getFecha() { 
        return $this->fecha; 
    }

    /**
     * Obtiene la explicación de la foto
     *
     * @return string Explicación
     */
    public function getExplicacion() {
        return $this->explicacion;
    }
    
    /**
     * Obtiene la URL de la imagen en alta definición
     *
     * @return string URL HD
     */
    public function getUrlhd() {
        return $this->urlhd;
    }
}
?>