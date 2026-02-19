<?php

/**
 * Clase para gestionar las operaciones de usuario en la base de datos utilizando PDO
 * 
 * Proporciona métodos estáticos para validar, crear, actualizar y eliminar usuarios
 * 
 * @author: Véro Grué
 * Creado el 18/12/2025
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

        $oFechaHora = new DateTime();
        $fechaHoraFormateada = $oFechaHora->format('d-m-Y H:i:s');

        try {
            // Ejecutar la consulta
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario'  => $codUsuario,
                ':password' => $codUsuario . $password
            ]);
            // Obtener el resultado
            $usuarioDB = $consulta->fetchObject();
            // Si no existe el usuario o la contraseña es incorrecta
            if (!$usuarioDB) {
                // SE inicializa o incrementa el contador de intentos en la sesión
                $_SESSION['intentosLogin'] = ($_SESSION['intentosLogin'] ?? 0) + 1;
                //se crea el mensaje de intento fallido
                $mensaje = "[AUDITORÍA] [$fechaHoraFormateada] Intento de login FALLIDO para el usuario '$codUsuario'.";
                // Si llega a 5 intentos, se pone el mensaje en MAYÚSCULAS para que destaque
                if ($_SESSION['intentosLogin'] >= 5) {
                    $mensaje = strtoupper("[ALERTA CRÍTICA] [$fechaHoraFormateada] SE HAN DETECTADO " . $_SESSION['intentosLogin'] . " INTENTOS FALLIDOS CONSECUTIVOS PARA EL USUARIO '$codUsuario'. POSIBLE ATAQUE DE FUERZA BRUTA.");
                }
                //se envia el mensaje al fichero de error
                error_log($mensaje);
                return null;
            }

            // Se guarda el login correcto ---
            // Si el login es correcto, reseteamos el contador de intentos
            $_SESSION['intentosLogin'] = 0;

            error_log("[AUDITORÍA] [$fechaHoraFormateada] Login exitoso para el usuario '$codUsuario'.");

            //Se convierte la fecha en datetime
            $fechaBD = $usuarioDB->T01_FechaHoraUltimaConexion;
            $oFechaValida = ($fechaBD) ? new DateTime($fechaBD) : null;
            // Crear el objeto Usuario con los datos de la BD
            $oUsuario = new Usuario(
                $usuarioDB->T01_CodUsuario,
                $usuarioDB->T01_Password,
                $usuarioDB->T01_DescUsuario,
                $usuarioDB->T01_NumConexiones,
                $oFechaValida,
                null,                                         // fechaHoraUltimaConexionAnterior (empieza en null)
                $usuarioDB->T01_Perfil,
                $usuarioDB->T01_ImagenUsuario,
                mb_strtoupper(mb_substr($usuarioDB->T01_DescUsuario, 0, 1))
            );
            return $oUsuario;
        } catch (Exception $e) {
            //se recoge un mensaje si hay un error de validación
            error_log("ERROR DE SISTEMA EN VALIDACIÓN: " . $e->getMessage());
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
    public static function validarCodUsuarioExiste($codUsuario)
    {
        $existe = false;
        $sql = "SELECT T01_CodUsuario FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);

            // Si fetch devuelve algo, es que el código ya está en uso
            if ($consulta->fetch()) {
                $existe = true;
            }
        } catch (Exception $e) {
            // Registro del error (OWASP A09)
            error_log("Error crítico en validación de usuario: " . $e->getMessage());
            //si hay un problema, devuelve true para evitar problemas
            return true;
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

    public static function cambiarPasswordPorCod($codUsuario, $nuevaPassword)
    {
        $sql = <<<SQL
        UPDATE T01_Usuario SET 
            T01_Password = SHA2(:password, 256)
        WHERE T01_CodUsuario = :codUsuario
    SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario' => $codUsuario,
                ':password' => $codUsuario . $nuevaPassword
            ]);

            return ($consulta->rowCount() > 0);
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
     * Elimina un usuario de la base de datos por su código
     * * @param string $codUsuario El código del usuario a eliminar
     * @return boolean True si se borró correctamente, false en caso contrario
     */
    public static function borrarUsuarioPorCod($codUsuario)
    {
        $sql = "DELETE FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);

            // Si se ha borrado al menos una fila, devolvemos true
            if ($consulta->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error PDO: " . $e->getMessage());
            return false;
        }
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
        WHERE T01_CodUsuario = :codUsuario
        SQL;
        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':nuevaDesc' => $nuevoNombre,
                ':codUsuario' => $oUsuario->getCodUsuario()
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

    /**
     * Crea un nuevo usuario por un administrador en la base de datos
     * @param string $codUsuario
     * @param string $password
     * @param string $descUsuario
     * @param string $perfil
     * @return Usuario|null El objeto usuario si se crea con éxito, null si falla
     */
    public static function crearUsuarioPorAdmin($codUsuario, $password, $descUsuario, $perfil)
    {
        $sql = <<<SQL
        INSERT INTO T01_Usuario 
        (T01_CodUsuario, T01_Password, T01_DescUsuario, T01_FechaHoraUltimaConexion, T01_NumConexiones, T01_Perfil) 
        VALUES 
        (:codUsuario, SHA2(:password, 256), :descUsuario, null, 0, :perfil)
    SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codUsuario' => $codUsuario,
                ':password' => $codUsuario . $password, // Concatenación para el hash
                ':descUsuario' => $descUsuario,
                ':perfil' => $perfil
            ]);

            if ($consulta) {
                // En lugar de validarUsuario, podrías simplemente devolver true
                // o buscar al usuario de forma neutra
                return self::buscarUsuarioPorCod($codUsuario);
            }
        } catch (Exception $e) {
            error_log("Error crearUsuarioPorAdmin: " . $e->getMessage());
            return null;
        }
        return null;
    }

    /**
     * Busca un usuario por su código de usuario
     * @param string $codUsuario
     * @return Usuario|null Objeto usuario o null si no existe
     */
    public static function buscarUsuarioPorCod($codUsuario)
    {
        $oUsuario = null;
        $sql = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
            $usuarioBD = $consulta->fetchObject();

            if ($usuarioBD) {
                // Convertir string de la Base de Datos a objeto DateTime)
                $oFechaValida = ($usuarioBD->T01_FechaHoraUltimaConexion)
                    ? new DateTime($usuarioBD->T01_FechaHoraUltimaConexion)
                    : null;

                // SE crea el objeto Usuario con los 9 parámetros exactos
                $oUsuario = new Usuario(
                    $usuarioBD->T01_CodUsuario,
                    $usuarioBD->T01_Password,
                    $usuarioBD->T01_DescUsuario,
                    $usuarioBD->T01_NumConexiones,
                    $oFechaValida,
                    null,
                    $usuarioBD->T01_Perfil,
                    $usuarioBD->T01_ImagenUsuario,
                    mb_strtoupper(mb_substr($usuarioBD->T01_DescUsuario, 0, 1))
                );
            }
        } catch (Exception $e) {
            error_log("Error en buscarUsuarioPorCod: " . $e->getMessage());
            return null;
        }

        return $oUsuario;
    }

    /**
     * Busca usuarios cuya descripción contenga la cadena buscada
     * @param string $descUsuario Cadena de búsqueda
     * @return array Array de objetos Usuario
     */
    public static function buscarUsuariosPorDesc($descUsuario = "")
    {
        $aUsuarios = [];
        $sql = "SELECT * FROM T01_Usuario WHERE T01_DescUsuario LIKE :descUsuario";

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':descUsuario' => "%" . $descUsuario . "%"
            ]);

            // Usamos fetch para recorrer todos los resultados
            while ($usuarioBD = $consulta->fetchObject()) {

                // SE convierte la fecha de la base de datos a objeto DateTime
                $oFecha = ($usuarioBD->T01_FechaHoraUltimaConexion)
                    ? new DateTime($usuarioBD->T01_FechaHoraUltimaConexion)
                    : null;

                // se insertan los objetos Usuario en el array
                $aUsuarios[] = new Usuario(
                    $usuarioBD->T01_CodUsuario,
                    $usuarioBD->T01_Password,
                    $usuarioBD->T01_DescUsuario,
                    $usuarioBD->T01_NumConexiones,
                    $oFecha,
                    null,
                    $usuarioBD->T01_Perfil,
                    $usuarioBD->T01_ImagenUsuario,
                    mb_strtoupper(mb_substr($usuarioBD->T01_DescUsuario, 0, 1))
                );
            }
        } catch (Exception $e) {
            error_log("Error en buscarUsuariosPorDesc: " . $e->getMessage());
        }

        return $aUsuarios;
    }

    /**
     * Modifica la contraseña y el perfil del usuario
     * @param Usuario $oUsuario Objeto del usuario a modificar
     * @param string $passwordNueva Nueva contraseña
     * @param string $perfilNuevo Nuevo perfil del usuario
     * @return Usuario|null El objeto actualizado o null si falla
     */
    public static function modificarUsuarioPorAdmin($oUsuario, $perfilNuevo)
    {

        $sql = <<<SQL
        UPDATE T01_Usuario 
        SET T01_Perfil = :perfil
        WHERE T01_CodUsuario = :codUsuario
    SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':perfil' => $perfilNuevo,
                ':codUsuario' => $oUsuario->getCodUsuario()
            ]);

            if ($consulta) {
                $oUsuario->setPerfil($perfilNuevo);
                return $oUsuario;
            }
        } catch (Exception $e) {
            error_log("Error en modificarUsuarioPorAdmin: " . $e->getMessage());
            return null;
        }
        return null;
    }

    /**
 * Modifica el perfil del usuario a partir de su código
 * @param string $codUsuario Código del usuario a modificar
 * @param string $perfilNuevo Nuevo perfil ('usuario' o 'administrador')
 * @return bool True si se modificó con éxito, false en caso contrario
 */
public static function modificarPerfilPorCod($codUsuario, $perfilNuevo)
{
    $sql = "UPDATE T01_Usuario SET T01_Perfil = :perfil WHERE T01_CodUsuario = :codUsuario";

    try {
        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':perfil' => $perfilNuevo,
            ':codUsuario' => $codUsuario
        ]);

        // rowCount() dice si se cambió algo en la base de datos
        return ($consulta->rowCount() > 0);
    } catch (PDOException $e) {
        error_log("Error en modificarPerfilPorCod: " . $e->getMessage());
        return false;
    }
}
}
