<?php
/**
 * Clase para gestionar y almacenar información de errores de la aplicación
 * 
 * Esta clase encapsula los datos relacionados con errores que ocurren
 * durante la ejecución de la aplicación, incluyendo código, descripción,
 * ubicación del error y página de redirección
 *
 * @author Véro Grué
 * @since 10/01/2026
 * @version 1.0.0
 */
class AppError {
    
    /**
     * Código del error
     *
     * @var int|string
     */
    private $codError;
    
    /**
     * Descripción del error
     *
     * @var string
     */
    private $descError;
    
    /**
     * Ruta del archivo donde se produjo el error
     *
     * @var string
     */
    private $archivoError;
    
    /**
     * Número de línea donde se produjo el error
     *
     * @var int
     */
    private $lineaError;
    
    /**
     * URL de la página a la que redirigir tras el error
     *
     * @var string
     */
    private $paginaSiguente;

    /**
     * Constructor de la clase AppError
     *
     * @param int|string $codError Código del error
     * @param string $descError Descripción del error
     * @param string $archivoError Ruta del archivo donde ocurrió el error
     * @param int $lineaError Número de línea del error
     * @param string $paginaSiguiente URL de redirección
     */
    public function __construct($codError, $descError, $archivoError, $lineaError, $paginaSiguiente) {
        $this->codError = $codError;
        $this->descError = $descError;
        $this->archivoError = $archivoError;
        $this->lineaError = $lineaError;
        $this->paginaSiguente = $paginaSiguiente;
    }

    /**
     * Obtiene el código del error
     *
     * @return int|string Código del error
     */
    public function getCodError() {
        return $this->codError;
    }
    
    /**
     * Obtiene la descripción del error
     *
     * @return string Descripción del error
     */
    public function getDescError() {
        return $this->descError;
    }
    
    /**
     * Obtiene la ruta del archivo donde se produjo el error
     *
     * @return string Ruta del archivo
     */
    public function getArchivoError() {
        return $this->archivoError;
    }
    
    /**
     * Obtiene el número de línea donde se produjo el error
     *
     * @return int Número de línea
     */
    public function getLineaError() {
        return $this->lineaError;
    }
    
    /**
     * Obtiene la URL de la página siguiente
     *
     * @return string URL de redirección
     */
    public function getPaginaSiguiente() {
        return $this->paginaSiguente;
    }

    /**
     * Establece el código del error
     *
     * @param int|string $codError Código del error
     * @return void
     */
    public function setCodError($codError) {
        $this->codError = $codError;
    }
    
    /**
     * Establece la descripción del error
     *
     * @param string $descError Descripción del error
     * @return void
     */
    public function setDescError($descError) {
        $this->descError = $descError;
    }
    
    /**
     * Establece la ruta del archivo donde se produjo el error
     *
     * @param string $archivoError Ruta del archivo
     * @return void
     */
    public function setArchivoError($archivoError) {
        $this->archivoError = $archivoError;
    }
    
    /**
     * Establece el número de línea donde se produjo el error
     *
     * @param int $lineaError Número de línea
     * @return void
     */
    public function setLineaError($lineaError) {
        $this->lineaError = $lineaError;
    }
    
    /**
     * Establece la URL de la página siguiente
     *
     * @param string $paginaSiguente URL de redirección
     * @return void
     */
    public function setPaginaSiguiente($paginaSiguente) {
        $this->paginaSiguente = $paginaSiguente;
    }
}
?>