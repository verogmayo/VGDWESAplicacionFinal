<!-- <div class="header"> -->
    <div class="tituloCentral">
        <p>INICIO PÚBLICO</p>
    </div>

    <nav>
        <form method="post">
            <!-- Botones de idiomas -->
            <!-- Si no se ha iniciado cession o si se hace clic en el boton de español, el icono de la bandera de españa se hace mas grande-->
            <button class="idioma <?php echo (!isset($_COOKIE['idioma']) || $_COOKIE['idioma'] == 'es') ? 'seleccionado' : ''; ?>"
                type="submit" name="idioma" id="es" value="es"> <img src="webroot/images/banderaEs.png" width="20" alt="es" /> </button>
            <!-- Si se hace clic en el icono de la bandera de GB, el icono se hace mas grande-->
            <button class="idioma <?php echo (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == 'en') ? 'seleccionado' : ''; ?>"
                type="submit" name="idioma" id="en" value="en"> <img src="webroot/images/banderaGb.png" width="20" alt="en" /> </button>
            <!-- Si se hace clic en el icono de la bandera de Francia, el icono se hace mas grande-->
            <button class="idioma <?php echo (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == 'fr') ? 'seleccionado' : ''; ?>"
                type="submit" name="idioma" id="fr" value="fr"> <img src="webroot/images/banderaFr.png" width="20" alt="fr" /> </button>
            <!-- Botón de login -->
            <button class="botonSession" type="submit" name="login" id="login">login</button>
        </form>
    </nav>
    
<!-- </div> -->
</header>

<main>
    <section class="seccionCarrusel">
    <div class="carrusel-contenedor">
        <input type="radio" name="rd" id="rd1" checked>
        <input type="radio" name="rd" id="rd2">
        <input type="radio" name="rd" id="rd3">
        <input type="radio" name="rd" id="rd4">
        <input type="radio" name="rd" id="rd5">

        <div class="photos">
            <img src="webroot/images/ArbolNavegacion.png" alt="App Multicapa">
            <img src="webroot/images/RelacionFicherosAppFinal.png" alt="Relación Ficheros">
            <img src="webroot/images/RelacionFicherosAppFinal2.png" alt="Relación Ficheros">
            <img src="webroot/images/DiagramaClasesAppFinal.png" alt="Diagrama de Clases">
            <img src="webroot/images/UsoSessionAppFinal.png" alt="UsoSession">
        </div>
    </div>
</section>
</main>