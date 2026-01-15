# APLICACIÓN LOGIN LOGOFF

Desarrollo de una aplicación con control de acceso e identificación del usuario basado en un formulario (Login.php) con un botón de “Entrar” y en el uso de una
tabla “Usuario” de la base de datos (PDO). En el caso de que tecleemos un usuario y password correctos se abrirá otra página (Programa.php) donde tendremos un botón de “Salir” que nos
devolverá al Login.php (Funionalidad Logoff que nos redirige automáticamente a la página de autenticación).

- Control de acceso, identificación de usuario y estudio de las variables $_SERVER,$_COOKIE y $_SESSION.
Estudiar la configuración del php.ini relativa al manejo de estas variables.
Estudiar el comportamiento (Inicialización, Vida, Elementos que contiene, Borrado) de estas variables.
Estudiar el comportamiento y valor de la cookie en el lado cliente y en el lado servidor.
Estudiar la relación entre cookie y sesion. (SID y PHPSESSID)
Estudiar el comportamiento de estas variables cuanto nuestra aplicación tiene dos o más páginas web (Login.php y Programa.php, …). Dibujar el árbol de navegación.

- Control de acceso e identificación de usuario que nos informe de si es la primera vez que accedemos o la fecha y hora del último acceso. (Creación, uso, caducidad y destrucción de
una cookie).

- Control de acceso e identificación de usuario que nos informe de si es la primera vez que accedemos o la fecha y hora de los últimos accesos de la sesión correspondiente.
(Definición, manejo y destrucción de una sesión).

- Utilizar el contenido del campo Perfil de la tabla Usuario de la siguiente forma:
Los usuarios con perfil “Administrador” tendrán acceso a toda la funcionalidad del mantenimiento de departamentos.
Los usuarios con perfil “usuario” solo tendrán acceso a la funcionalidad de búsqueda y a la de consulta (detalle) de departamento. No podrán crear, modificar, borrar, importar ni exportar departamentos.