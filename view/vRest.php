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
                             <button id="botonSessionRest2" class="" type="submit" name="detallesNasa">Detalle</button>
                         <?php else: ?>
                             <button id="botonSessionRest2" style="pointer-events: none; background:gray" type="submit" name="detallesNasa">Detalle</button>
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
                         <p>Gracias a la extensíon curl de php, se envía la petición a la nasa, que responde enviando un json que hay que pasar a un array para poder usar la información </p>
                     </div>
                 </div>
             </div>
             <div class="containerRest">
                 <div class="contenedorInputRest">
                     <form method="post" id="libro" name="libro">
                         <input type="text" name="tituloLibro" id="tituloLibro" placeholder="Titulo" value="<?php echo $avRest['busquedaLibro']; ?>">
                         <button id="botonSessionRest3" class="" type="submit" name="enviarLibro">Enviar</button>
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
                 <div class="infoRestUso">
                     <h4>Paso a Paso del Uso de la Api</h4>
                     <p>Se forma la url para solicitar el libro, con la url, y el título($titulo) y con limite 1, para que en este caso solo salga un libro solo por petición <span style="font-weight:bold">https://openlibrary.org/search.json?title=$tituloUrl&limit=1</span> </p>
                     <p>Se envía la petición la api de Open Library con <span style="font-weight:bold">@file_get_contents</span>, que responde enviando un json con los datos del libro. </p>
                 </div>

             </div>
             <div class="containerRest">
                 <div class="contenedorInputRest">
                     <form method="post" id="formVolumen">
                         <input type="text" id="codDptoApi" name="codDepartamento" placeholder="Cód Dpto" maxlength="3" style="text-transform: uppercase;" value="<?php echo $avRest['busquedaDpto']; ?>"">
                         <button id="botonSessionRest4" type="submit" name="enviarVolumen">Consultar</button>
                     </form>
                 </div>
                 <div class="tituloRest">
                     Volumen de Negocio
                 </div>
                 <div class="infoRest3" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100px;">
                     <?php if ($avRest['volumenNegocio'] !== null): ?>
                         <p style="font-size: 0.9em;">El volumen de negocio es:</p>
                         <h2 style="color: #2ecc71;"><?php echo number_format((float)$avRest['volumenNegocio'], 2, ',', '.') . " €"; ?> </h2>
                     <?php elseif ($avRest['errorVolumen']): ?>
                         <p style="color: #e74c3c; font-weight: bold;"><?php echo $avRest['errorVolumen']; ?></p>
                     <?php else: ?>
                         <p style="color: #7f8c8d;">Introduce un código de departamento de 3 letras.</p>
                     <?php endif; ?>
                 </div>
                 <div class="infoRestUso">
                     <h4>Paso a Paso del Uso de la propia</h4>
                     <p>Se forma la url de la api propia para solicitar el volumen de negocio, con la url, codigo de departamento ($codDepartamento) <span style="font-weight:bold">http://veroniquegru.ieslossauces.es/ <br> VGDWESAplicacionFinal/api/ <br> wsVerVolNegocioDpto.php?codDepartamento=" . $codDepartamento;</span> </p>
                     <p>Se envía la petición la api propia con <span style="font-weight:bold">@file_get_contents</span>, que responde enviando un json con el volumen del departamento. </p>
                 </div>
             </div>

         </div>

     </section>
 </main>