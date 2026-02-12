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
  <section class="carruselInfinito">
    <div class="listadoImagenes">

      <!-- Primeros ficheros -->
      <a href="webroot/doc/ArbolNavegacion.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_ArbolNavegacion.png" alt="Árbol Navegación">
        <span>Árbol Navegación</span>
      </a>

      <a href="webroot/doc/RelacionFicherosAppFinal.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_RelacionFicheros.png" alt="Relación Ficheros">
        <span>Relación Ficheros</span>
      </a>

      <a href="webroot/images/DiagramaClasesAppFinal4.png" target="_blank" class="item">
        <img src="webroot/images/mini_DiagramaClases.png" alt="Diagrama Clases">
        <span>Diagrama de Clases</span>
      </a>

      <a href="webroot/doc/UsoDeLaSessionAppFinal.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_Session.png" alt="Uso Session">
        <span>Uso de Session</span>
      </a>
      <a href="webroot/doc/CatalogoDeRequisitos.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_CatalogoReq.png" alt="Catalogo Requisitos">
        <span>Catalogo de Requisitos</span>
      </a>

      <a href="webroot/doc/DiagramaDeCasosDeUso.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_CasosUsos.png" alt="Casos Uso">
        <span>Diagrama de Casos de Uso</span>
      </a>
      <a href="webroot/doc/ModeloFisicoDeDatos.jpg" target="_blank" class="item">
        <img src="webroot/images/mini_ModeloFisico.png" alt="Modelo Fisico">
        <span>Modelo Fisico de Datos</span>
      </a>
      <a href="webroot/doc/EstructuraDeAlmacenamiento.pdf" target="_blank" class="item">
        <img src="webroot/images/EstructuraAlmacenamiento.png" alt="Modelo Fisico">
        <span>Estructura de Almacenamiento</span>
      </a>
      <!-- Ficheros Duplicados para efecto infinito -->
      <a href="webroot/doc/ArbolNavegacion.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_ArbolNavegacion.png" alt="Árbol Navegación">
        <span>Árbol Navegación</span>
      </a>

      <a href="webroot/doc/RelacionFicherosAppFinal.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_RelacionFicheros.png" alt="Relación Ficheros">
        <span>Relación Ficheros</span>
      </a>

      <a href="webroot/images/DiagramaClasesAppFinal4.png" target="_blank" class="item">
        <img src="webroot/images/mini_DiagramaClases.png" alt="Diagrama Clases">
        <span>Diagrama de Clases</span>
      </a>

      <a href="webroot/doc/UsoDeLaSessionAppFinal.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_Session.png" alt="Uso Session">
        <span>Uso de Session</span>
      </a>
      <a href="webroot/doc/CatalogoDeRequisitos.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_CatalogoReq.png" alt="Catalogo Requisitos">
        <span>Catalogo de Requisitos</span>
      </a>

      <a href="webroot/doc/DiagramaDeCasosDeUso.pdf" target="_blank" class="item">
        <img src="webroot/images/mini_CasosUsos.png" alt="Casos Uso">
        <span>Diagrama de Casos de Uso</span>
      </a>
      <a href="webroot/doc/ModeloFisicoDeDatos.jpg" target="_blank" class="item">
        <img src="webroot/images/mini_ModeloFisico.png" alt="Modelo Fisico">
        <span>Modelo Fisico de Datos</span>
      </a>
      <a href="webroot/doc/EstructuraDeAlmacenamiento.pdf" target="_blank" class="item">
        <img src="webroot/images/EstructuraAlmacenamiento.png" alt="Modelo Fisico">
        <span>Estructura de Almacenamiento</span>
      </a>
    </div>
  </section>
  <section>
    <div class="sopaLetras">
      <a href="../VGDWECProyectoDWEC/SopaLetras" target="_blank" id="EnlaceSopaLetras">Prueba nuestra sopa de letras</a>
    </div>
  </section>


</main>