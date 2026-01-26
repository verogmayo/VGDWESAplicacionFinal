<?php
/**
 * @author: Véro Grué
 * @since: 23/01/2026
 */
require_once 'DBPDO.php';
require_once 'Departamento.php';
class DepartamentoPDO{
    

   public static function buscarDepartamentoPorDesc($descDepartamento=null){
    $aDepartamentos = [];
      $sql = <<<SQL
            SELECT *
            FROM T02_Departamento 
            WHERE T02_DescDepartamento LIKE :descDpto
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':descDpto' => "%$descDepartamento%"       
             ]);

       
         //Se convierte la fecha en datetime
            // $fechaAlta = $departamentoDB['T02_FechaCreacionDepartamento'];
            // $oFechaValida = ($fechaAlta) ? new DateTime($fechaAlta) : null;
            // Crear el objeto Usuario con los datos de la BD

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