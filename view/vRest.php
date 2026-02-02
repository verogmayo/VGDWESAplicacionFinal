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
                         <?php echo ($avRest['errorNasa']) ? "<span style='color:red'>" . $avRest['errorNasa'] . "</span>" : ""; ?>
                         <?php if (!empty($avRest['fotoSerializada'])): ?>
                             <button id="botonSessionRest" class="" type="submit" name="detallesNasa">Detalle</button>
                         <?php else: ?>
                             <button id="botonSessionRest" style="pointer-events: none; background:gray" type="submit" name="detallesNasa">Detalle</button>
                         <?php endif; ?>
                         
                     </form>
                 </div>
                 <div class="tituloRest">
                     <?php echo $avRest['tituloNasa']; ?>
                 </div>
                 <div class="infoRest">
                     <div class="imagenNasa">
                         <?php if (!empty($avRest['fotoSerializada'])): ?>
                             <img src="<?php echo $avRest['fotoSerializada']; ?>" alt="Foto NASA">
                         <?php else: ?>
                             <p style="color:orange; margin-top:20px;margin-bottom:20px;"> <?php echo $avRest['errorNasa'] ?? "No hay imagen disponible para esta fecha."; ?></p>
                         <?php endif; ?>
                     </div>
                     <div class="infoRestUso">
                         <h4>Paso a Paso del Uso de la Api</h4>

                         <p>Se solicita la <span style="font-weight:bold">apiKey</span> en el enlace de la <a href="https://api.nasa.gov/" target="_blank">Nasa</a></p>
                         <p>Se forma la url para solicitar la foto del día, con la url, la fecha($fecha) y la apiKey <span style="font-weight:bold">https://api.nasa.gov/planetary/apod?api_key=APINASA&date=$fecha</span> </p>
                         <p>Gracias a la extensíon curl de php, se envía la petición a la nasa, que responde enviando un json que hay que pasar a array para poder usar la información </p>
                     </div>
                 </div>
             </div>
             <div class="containerRest">
                 <div class="contenedorInputRest">
                     <form method="post" id="libro" name="libro">
                         <input type="text" name="tituloLibro" id="tituloLibro" value="">
                         <button id="botonSessionRest" class="" type="submit" name="enviarLibro">Enviar</button>
                         <?php echo ($avRest['errorLibro']) ? "<span style='color:red'>" . $avRest['errorLibro'] . "</span>" : ""; ?>
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