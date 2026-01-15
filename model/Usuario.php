<?php 
/**
* @author: Véro Grué
* @since: 18/12/2025
*/
class Usuario{
    private $codUsuario;
    private $password;
    private $descUsuario;
    private $numAccesos;
    private $fechaHoraUltimaConexion;
    private $fechaHoraUltimaConexionAnterior;
    private $perfil;
    private $imagenUsuario;
    private $inicial;


    public function __construct($codUsuario, $password, $descUsuario , $numAccesos , $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil, $imagenUsuario, $inicial) {
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

    //getters y setters
    public function getCodUsuario(){
        return $this->codUsuario ;

    }
    public function getPassword(){
        return $this->password;

    }
    public function getDescUsuario(){
        return $this->descUsuario;

    }
    public function getNumAccesos(){
        return $this->numAccesos;

    }
    public function getFechaHoraUltimaConexion(){
        return $this->fechaHoraUltimaConexion;

    }
    public function getFechaHoraUltimaConexionAnterior(){
        return $this->fechaHoraUltimaConexionAnterior;

    }
    public function getPerfil(){
        return $this->perfil;

    }
    public function getImagenUsuario(){
        return $this->imagenUsuario;
    }
    public function getInicial() {
        return $this->inicial;
    }


    public function setCodUsuario($codUsuario){
        $this->codUsuario = $codUsuario;
    }
    public function setPassword($password){
            $this->password = $password;

    }
    public function setDescUsuario($descUsuario){
         $this->descUsuario = $descUsuario;
         $this->inicial = mb_strtoupper(mb_substr($descUsuario, 0, 1));

    }
    public function setnumAccesos($numAccesos){
         $this->numAccesos = $numAccesos;

    }
    public function setfechaHoraUltimaConexion( $fechaHoraUltimaConexion){
         $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;

    }
    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior){
         $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;

    }
    public function setPerfil($perfil){
         $this->perfil = $perfil;

    }
    public function setImagenUsuario($imagenUsuario) {
        $this->imagenUsuario = $imagenUsuario;
    }


}
?>