<div class="tituloCentralCuenta">
    <p>MANTENIMIENTO DE USUARIOS</p>
</div>
<form class="botonesDetalles">
    <div class="botonVolverLogin">
        <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avMtoUsuarios2['inicial']; ?></button>
    <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sessión</button>
</form>
</header>
<main>
    <?php if (isset($_SESSION['errorAltaUsuario'])): ?>
        <div class="errorAltaUsuarioDiv">
            <?php
            echo $_SESSION['errorAltaUsuario'];
            // Se borra para que no se repita
            unset($_SESSION['errorAltaUsuario']);
            ?>
        </div>
    <?php endif; ?>
    <section class="contenedorInputUsuario2">
        <div id="campoBuscarDiv">Descripción a buscar: </div>
        <input id="campoBuscar" name="campoBuscar" type="text">
    </section>
    <section class="sectionTablaUsuario">
        <div class="contenedorTablaUsuario">
            <table id="tablaUsuario">

            </table>

        </div>
    </section>
    <!-- ============== Div emergente para el cambio de contraseña ================ -->

    <div id="emergentePassword" class="emergente">
        <div class="emergente-contenido">
            <div class="emergente-cabecera">
                <h3>Cambiar Contraseña: <span id="spanCodUsuario"></span></h3>
                <span class="cerrar-emergente" onclick="cerrarEmergente()">&times;</span>
            </div>
            <div class="emergente-cuerpo">
                <input type="hidden" id="inputCodUsuarioNoVisible">

                <div class="input-grupo-emergente">
                    <label for="nuevoPass">Nueva Contraseña:</label>
                    <input type="password" id="nuevoPass" placeholder="Mínimo 4 caracteres">
                    <span id="errPass" class="error-emergente"></span>
                </div>

                <div class="input-grupo-emergente">
                    <label for="confirmaPass">Confirmar Contraseña:</label>
                    <input type="password" id="confirmaPass" placeholder="Repite la contraseña">
                    <span id="errConfirma" class="error-emergente"></span>
                </div>

                <div id="msjGeneralEmergente" class="msj-general-emergente"></div>
            </div>
            <div class="emergente-pie">
                <button class="botonSessionEmergente" onclick="enviarCambioPassword()">Guardar Cambios</button>
                <button class="botonAzul" onclick="cerrarEmergente()">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- ============== Div emergente para borrar usaurio ================ -->
    <div id="emergenteBorrar" class="emergente">
        <div class="emergente-contenido">
            <div class="emergente-cabecera">
                <h3 style="color: #d9534f;">Confirmar Eliminación</h3>
                <span class="cerrar-emergente" onclick="cerrarDivBorrar()">&times;</span>
            </div>
            <div class="emergente-cuerpo">
                <input type="hidden" id="inputCodUsuarioBorrar">
                <p>¿Estás seguro de que deseas eliminar al usuario <strong id="strongCodUsuario"></strong>?</p>
                <p style="font-size: 0.85em; color: #666;">Esta acción no se puede deshacer.</p>
            </div>
            <div class="emergente-pie">
                <button class="botonSessionEmergente" onclick="confirmarEliminar()">Eliminar Definitivamente</button>
                <button class="botonAzul" onclick="cerrarDivBorrar()">Cancelar</button>
            </div>
        </div>
    </div>
    <!-- ============== Div Emergente para el cambio de perfil ================ -->
    <div id="emergentePerfil" class="emergente">
        <div class="emergente-contenido">
            <h3>Cambiar Perfil de Usuario</h3>
            <p id="mensajeCambioPerfil"></p>
            <input type="hidden" id="idUsuarioPerfil">
            <input type="hidden" id="nuevoPerfilValor">
            <div class="emergente-pie">
                <button onclick="confirmarCambioPerfil()" class="botonSessionEmergente">Sí, cambiar</button>
                <button onclick="cerrarDivPerfil()" class="botonAzul">Cancelar</button>
            </div>
        </div>
    </div>

