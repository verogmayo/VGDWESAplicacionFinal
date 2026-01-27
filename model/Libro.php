<?php
/**
 * Clase entidad para representar un libro
 * 
 * Encapsula la información básica de un libro obtenida
 * de la API de Open Library
 *
 * @author Véro Grué
 * @since 20/01/2026
 * @version 1.0.0
 */
class Libro {
    
    /**
     * Título del libro
     *
     * @var string
     */
    private $titulo;
    
    /**
     * Nombre del autor
     *
     * @var string
     */
    private $autor;
    
    /**
     * URL de la imagen de portada
     *
     * @var string
     */
    private $portada;
    
    /**
     * Año de publicación
     *
     * @var string|int
     */
    private $anioPublicacion;

    /**
     * Constructor de la clase Libro
     *
     * @param string $titulo Título del libro
     * @param string $autor Nombre del autor
     * @param string $portada URL de la portada
     * @param string|int $anioPublicacion Año de publicación
     */
    public function __construct($titulo, $autor, $portada, $anioPublicacion) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->portada = $portada;
        $this->anioPublicacion = $anioPublicacion;
    }

    /**
     * Obtiene el título del libro
     *
     * @return string Título
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Obtiene el nombre del autor
     *
     * @return string Autor
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Obtiene la URL de la portada
     *
     * @return string URL de la portada
     */
    public function getPortada() {
        return $this->portada;
    }

    /**
     * Obtiene el año de publicación
     *
     * @return string|int Año de publicación
     */
    public function getAnioPublicacion() {
        return $this->anioPublicacion;
    }
}
?>