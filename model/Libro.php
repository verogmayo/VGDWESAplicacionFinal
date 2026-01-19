<?php

/**
 * @author: Véro Grué
 * @since: 17/01/2026
 * Clase para gestionar la infomración de los paises de la api de Rest Countries
 */

class Libro{
    private $titulo;
    private $autor;
    private $portada;
    private $paginas;

    public function __construct($titulo, $autor, $portada, $paginas)    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->portada = $portada;
        $this->paginas = $paginas;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the value of autor
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Get the value of portada
     */
    public function getPortada()
    {
        return $this->portada;
    }

    /**
     * Get the value of paginas
     */
    public function getPaginas()
    {
        return $this->paginas;
    }
}
