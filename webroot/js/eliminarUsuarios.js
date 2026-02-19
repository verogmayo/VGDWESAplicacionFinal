const urlEliminar = "https://192.168.0.22/VGDWESAplicacionFinal/api/wsEliminarUsuario.php";
// Muestra el div emergente
function eliminarUsuario(codUsuario) {
    // Rellenamos los datos en el div
    document.getElementById("inputCodUsuarioBorrar").value = codUsuario;
    document.getElementById("strongCodUsuario").innerText = codUsuario;
    
    // Mostramos el modal
    document.getElementById("emergenteBorrar").style.display = "block";
}

// Función para cerrar el div
function cerrarDivBorrar() {
    document.getElementById("emergenteBorrar").style.display = "none";
}



async function confirmarEliminar() {
    // Se obtiene el código del input oculto del div
    const codUsuario = document.getElementById("inputCodUsuarioBorrar").value;
    
    try {
        // SE define la url de la api de eliminar usuario
        const url = `api/wsEliminarUsuario.php?codUsuario=${codUsuario}`;

        const respuesta = await fetch(url);

        // Se lee el json
        const datosJSON = await respuesta.json();

        // Se comprueba el estado y si es exito...
        if (datosJSON.estadoRespuestaEliminar === 'exito') {
            // se cierra y  se recarga
            cerrarDivBorrar();
            location.reload(); 
        } else {
            // Sino sale el error
            alert("Error: " + datosJSON.msj);
            
        }

    } catch (error) {
        // Si entra aquí, es que el JSON está mal
        console.error("Error técnico:", error);
        
    }
}