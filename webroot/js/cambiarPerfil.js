// Función para abrir el div de cambio de perfil
function abrirDivPerfil(codUsuario, perfilActual) {
    const divPerfil = document.getElementById('emergentePerfil');
    const mensaje = document.getElementById('mensajeCambioPerfil');
    const inputCod = document.getElementById('idUsuarioPerfil');
    const inputNuevo = document.getElementById('nuevoPerfilValor');

    // Se determina el cambio opuesto
    const nuevoPerfil = (perfilActual === 'usuario') ? 'administrador' : 'usuario';
    
    inputCod.value = codUsuario;
    inputNuevo.value = nuevoPerfil;
    mensaje.innerText = `El usuario es "${perfilActual}". ¿Deseas cambiarlo a "${nuevoPerfil}"?`;
    
    divPerfil.style.display = 'block';
}

// Función para cerrar el div
function cerrarDivPerfil() {
    document.getElementById('emergentePerfil').style.display = 'none';
}

// Función que conecta con el Web Service
function confirmarCambioPerfil() {
    const codUsuario = document.getElementById('idUsuarioPerfil').value;
    const nuevoPerfil = document.getElementById('nuevoPerfilValor').value;

    fetch(`api/wsCambiarPerfil.php?codUsuario=${codUsuario}&perfil=${nuevoPerfil}`)
        .then(response => response.json())
        .then(data => {
            if (data.respuesta === 'ok') {
                cerrarDivPerfil();
                location.reload(); // se recarga la pagina para ver el cambio
            } else {
                alert("Error: " + data.msj);
            }
        })
        .catch(error => console.error('Error:', error));
}