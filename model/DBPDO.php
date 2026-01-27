<?php
/**
 * Clase para gestionar conexiones y consultas a base de datos mediante PDO
 * 
 * Proporciona un método estático centralizado para ejecutar consultas SQL
 * con manejo de errores y redirección automática en caso de fallo
 *
 * @author Véro Grué
 * @since 18/12/2025
 * @version 1.0.0
 */ 
class DBPDO {
/**
     * Ejecuta una consulta SQL preparada con PDO
     *
     * Establece conexión con la base de datos, prepara y ejecuta la sentencia SQL.
     * En caso de error, registra el error en sesión y redirige a página de error
     *
     * @param string $sentenciaSQL Sentencia SQL a ejecutar (puede contener placeholders)
     * @param array|null $aParametros Array asociativo con los parámetros de la consulta
     * @return PDOStatement Objeto PDOStatement con el resultado de la consulta
     * @throws PDOException Si ocurre un error en la base de datos
     */
    public static function ejecutarConsulta($sentenciaSQL, $aParametros = null) {
        try {
            // Conexión a la base de datos
            $conexion = new PDO(DSN, USUARIODB, PSWD);
            // Configurar el modo errores
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Preparar y ejecutar la consulta
            $consulta = $conexion->prepare($sentenciaSQL);
            $consulta->execute($aParametros);

            return $consulta;
        }catch (PDOException $e) {
            $_SESSION['paginaAnterior']=$_SESSION['paginaEnCurso'];
            $_SESSION['paginaEnCurso']='error';
            $_SESSION['error']= new AppError($e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine(), $_SESSION['paginaAnterior']);
            header('Location: index.php');
            exit;
        }

    }
}
?>