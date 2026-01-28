<?php

/**
 * Clase para gestionar las operaciones de usuario en la base de datos utilizando PDO
 * 
 * Proporciona métodos estáticos para validar, crear, actualizar y eliminar usuarios
 * 
 * @author: Véro Grué
 * @since: 18/12/2025
 * @version: 1.0.0
 */
require_once 'DBPDO.php';
require_once 'Usuario.php';

class UsuarioPDO
{

    /**
     * Valida las credenciales de un usuario y devuelve un objeto Usuario si son correctas
     * @param string $codUsuario Código del usuario
     * @param string $password Contraseña sin encriptar
     * @return Usuario|null Objeto Usuario si las credenciales son correctas, null si no
     */
    public static function validarUsuario($codUsuario, $password)
    {

        // Consulta SQL para validar usuario
        $sql = <<<SQL
            SELECT
                T01_CodUsuario,
                T01_Password,
                T01_DescUsuario,
                T01_FechaHoraUltimaConexion,
                T01_NumConexiones,
                T01_Perfil,
                T01_ImagenUsuario
            FROM T01_Usuario
            WHERE T01_CodUsuario = :codUsuario
              AND T01_Password = SHA2(:password, 256)
        SQL;

        try {
            // Ejecutar la consulta
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario'  => $codUsuario,
                ':password' => $codUsuario . $password
            ]);


            // Obtener el resultado
            $usuarioDB = $consulta->fetch(PDO::FETCH_ASSOC);

            // Si no existe el usuario o la contraseña es incorrecta
            if (!$usuarioDB) {
                return null;
            }

            //Se convierte la fecha en datetime
            $fechaBD = $usuarioDB['T01_FechaHoraUltimaConexion'];
            $oFechaValida = ($fechaBD) ? new DateTime($fechaBD) : null;
            // Crear el objeto Usuario con los datos de la BD
            $oUsuario = new Usuario(
                $usuarioDB['T01_CodUsuario'],
                $usuarioDB['T01_Password'],
                $usuarioDB['T01_DescUsuario'],
                $usuarioDB['T01_NumConexiones'],
                $oFechaValida,
                null,                                         // fechaHoraUltimaConexionAnterior (empieza en null)
                $usuarioDB['T01_Perfil'],
                $usuarioDB['T01_ImagenUsuario'],
                mb_strtoupper(mb_substr($usuarioDB['T01_DescUsuario'], 0, 1))
            );



