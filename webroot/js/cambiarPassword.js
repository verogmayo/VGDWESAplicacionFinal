const urlPassword = "https://192.168.0.22/VGDWESAplicacionFinal/api/wsCambiarPassword.php";

// Función que se llama desde el botón "llave", cambiar contraseña de la tabla
function abrirEmergentePassword(codUsuario) {
    document.getElementById("spanCodUsuario").innerText = codUsuario;
    document.getElementById("inputCodUsuarioNoVisible").value = codUsuario;

    // Limpiar campos y errores anteriores
    document.getElementById("nuevoPass").value = "";
    document.getElementById("confirmaPass").value = "";
    document.getElementById("errPass").innerText = "";
    document.getElementById("errConfirma").innerText = "";

    document.getElementById("emergentePassword").style.display = "block";
}

function cerrarEmergente() {
    document.getElementById("emergentePassword").style.display = "none";
}

function enviarCambioPassword() {
    const codUsuario = document.getElementById("inputCodUsuarioNoVisible").value;
    const nuevoPsswd = document.getElementById("nuevoPass").value;
    const confirmaPsswd = document.getElementById("confirmaPass").value;

    // Ruta a la API
    // Usando concatenación con +
    // const url = "api/wsCambiarPassword.php?codUsuario=" + codUsuario + "&password=" + nuevoPsswd + "&confirmaPassword=" + confirmaPsswd;
    //Usando plantillas de cadenas
    //https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Template_literals
    //https://www.w3schools.com/js/js_string_templates.
    //https://es.javascript.info/string
    const urlApiPropiaCambiarPass=`https://veroniquegru.ieslossauces.es/VGDWESAplicacionFinal/api/wsCambiarPassword.php?codUsuario=${codUsuario}&password=${nuevoPsswd}&confirmaPassword=${confirmaPsswd}`;
    //const url = `api/wsCambiarPassword.php?codUsuario=${codUsuario}&password=${nuevoPsswd}&confirmaPassword=${confirmaPsswd}`;
    
    fetch(urlApiPropiaCambiarPass)
        .then(response => response.json())
        .then(data => {
            if (data.estadoCambiarPswd === 'exito') {
                //Siu ha salido todo bien aparece el console.alert con el mensaje de exito
                alert(data.msj);
                cerrarEmergente();
            } else {
                // Mensajes de error de validación de la contraseña
                document.getElementById("errPass").innerText = data.errores.password || "";
                //Mensaje de error de contraseña diferentes
                document.getElementById("errConfirma").innerText = data.errores.confirmaPassword || "";

                if (!data.errores.password && !data.errores.confirmaPassword) {
                    alert(data.msj); // Por si es un error técnico
                }
            }
        })
        .catch(error => console.error("Error:", error));
}