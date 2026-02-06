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
        <div id="campoBuscarDiv">Descripción: </div>
        <input id="campoBuscar" name="campoBuscar" type="text">
    </section>
    <section class="">
        <div class="contenedorTablaUsuario">
            <table id="tablaUsuario">

            </table>

        </div>
    </section>
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
            if (usuarios[i].fechaHoraUltimaConexion !== null) {
                // Si la fecha no es null se formatea
                var fecha = new Date(usuarios[i].fechaHoraUltimaConexion);
                var dia = String(fecha.getDate()).padStart(2, '0');
                var m = String(fecha.getMonth() + 1).padStart(2, '0');
                var a = String(fecha.getFullYear());

                var fechaFormateada = `${dia}-${mes}-${anio}`;
            } else {
                // En caso de que sea nula dejamos vacia la celda.
                var fechaFormateada = "";
            }

            // fechaFormateada = 
            td4.textContent = fechaFormateada;
            fila.appendChild(td4);

            var td5 = document.createElement("td");
            td5.textContent = usuario.perfil;
            fila.appendChild(td5);

            var td6 = document.createElement("td");
            td6.innerHTML = '<i class="fa-solid fa-eye"></i>';
            fila.appendChild(td6);

            var td7 = document.createElement("td");
            td7.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
            fila.appendChild(td7);

            tbody.appendChild(fila);

        });
    }


    var urlApi = "http://daw204.local.ieslossauces.es/VGDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";

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