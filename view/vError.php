</header>
   <div class="error_container">
        <div class="error_code">
            <p id="pError1">5</p>
            <p id="pError2">0</p>
            <p id="pError3">0</p>
        </div>
        <div class="error_title">Upsss... Algo salió mal....</div>
        <div class="error_message">
            <p>Código de error: <?php echo $avError['codError']; ?></p>
            <p>Descripción: <?php echo $avError['descError']; ?></p>
            <p>Archivo: <?php echo $avError['archivoError']; ?></p>
            <p>Línea: <?php echo $avError['lineaError']; ?></p>
        </div>
        <form>
        <button class="botonCentral" type="submit" name="volver" id="volver">volver</button>
        </form>
         
    </div>