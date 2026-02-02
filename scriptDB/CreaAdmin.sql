INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_Perfil,T01_ImagenUsuario)
                VALUES
            ('admin',SHA2('adminpaso',256),'Administrador','administrador',null);