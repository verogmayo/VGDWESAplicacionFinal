USE DBVGDWESAplicacionFinal;

INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_Perfil,T01_ImagenUsuario)
                VALUES
            ('admin',SHA2('adminpaso',256),'Administrador','administrador',null),   
            ('vero',SHA2('veropaso',256),'Véro Grué','usuario',null),
            ('heraclio',SHA2('heracliopaso',256),'Heraclio Borbujo','usuario',null),
            ('alvaroA',SHA2('alvaroApaso',256),'Alvaro Allen','usuario',null),
            ('alejandro',SHA2('alejandropaso',256),'Alejandro De La Huerga','usuario',null),
            ('alvaroG',SHA2('alvaroGpaso',256),'Alvaro García','usuario',null),
            ('gonzalo',SHA2('gonzalopaso',256),'Gonzalo Junquera','usuario',null),
            ('cristian',SHA2('cristianpaso',256),'Cristian Mateos','usuario',null),
            ('alberto',SHA2('albertopaso',256),'Alberto Méndez','usuario',null),
            ('enrique',SHA2('enriquepaso',256),'Enrique Nieto','usuario',null),
            ('james',SHA2('jamespaso',256),'James Edward Nuñez','usuario',null),
            ('oscar',SHA2('oscarpaso',256),'Oscar Pozuelo','usuario',null),
            ('jesus',SHA2('jesuspaso',256),'Enrique Nieto','usuario',null),
            ('amor',SHA2('amorpaso',256),'Amor Rodriguez','usuario',null),
            ('albertoB',SHA2('albertoBpaso',256),'Alberto Bahillo','usuario',null),
            ('antonio',SHA2('antoniopaso',256),'Antonio Jañez','usuario',null),
            ('jorge',SHA2('jorgepaso',256),'Jorge Corral','usuario',null),
            ('claudio',SHA2('claudiopaso',256),'Claudio Lozano','usuario',null),
            ('gisela',SHA2('giselapaso',256),'Gisela Folgueral','usuario',null),
            ('noita',SHA2('noitapaso',256),'Noa','usuario',null)
;
            



INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento)
                 VALUES 
            ('INF','informática',now(),1285.50,NULL),
            ('LEN','Lengua',now(),2285.50,NULL),
            ('MAT','Matemáticas',now(),3285.50,'2025-05-25'),
            ('ING','Inglès',now(),2285.50,NULL),
            ('FIS','Física',now(),2285.50,NULL);