            return $oUsuario;
        } catch (Exception $e) {
            // En caso de error, devolver null
            return null;
        }
    }

    /**
     * Actualiza la fecha de última conexión y el contador de accesos
     * @param Usuario $oUsuario Objeto usuario a actualizar
     * @return Usuario|null Objeto Usuario con la fecha de ultimaactualización actualizada 
     */
    public static function actualizarUltimaConexion($oUsuario)
    {

        // SQL para actualizar los datos de conexión
        $sql = <<<SQL
            UPDATE T01_Usuario SET
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :codUsuario
        SQL;


        // Ejecutar la actualización en la BD
        DBPDO::ejecutarConsulta($sql, [
            ':codUsuario' => $oUsuario->getCodUsuario()
        ]);

        // Actualizar el objeto Usuario en memoria
        // La fecha actual que tenía ahora pasa a ser la anterior
        $oUsuario->setFechaHoraUltimaConexionAnterior($oUsuario->getFechaHoraUltimaConexion());

        // Incrementar el número de accesos
        $oUsuario->setNumAccesos($oUsuario->getNumAccesos() + 1);

        // Establecer la nueva fecha de conexión (ahora)
        date_default_timezone_set('Europe/Madrid');
        $oUsuario->setFechaHoraUltimaConexion(new DateTime());
        return $oUsuario;
    }

    /**
     * Crea un nuevo usuario en la base de datos
     * @param string $codUsuario
     * @param string $password
     * @param string $descUsuario
     * @return Usuario|null El objeto usuario si se crea con éxito, null si falla
     */
    public static function crearUsuario($codUsuario, $password, $descUsuario)
    {
        $oUsuario = null;

        // SQL para insertar el nuevo registro
        // El perfil por defecto debe ser 'usuario'
        $sql = <<<SQL
            INSERT INTO T01_Usuario 
            (T01_CodUsuario, 
            T01_Password, 
            T01_DescUsuario, 
            T01_FechaHoraUltimaConexion,
            T01_NumConexiones,
            T01_Perfil             
            ) 
            VALUES 
            (:codUsuario, 
            SHA2(:password, 256), 
            :descUsuario,
            now(),
            1,
            'usuario')
        SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario' => $codUsuario,
                ':password' => $codUsuario . $password,
                ':descUsuario' => $descUsuario
            ]);

            if ($consulta) {
                // Si la inserción tiene éxito, se valida al usuario para obtener el objeto completo
                // (y se rellena las fechas iniciales y el número de conexiones)
                $oUsuario = self::validarUsuario($codUsuario, $password);
            }
        } catch (Exception $e) {
            return null;
        }

        return $oUsuario;
    }

    /**
     * Comprueba si un código de usuario ya existe en la BD
     * @param string $codUsuario
     * @return boolean true si existe, false si no
     */
    public static function validarCodigoNoExiste($codUsuario)
    {
        $existe = false;
        $sql = "SELECT T01_CodUsuario FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";

        try {
            //si la consulta devuelve alguna fila es que el codigo ya existe
            $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
            if ($consulta->rowCount() > 0) {
                $existe = true;
            }
        } catch (Exception $e) {
            $existe = false;
        }
        return $existe;
    }

    /**
     * Cambia la contraseña de un usuario existente
     * @param Usuario $oUsuario Objeto del usuario actual
     * @param string $nuevaPassword Nueva contraseña
     * @return Usuario|null El objeto usuario actualizado o null si falla
     */
    public static function cambiarPassword($oUsuario, $nuevaPassword)
    {
        $sql = <<<SQL
        UPDATE T01_Usuario SET 
            T01_Password = SHA2(:password, 256)
        WHERE T01_CodUsuario = :codUsuario
    SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario' => $oUsuario->getCodUsuario(),
                ':password' => $oUsuario->getCodUsuario() . $nuevaPassword
            ]);

            if ($consulta) {
                // Se actualiza la contraseña en el objeto existente para que coincida con la BD
                $oUsuario->setPassword(hash('sha256', $oUsuario->getCodUsuario() . $nuevaPassword));
                return $oUsuario;
            }
        } catch (Exception $e) {
            return null;
        }
        return null;
    }

    /**
     * Elimina un usuario de la base de datos
     * @param Usuario $oUsuario Objeto del usuario a eliminar
     * @return boolean True si se borró correctamente, false si no se borró
     */
    public static function borrarUsuario($oUsuario)
    {
        $sql = <<<SQL
        DELETE FROM T01_Usuario 
        WHERE T01_CodUsuario = :codUsuario
    SQL;
        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario' => $oUsuario->getCodUsuario()
            ]);

            // rowCount() para ver si se borro la fila
            if ($consulta->rowCount() > 0) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * Modifica la descripción del usuario de la base de datos
     * @param Usuario $oUsuario Objeto del usuario a modificar
     * @param string $nuevoNombre nuevo nombre del usuario
     * @return Usuario|null El objeto usuario actualizado o null si falla
     */
    public static function modificarUsuario($oUsuario, $nuevoNombre)
    {
        $sql = <<<SQL
        UPDATE T01_Usuario 
        SET T01_DescUsuario = :nuevaDesc 
        WHERE T01_CodUsuario = :descUsuario
        SQL;
        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':nuevaDesc' => $nuevoNombre,
                ':descUsuario' => $oUsuario->getCodUsuario()
            ]);


            if ($consulta) {
                //Se actualiza la descripcion del usuario
                $oUsuario->setDescUsuario($nuevoNombre);
                return $oUsuario;
            }
        } catch (Exception $e) {
            return null;
        }
        return null;
    }

    /**
     * Cambia la foto de perfil de un usuario en la base de datos.
     *
     * @param string $codUsuario Código identificador del usuario.
     * @param string  $imagen     Imagen del usuario en formato BLOB.
     * @return int Número de filas afectadas por el update : 1 si la foto se ha actualizado,0 si no hubo cambios (misma imagen o usuario inexistente).
     */
    public static function cambiarFoto($codUsuario, $imagen)
    {
        $sql = <<<SQL
        UPDATE T01_Usuario 
        SET T01_ImagenUsuario = :foto 
        WHERE T01_CodUsuario = :codUsuario
        SQL;
        $parametros = [':foto' => $imagen, ':codUsuario' => $codUsuario];
        $resultado = DBPDO::ejecutarConsulta($sql, $parametros);
        //Devulve 0 si hay no se ha cambiado la foto y 1 si se ha cambiado la foto
        return $resultado->rowCount();
    }
}
