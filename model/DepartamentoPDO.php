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
}
?>