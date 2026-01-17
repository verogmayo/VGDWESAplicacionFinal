 <div class="tituloCentral">
     <p>REST</p>

 </div>
 <nav>
     <form class="botonesDetalles" action="">
         
         <div class="botonVolverLogin">
             <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
         </div>

         <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta">
             <?php echo $avRest['inicial']; ?>
         </button>

         <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sesión</button>
     </form>
 </nav>

 </header>

 <main>
     <section class="sectionDiv">
        <div class="wrapper">
            <div class="containerRest">
             <div class="tituloRest">
                <?php echo $avRest['fotoNasa']->getTitulo(); ?>
             </div>
             <div class="infoRest">
                <img src="<?php echo $avRest['fotoNasa']->getUrl(); ?>" alt="Foto de la NASA">
             </div>
         </div>
         <div class="containerRest">
             <div class="tituloRest">
                AEMET
             </div>
             <div class="infoRest">

             </div>
         </div>
         <div class="containerRest">
             <div class="tituloRest">
                DEPARTAMENTOS
             </div>
             <div class="infoRest">

             </div>
         </div>

        </div>
         
     </section>
 </main>