</main>
<script>
    function mostrarUsuario(usuarios) {
        var tabla = document.getElementById("tablaUsuario");

        tabla.innerHTML = `
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Nº Accesos</th>
                <th>Fecha Última Conexión</th>
                <th>Perfil</th>
                <th colspan="4">Acción</th>
            </tr>
        </thead>
        <tbody></tbody>
    `;
        var tbody = tabla.querySelector("tbody");
        usuarios.forEach(usuario => {
            var fila = document.createElement("tr");

            var td1 = document.createElement("td");
            td1.textContent = usuario.codUsuario;
            fila.appendChild(td1);

            var td2 = document.createElement("td");
            td2.textContent = usuario.descUsuario;
            fila.appendChild(td2);

            var td3 = document.createElement("td");
            td3.textContent = usuario.numAccesos;
            fila.appendChild(td3);

            var td4 = document.createElement("td");

            var fechaFormateada = "";
            if (usuario.fechaUltimaConexion) {
                let partes = usuario.fechaUltimaConexion.split(" ");
                //https://www.freecodecamp.org/espanol/news/como-formatear-fechas-en-javascript-con-una-linea-de-codigo/
                // "01/02/2026 13:30:57". Se coge por separado el día el mes u el año
                let fechaParte = partes[0].split("/");

                let dia = fechaParte[0];
                let mes = fechaParte[1] - 1; //en js el mes empieza en 0
                let anio = fechaParte[2];

                let fecha = new Date(anio, mes, dia);
                if (!isNaN(fecha.getTime())) {
                    fechaFormateada = fecha.toLocaleDateString('es-ES', {
                        day: '2-digit',
                        month: '2-digit',
                        year: '2-digit'
                    });
                }
            }
            console.log("Fecha original:", usuario.fechaUltimaConexion);

            console.log("está es la fecha formateada" + fechaFormateada);
            td4.textContent = fechaFormateada;
            fila.appendChild(td4);

            var td5 = document.createElement("td");
            // SE crea unspan para que el cursor cambie al pasar ¡por encima
            var spanPerfil = document.createElement("span");
            spanPerfil.textContent = usuario.perfil;

            // Se añade el pointer
            spanPerfil.style.cursor = "pointer";
            spanPerfil.style.color = "#3498db"; 
            // spanPerfil.style.textDecoration = "underline";

            // se añade la funcion para abrirl el div
            spanPerfil.onclick = function() {
                // se abre el div emergente
                abrirDivPerfil(usuario.codUsuario, usuario.perfil);
            };

            td5.appendChild(spanPerfil);
            fila.appendChild(td5);

            /*botón de cambiar contraseña */
            var td6 = document.createElement("td");
            var btnPassword = document.createElement("button");
            btnPassword.innerHTML = '<i class="fa-solid fa-key"></i>';
            //menasje informativo
            btnPassword.title = "Cambiar contraseña del usuario " + usuario.codUsuario;
            btnPassword.onclick = () => abrirEmergentePassword(usuario.codUsuario);
            td6.appendChild(btnPassword);
            fila.appendChild(td6);

            // Botón Eliminar ususrio
            var td7 = document.createElement("td");
            var btnEliminar = document.createElement("button");
            btnEliminar.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
            btnEliminar.onclick = () => eliminarUsuario(usuario.codUsuario);
            td7.appendChild(btnEliminar);
            fila.appendChild(td7);

            tbody.appendChild(fila);

        });
    }


    //var urlApi = "http://daw204.local.ieslossauces.es/VGDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";
    var urlApi = "https://192.168.0.22/VGDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";
    // var urlApi = "https://veroniquegru.ieslossauces.es/VGDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";
    fetch(urlApi)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            mostrarUsuario(data);
        })
        .catch(error => console.error("Error:", error));


    var campoBuscar = document.getElementById("campoBuscar");

    campoBuscar.addEventListener("input", () => {

        fetch(urlApi + "?descUsuario=" + campoBuscar.value)
            .then(response => response.json())
            .then(data => {
                mostrarUsuario(data);
            })
            .catch(error => console.error("Error:", error));
    });
</script>