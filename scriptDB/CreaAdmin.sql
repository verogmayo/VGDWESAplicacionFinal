INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_Perfil,T01_ImagenUsuario)
                VALUES
            ('admin',SHA2('adminpaso',256),'Administrador','administrador',null);

            ALTER TABLE T02_Departamento 
MODIFY T02_VolumenDeNegocio DECIMAL(65,2);