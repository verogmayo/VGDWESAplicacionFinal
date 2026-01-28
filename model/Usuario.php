<?php

/**
 *  Clase entidad para representar un usuario de la aplicación
 * 
 * Encapsula la información de un usuario registrado en el sistema
 *
 * @author: Véro Grué
 * @since: 18/12/2025
 * @version: 1.0.0
 */
class Usuario
{
    /**
     * Codigo de Usuario
     *
     * @var string
     */
    private $codUsuario;

    /**
     * Contraseña del usuario
     *
     * @var string
     */
    private $password;

    /**
     * Nombre del usuario
     *
     * @var string
     */
    private $descUsuario;

    /**
     * Número de accesos del usuario
     *
     * @var int
     */
    private $numAccesos;

    /**
     * Fecha y hora de la última conexión
     *
     * @var DateTime 
     */
    private $fechaHoraUltimaConexion;

    /**
     * Fecha y hora de la penúltima conexión
     *
     * @var DateTime 
     */
    private $fechaHoraUltimaConexionAnterior;

    /**
     * Perfil del usuario (Administrador o usuario)
     *
     * @var string
     */
    private $perfil;

    /**
     * Imagen del usuario almacenada como datos binarios
     *
     * @var string|null Contenido binario de la imagen (MEDIUMBLOB) o null si no tiene imagen
     */
    private $imagenUsuario;

    /**
     * Inicial del nombre del usuario
     *
     * @var string
     */
    private $inicial;


    /**
     * Cosntructor de la clase USUARIO
     *
     * @param string $codUsuario Código de usuario
     * @param string $password Contraseña
     * @param string $descUsuario Nombre del usuario
     * @param int $numAccesos Número de accesos
     * @param DateTime $fechaHoraUltimaConexion Fecha y hora de la última conexión
     * @param DateTime $fechaHoraUltimaConexionAnterior   Fecha y hora de la penúltima conexión
     * @param string $perfil Perfil del usuario (Administrador o usuario)
     * @param string $imagenUsuario     Imagen del usuario (MEDIUMBLOB)
     * @param string $inicial Inicial del nombre del usuario
     */
    public function __construct($codUsuario, $password, $descUsuario, $numAccesos, $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil, $imagenUsuario, $inicial)
    {
        $this->codUsuario = $codUsuario;
        $this->password = $password;
        $this->descUsuario = $descUsuario;
        $this->numAccesos = $numAccesos;
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
        $this->perfil = $perfil;
        $this->imagenUsuario = $imagenUsuario;
        $this->inicial = mb_strtoupper(mb_substr($descUsuario, 0, 1));
    }

    /**
     * Getters y Setters de la clase Usuario
     */

    /**
     * Obtiene el código de usuario
     *
     * @return string Código de usuario
     */
    public function getCodUsuario()
    {
        return $this->codUsuario;
    }

    /**
     * Obtiene la contraseña del usuario
     *
     * @return string Contraseña
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Obtiene el nombre del usuario
     *
     * @return string Nombre del usuario
     */
    public function getDescUsuario()
    {
        return $this->descUsuario;
    }

    /**
     * Obtiene el número de accesos del usuario
     *
     * @return int Número de accesos
     */
    public function getNumAccesos()
    {
        return $this->numAccesos;
    }

    /**
     * Obtiene la fecha y hora de la última conexión
     *
     * @return DateTime Objeto DateTime con la fecha/hora o null si nunca se ha conectado 
     */
    public function getFechaHoraUltimaConexion()
    {
        return $this->fechaHoraUltimaConexion;
    }

    /**
     * Obtiene la fecha y hora de la penúltima conexión
     *
     * @return DateTime Objeto DateTime con la fecha/hora o null si nunca se ha conectado 
     */
    public function getFechaHoraUltimaConexionAnterior()
    {
        return $this->fechaHoraUltimaConexionAnterior;
    }

    /**
     * Obtiene el perfil del usuario
     *
     * @return string Perfil del usuario
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Obtiene la imagen del usuario
     *
     * @return string|null Contenido binario de la imagen (MEDIUMBLOB) o null si no tiene imagen
     */
    public function getImagenUsuario()
    {
        return $this->imagenUsuario;
    }

    /**
     * Obtiene la inicial del nombre del usuario
     *
     * @return string Inicial del nombre del usuario
     */
    public function getInicial()
    {
        return $this->inicial;
    }

    //SETTERS

    /**
     * Establece el código de usuario
     * @param string $codUsuario Código de usuario
     * @return void
     */
    public function setCodUsuario($codUsuario)
    {
        $this->codUsuario = $codUsuario;
    }
    /**
     * Establece la contraseña del usuario
     *
     * @param string $password Contraseña del usuario
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Establece el nombre del usuario
     *
     * @param string $descUsuario Nombre del usuario
     * @return void
     */
    public function setDescUsuario($descUsuario)
    {
        $this->descUsuario = $descUsuario;
        $this->inicial = mb_strtoupper(mb_substr($descUsuario, 0, 1));
    }

    /**
     * Establece el número de accesos del usuario
     *
     * @param int $numAccesos Número de accesos
     * @return void
     */
    public function setnumAccesos($numAccesos)
    {
        $this->numAccesos = $numAccesos;
    }

    /**
     * Establece la fecha y hora de la última conexión
     *
     * @param DateTime $fechaHoraUltimaConexion Fecha y hora de la última conexión
     * @return void
     */
    public function setfechaHoraUltimaConexion($fechaHoraUltimaConexion)
    {
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
    }

    /**
     * Establece la fecha y hora de la penúltima conexión
     *
     * @param DateTime $fechaHoraUltimaConexionAnterior Fecha y hora de la penúltima conexión
     * @return void
     */
    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior)
    {
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    /**
     * Establece el perfil del usuario
     *
     * @param string $perfil Perfil del usuario
     * @return void
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
    
    /**
     * Establece la imagen del usuario
     *
     * @param string|null $imagenUsuario Contenido binario de la imagen (MEDIUMBLOB) o null si no tiene imagen
     * @return void
     */
    public function setImagenUsuario($imagenUsuario)
    {
        $this->imagenUsuario = $imagenUsuario;
    }
}
