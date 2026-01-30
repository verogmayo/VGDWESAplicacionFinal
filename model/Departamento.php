<?php
/**
 * Clase entidad para representar un departamento de la empresa
 * 
 * Encapsula toda la información relacionada con un departamento
 * incluyendo su código, descripción, fechas y volumen de negocio
 *
 * @author Véro Grué
 * @since 17/01/2026
 * @version 1.0.0
 */
class Departamento {
    
    /**
     * Código único del departamento
     *
     * @var string
     */
    private $codDepartamento;
    
    /**
     * Descripción o nombre del departamento
     *
     * @var string
     */
    private $descDepartamento;
    
    /**
     * Fecha de creación del departamento
     *
     * @var string Formato YYYY-MM-DD
     */
    private $fechaCreacionDepartamento;
    
    /**
     * Volumen de negocio del departamento
     *
     * @var float
     */
    private $volumenDeNegocio;
    
    /**
     * Fecha de baja del departamento (null si está activo)
     *
     * @var string|null Formato YYYY-MM-DD
     */
    private $fechaBajaDepartamento;

    /**
     * Constructor de la clase Departamento
     *
     * @param string $codDepartamento Código del departamento
     * @param string $descDepartamento Descripción del departamento
     * @param string $fechaCreacionDepartamento Fecha de creación
     * @param float $volumenDeNegocio Volumen de negocio
     * @param string|null $fechaBajaDepartamento Fecha de baja (opcional)
     */
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento = null) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

    /**
     * Obtiene el código del departamento
     *
     * @return string Código del departamento
     */ 
    public function getCodDepartamento() {
        return $this->codDepartamento;
    }

    /**
     * Obtiene la descripción del departamento
     *
     * @return string Descripción del departamento
     */ 
    public function getDescDepartamento() {
        return $this->descDepartamento;
    }

    /**
     * Obtiene la fecha de creación del departamento
     *
     * @return string Fecha de creación
     */ 
    public function getFechaCreacionDepartamento() {
        return $this->fechaCreacionDepartamento;
    }

    /**
     * Obtiene el volumen de negocio del departamento
     *
     * @return float Volumen de negocio
     */ 
    public function getVolumenDeNegocio() {
        return $this->volumenDeNegocio;
    }

    /**
     * Obtiene la fecha de baja del departamento
     *
     * @return string|null Fecha de baja o null si está activo
     */ 
    public function getFechaBajaDepartamento() {
        return $this->fechaBajaDepartamento;
    }

    /**
     * Establece el código del departamento
     *
     * @param string $codDepartamento Código del departamento
     * @return self
     */ 
    public function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    /**
     * Establece la descripción del departamento
     *
     * @param string $descDepartamento Descripción del departamento
     * @return self
     */
    public function setDescDepartamento($descDepartamento) {
        $this->descDepartamento = $descDepartamento;   
    }

    /**
     * Establece la fecha de creación del departamento
     *
     * @param string $fechaCreacionDepartamento Fecha de creación
     * @return self
     */
    public function setFechaCreacionDepartamento($fechaCreacionDepartamento) {
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
    }

    /**
     * Establece el volumen de negocio del departamento
     *
     * @param float $volumenDeNegocio Volumen de negocio
     * @return self
     */
    public function setVolumenDeNegocio($volumenDeNegocio) {
        $this->volumenDeNegocio = $volumenDeNegocio;
    }

    /**
     * Establece la fecha de baja del departamento
     *
     * @param string|null $fechaBajaDepartamento Fecha de baja
     * @return self
     */
    public function setFechaBajaDepartamento($fechaBajaDepartamento) {
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }
}
?>