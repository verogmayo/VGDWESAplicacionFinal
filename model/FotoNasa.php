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
     * Para la conversión de la imagen de la nasa
     * 
     * @var string
     */
    private $imagenBase64;

    /**
     * Para la conversión de la imagen de la nasa
     * 
     * @var string
     */
    private $imagenHDBase64;

    /**
     * Constructor de la clase FotoNasa
     *
     * @param string $titulo Título de la foto
     * @param string $url URL de la imagen estándar
     * @param string $fecha Fecha de la foto
     * @param string $explicacion Descripción de la foto
     * @param string $urlhd URL de la imagen en HD
     * @param string $imagenBase64 conversión de la imagen
     */
    public function __construct($titulo, $url, $fecha, $explicacion, $urlhd, $imagenBase64,$imagenHDBase64) {
        $this->titulo = $titulo;
        $this->url = $url;
        $this->fecha = $fecha;
        $this->explicacion = $explicacion;
        $this->urlhd = $urlhd;
        $this->imagenBase64 = $imagenBase64;
        $this->imagenHDBase64=$imagenHDBase64;
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

    /**
     * Obtiene la conversion de la imagen 
     * 
     * @return string cadena larga
     */
    public function getImagenBase64() {
        return $this->imagenBase64;
        
    }

    

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setExplicacion($explicacion)
    {
        $this->explicacion = $explicacion;

        return $this;
    }

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setUrlhd($urlhd)
    {
        $this->urlhd = $urlhd;

        return $this;
    }

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setImagenBase64($imagenBase64)
    {
        $this->imagenBase64 = $imagenBase64;

        return $this;
    }

    /**
     * Get constructor de la clase FotoNasa
     */ 
    public function getImagenHDBase64()
    {
        return $this->imagenHDBase64;
    }

    /**
     * Set constructor de la clase FotoNasa
     *
     * @return  self
     */ 
    public function setImagenHDBase64($imagenHDBase64)
    {
        $this->imagenHDBase64 = $imagenHDBase64;

        return $this;
    }
}
?>