<?php

/**
 * @author: Véro Grué
 * @since: 17/01/2026
 * Clase para gestionar la infomración de los paises de la api de Rest Countries
 */

class Departamento{
    private $codDepartamento;
    private $descDepartamento;
    private $fechaCreacionDepartamento;
    private $volumenDeNegocio;
    private $fechaBajaDepartamento;

    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento=null)
    {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
        
    }



    /**
     * Get the value of codDepartamento
     */ 
    public function getCodDepartamento()
    {
        return $this->codDepartamento;
    }

    /**
     * Get the value of descDepartamento
     */ 
    public function getDescDepartamento()
    {
        return $this->descDepartamento;
    }

    /**
     * Get the value of fechaCreacionDepartamento
     */ 
    public function getFechaCreacionDepartamento()
    {
        return $this->fechaCreacionDepartamento;
    }

    /**
     * Get the value of volumenDeNegocio
     */ 
    public function getVolumenDeNegocio()
    {
        return $this->volumenDeNegocio;
    }

    /**
     * Get the value of fechaBajaDepartamento
     */ 
    public function getFechaBajaDepartamento()
    {
        return $this->fechaBajaDepartamento;
    }

    

    /**
     * Set the value of codDepartamento
     *
     * @return  self
     */ 
    public function setCodDepartamento($codDepartamento)
    {
        $this->codDepartamento = $codDepartamento;

        return $this;
    }
}

?>