USE DBVGDWESAplicacionFinal;

INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_ImagenUsuario)
                VALUES
            ('admin',SHA2('adminpaso',256),'Administrador','administrador'),   
            ('vero',SHA2('veropaso',256),'Véro Grué',null),
            ('heraclio',SHA2('heracliopaso',256),'Heraclio Borbujo',null),
            ('alvaroA',SHA2('alvaroApaso',256),'Alvaro Allen',null),
            ('alejandro',SHA2('alejandropaso',256),'Alejandro De La Huerga',null),
            ('alvaroG',SHA2('alvaroGpaso',256),'Alvaro García',null),
            ('gonzalo',SHA2('gonzalopaso',256),'Gonzalo Junquera',null),
            ('cristian',SHA2('cristianpaso',256),'Cristian Mateos',null),
            ('alberto',SHA2('albertopaso',256),'Alberto Méndez',null),
            ('enrique',SHA2('enriquepaso',256),'Enrique Nieto',null),
            ('james',SHA2('jamespaso',256),'James Edward Nuñez',null),
            ('oscar',SHA2('oscarpaso',256),'Oscar Pozuelo',null),
            ('jesus',SHA2('jesuspaso',256),'Enrique Nieto',null),
            ('amor',SHA2('amorpaso',256),'Amor Rodriguez',null),
            ('albertoB',SHA2('albertoBpaso',256),'Alberto Bahillo',null),
            ('antonio',SHA2('antoniopaso',256),'Antonio Jañez',null),
            ('jorge',SHA2('jorgepaso',256),'Jorge Corral',null),
            ('claudio',SHA2('claudiopaso',256),'Claudio Lozano',null),
            ('gisela',SHA2('giselapaso',256),'Gisela Folgueral',null),
            ('noita',SHA2('noitapaso',256),'Noa',null)
;
            



INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento)
                 VALUES 
            ('INF','informática',now(),1285.50,NULL),
            ('LEN','Lengua',now(),2285.50,NULL),
            ('MAT','Matemáticas',now(),3285.50,'2025-05-25'),
            ('ING','Inglès',now(),2285.50,NULL),
            ('FIS','Física',now(),2285.50,NULL);

