<?php

/**
 * Clase PDO para operaciones de base de datos relacionadas con departamentos
 * 
 * Proporciona métodos estáticos para consultar y manipular registros
 * de departamentos en la base de datos
 *
 * @author Véro Grué
 * @since 23/01/2026
 * @version 1.0.0
 */
require_once 'DBPDO.php';
require_once 'Departamento.php';

class DepartamentoPDO
{

    /**
     * Busca departamentos por descripción con búsqueda parcial
     *
     * Realiza una búsqueda en la tabla T02_Departamento usando LIKE
     * para encontrar coincidencias parciales en la descripción.
     * Los resultados se ordenan alfabéticamente por descripción
     *
     * @param string|null $descDepartamento Descripción o parte de ella a buscar
     * @return array Array de objetos Departamento encontrados
     */
    public static function buscarDepartamentoPorDesc($descDepartamento = null)
    {
        $aDepartamentos = [];

        $sql = <<<SQL
            SELECT *
            FROM T02_Departamento 
            WHERE T02_DescDepartamento LIKE :descDpto
            ORDER BY T02_DescDepartamento ASC;
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':descDpto' => "%$descDepartamento%"
        ]);

        // Convertir cada registro en un objeto Departamento
        while ($oDpto = $consulta->fetchObject()) {
            $aDepartamentos[] = new Departamento(
                $oDpto->T02_CodDepartamento,
                $oDpto->T02_DescDepartamento,
                $oDpto->T02_FechaCreacionDepartamento,
                $oDpto->T02_VolumenDeNegocio,
                $oDpto->T02_FechaBajaDepartamento
            );
        }

        return $aDepartamentos;
    }

    /**
     * Busca un departamento por su código
     * 
     * Realiza una búsqueda en la tabla T02_Departamento usando LIKE
     * para encontrar coincidencias parciales en el código del departamento.
     * Los resultados se ordenan alfabéticamente por codigo de depatamento
     * 
     * @param string $codDepartamento Código del departamento a buscar
     * @return Departamento|null Objeto Departamento si se encuentra, null si no
     */
    public static function buscarDepartamentoPorCod($codDepartamento)
    {
        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE T02_CodDepartamento like :departamento
        SQL;

        $parametros = [
            ':departamento' => $codDepartamento
        ];

        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        // si se encuentra el  departamento en la base de datos, se crea el objeto departamento
        $oDepartamento = null;
        if ($DepartamentoBD = $consulta->fetchObject()) {
            $oDepartamento = new Departamento(
                $DepartamentoBD->T02_CodDepartamento,
                $DepartamentoBD->T02_DescDepartamento,
                $DepartamentoBD->T02_FechaCreacionDepartamento,
                $DepartamentoBD->T02_VolumenDeNegocio,
                $DepartamentoBD->T02_FechaBajaDepartamento
            );
        }

        return $oDepartamento;
    }

    /**
     * Modifica la descripción y volumen de negocio de un departamento existente
     * * @param Departamento $oDepartamento Objeto del departamento a modificar
     * @param string $descDepartamentoNueva Nueva descripción
     * @param float|string $volumenDeNegocioNuevo Nuevo volumen (con punto decimal)
     * @return Departamento|null El objeto actualizado o null si falla
     */
    public static function modificarDepartamento($oDepartamento, $descDepartamentoNueva, $volumenDeNegocioNuevo)
    {
        $sql = <<<SQL
        UPDATE T02_Departamento SET 
            T02_DescDepartamento = :nuevoDescDepartamento,
            T02_VolumenDeNegocio = :nuevoVolumenDeNegocio
        WHERE T02_CodDepartamento = :codDepartamento
    SQL;

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':nuevoDescDepartamento' => $descDepartamentoNueva,
                ':nuevoVolumenDeNegocio' => $volumenDeNegocioNuevo, // Aquí debe llegar con PUNTO
                ':codDepartamento' => $oDepartamento->getCodDepartamento()
            ]);

            if ($consulta) {
                // Actualizamos el estado interno del objeto
                $oDepartamento->setDescDepartamento($descDepartamentoNueva);
                $oDepartamento->setVolumenDeNegocio($volumenDeNegocioNuevo);
                return $oDepartamento;
            }
        } catch (Exception $e) {
            // Registro del error para trazabilidad y cumplimiento OWASP A09
            error_log("Error al modificar departamento [" . $oDepartamento->getCodDepartamento() . "]: " . $e->getMessage());
            return null;
        }

        return null;
    }

    /**
     * Da de alta un nuevo departamento en la base de datos
     * 
     * @param string $codDepartamento Código del nuevo departamento
     * @param string $descDepartamento Descripción del nuevo departamento
     * @param float $volumenDeNegocio Volumen de negocio del nuevo departamento
     * @return Departamento|null El objeto departamento creado o null si falla
     */
    public static function altaDepartamento($codDepartamento, $descDepartamento, $volumenDeNegocio)
    {
        $oFechaActual = new DateTime();
        $sql = <<<SQL
            INSERT INTO T02_Departamento (
                T02_CodDepartamento,
                T02_DescDepartamento,
                T02_FechaCreacionDepartamento,
                T02_VolumenDeNegocio
            ) VALUES (
                :codDepartamento,
                :descDepartamento,
                :fechaCreacionDepartamento,
                :volumenDeNegocio
            )
        SQL;
        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codDepartamento' => $codDepartamento,
                ':descDepartamento' => $descDepartamento,
                //es mejor guardar la fecha aquí(que en el insett) que en para evitar que esten desincronizadas
                ':fechaCreacionDepartamento' => $oFechaActual->format('Y-m-d H:i:s'),
                ':volumenDeNegocio' => $volumenDeNegocio
            ]);

            if ($consulta) {


                $oDepartamento = new Departamento(
                    $codDepartamento,
                    $descDepartamento,
                    $oFechaActual,
                    $volumenDeNegocio,
                    null
                );
                return $oDepartamento;
            }
        } catch (Exception $e) {
            //REgistro del error, para prevenir el OWASP A9
            error_log("Error al dar de alta el departamento: " . $e->getMessage());
            return null;
        }
        return null;
    }

    /**
     * Comprueba si un código de departamento ya existe en la BD
     * @param string $codDepartamento
     * @return boolean true si existe, false si no
     */
    public static function validarCodDepartamentoExiste($codDepartamento)
    {
        $existe = false;
        // Seleccionamos el campo del código del departamento
        $sql = "SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";

        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codDepartamento' => $codDepartamento
            ]);

            // Intentamos obtener la fila. Si fetch() devuelve algo, es que existe.
            if ($consulta->fetch()) {
                $existe = true;
            }
        } catch (Exception $e) {
            // Registro del error para cumpli con OWASP A09
            error_log("Error en validarCodDepartamentoExiste: " . $e->getMessage());
            // En caso de error de DB, se pasa a "existe" para bloquear el alta por seguridad
            return true;
        }

        return $existe;
    }

    /**
     * Borra un departamento de la base de datos
     * 
     * @param Departamento $oDepartamento Objeto del departamento a borrar
     * @return boolean true si se borra correctamente, false si falla
     */
    public static function borrarDepartamento($oDepartamento)
    {
        $sql = <<<SQL
            DELETE FROM T02_Departamento
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;
        try {
            $consulta = DBPDO::ejecutarConsulta($sql, [
                ':codDepartamento' => $oDepartamento->getCodDepartamento()
            ]);
            //rowCount() para ver si se borro la fila
            if ($consulta->rowCount() > 0) {
                // REGISTRO  (OWASP A09)
                // Obtenemos el usuario de la sesión para identidficar el usaurio que ha borrado el departamento
                $usuarioActivo = $_SESSION['usuarioVGDAWAplicacionFinal']->getCodUsuario();
                $codDpto = $oDepartamento->getCodDepartamento();
                //se recoge el fecha y la hora del borrado
                $oFechaHora = new DateTime();
                $fechaHoraFormateada = $oFechaHora->format('d-m-Y H:i:s');
                //se recoge el mensage de log infomrando de quien y cuando se ha borrado el departamento
                error_log("[AUDITORÍA] [$fechaHoraFormateada] El usuario '$usuarioActivo' ha BORRADO el departamento '$codDpto'.");
                return true;
            }
        } catch (Exception $e) {
            //se recoge el error de borrado fallido
            error_log("ERROR CRÍTICO: Intento de borrado fallido del depto " . $oDepartamento->getCodDepartamento());
            return false;
        }
        return false;
    }


    /**
     * Realiza una baja lógica de un departamento estableciendo la fecha de baja
     * 
     * @param Departamento $oDepartamento Objeto del departamento a dar de baja
     * @return Departamento|null El objeto departamento actualizado o null si falla
     */
    public static function bajaLogicaDepartamento($oDepartamento)
    {
        $oFechaActual = new DateTime();
        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_FechaBajaDepartamento = :fechaBajaDepartamento
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':fechaBajaDepartamento' => $oFechaActual->format('Y-m-d H:i:s'),
            ':codDepartamento' => $oDepartamento->getCodDepartamento()
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            $oDepartamento->setFechaBajaDepartamento($oFechaActual);
            return $oDepartamento;
        }

        return null;
    }

    public static function rehabilitarDepartamento($codDepartamento)
    {
        // Ponemos la fecha a NULL para que el departamento vuelva a estar activo
        $sql = <<<SQL
        UPDATE T02_Departamento SET T02_FechaBajaDepartamento = NULL 
        WHERE T02_CodDepartamento = :codDepartamento
        SQL;
        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codDepartamento' => $codDepartamento
        ]);
        return $consulta->rowCount() > 0;
    }
}
