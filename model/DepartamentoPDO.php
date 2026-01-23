<?php
/**
 * @author: Véro Grué
 * @since: 23/01/2026
 */
require_once 'DBPDO.php';
require_once 'Departamento.php';
class DepartamentoPDO{
    

   public static function buscarDepartamentoPorDesc($codDepartamento){
      $sql = <<<SQL
            SELECT *
            FROM T02_Departamento
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':descDepartamento' => $codDepartamento       
             ]);

         $departamentoDB = $consulta->fetchObject();
         //Se convierte la fecha en datetime
            $fechaAlta = $departamentoDB['T02_FechaCreacionDepartamento'];
            $oFechaValida = ($fechaAlta) ? new DateTime($fechaAlta) : null;
            // Crear el objeto Usuario con los datos de la BD

            $oDepartamento = new Departamento(
                $departamentoDB['T02_CodDepartamento'],
                $departamentoDB['T02_descDepartamento'],
                $departamentoDB['T02_FechaCreacionDepartamento'],
                $departamentoDB['T02_VolumenDeNegocio'],
                $departamentoDB
            )

   }
}



?>