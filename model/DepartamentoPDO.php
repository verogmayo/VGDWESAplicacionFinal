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

class DepartamentoPDO {
    
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
    public static function buscarDepartamentoPorDesc($descDepartamento = null) {
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
     public static function buscarDepartamentoPorCod($codDepartamento){
        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE T02_CodDepartamento like :departamento
        SQL;
        
        $parametros = [
            ':departamento' => $codDepartamento
        ];

        $consulta = DBPDO::ejecutarConsulta($sql,$parametros);

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
     * 
     * @param Departamento $oDepartamento Objeto del departamento a modificar
     * @param string $descDepartamentoNueva Nueva descripción del departamento
     * @param float $volumenDeNegocioNuevo Nuevo volumen de negocio del departamento
     * @return Departamento|null El objeto departamento actualizado o null si falla
     */
    public static function modificarDepartamento($oDepartamento, $descDepartamentoNueva, $volumenDeNegocioNuevo){
        $sql = <<<SQL
            UPDATE T02_Departamento SET 
                T02_DescDepartamento = :nuevoDescDepartamento,
                T02_VolumenDeNegocio = :nuevoVolumenDeNegocio
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $parametros = [
            ':nuevoDescDepartamento' => $descDepartamentoNueva,
            ':nuevoVolumenDeNegocio' => $volumenDeNegocioNuevo,
            ':codDepartamento' => $oDepartamento->getCodDepartamento()
        ];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        if ($consulta) {
            $oDepartamento->setDescDepartamento($descDepartamentoNueva);
            $oDepartamento->setVolumenDeNegocio($volumenDeNegocioNuevo);
            return $oDepartamento;
        }

        return null;
    }

    public static
}
?>