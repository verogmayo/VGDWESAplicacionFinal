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
                 <div class="contenedorInputRest">
                     <form method="post" id="nasa" name="nasa">
                         <input type="date" name="fechaNasa" id="fechaNasa" value="<?php echo $avRest['fechaNasa'] ?>" max="<?php echo $avRest['fechaHoy'] ?>">
                         <button id="botonSessionRest" class="" type="submit" name="enviarNasa">Enviar</button>
                         <?php echo ($avRest['errorNasa']) ? "<span style='color:red'>".$avRest['errorNasa']."</span>" : ""; ?>
                         <button id="botonSessionRest" class="" type="submit" name="detallesNasa">Detalle</button>
                     </form>
                 </div>
                 <div class="tituloRest">
                     <?php echo $avRest['tituloNasa']; ?>
                 </div>
                 <div class="infoRest">
                     <img src="<?php echo $avRest['fotoNasa']; ?>">
                 </div>
             </div>
             <div class="containerRest">
                <div class="contenedorInputRest">
                    
                     <form method="post" id="libro" name="libro">
                         <input type="text" name="tituloLibro" id="tituloLibro" value="" >
                         <button id="botonSessionRest" class="" type="submit" name="enviarLibro">Enviar</button>
                         <?php echo ($avRest['errorLibro']) ? "<span style='color:red'>".$avRest['errorLibro']."</span>" : ""; ?>
                     </form>
                 </div>
                 <div class="tituloRest">
                     <p>Busca un libro: </p>
                 </div>
                 <div class="infoRest2">
                     <img src="<?php echo $avRest['portadaLibro']; ?>" alt="Portada" style="box-shadow: 2px 2px 10px rgba(0,0,0,0.3);">
                     <h3><?php echo $avRest['tituloLibro']; ?></h3>
                     <p><strong>Autor:</strong> <?php echo $avRest['autorLibro']; ?></p>
                     <p><strong>Año de publicaión:</strong> <?php echo $avRest['anioPublicacion']; ?></p>

                 </div>
             </div>
             <div class="containerRest">
                 <div class="tituloRest">
                     DEPARTAMENTOS
                 </div>
                 <div class="infoRest3">
                     
                 </div>
             </div>

         </div>

     </section>
 </main>