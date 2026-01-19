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
                form
                 <div class="tituloRest">
                     <?php echo $avRest['tituloNasa']; ?>
                 </div>
                 <div class="infoRest">
                     <img src="<?php echo $avRest['fotoNasa']; ?>">
                     <p class="explicacionNasa"><span>Explicación:</span> <?php echo $avRest['explicacionNasa']; ?></p>
                 </div>
             </div>
             <div class="containerRest">
                 <div class="tituloRest">
                     LIBRO DEL DÍA :
                 </div>
                 <div class="infoRest2">
                     <img src="<?php echo $avRest['libro']->getPortada(); ?>" alt="Portada" style="box-shadow: 2px 2px 10px rgba(0,0,0,0.3);">
                     <h3><?php echo $avRest['libro']->getTitulo(); ?></h3>
                     <p><strong>Autor:</strong> <?php echo $avRest['libro']->getAutor(); ?></p>
                     <p><strong>Nº de páginas:</strong> <?php echo $avRest['libro']->getPaginas(); ?></p>

                 </div>
             </div>
             <div class="containerRest">
                 <div class="tituloRest">
                     DEPARTAMENTOS
                 </div>
                 <div class="infoRest3">
                     <?php if (!empty($avRest['dptos'])): ?>
                         <table border="1" >
                             <tr>
                                 <th>Código</th>
                                 <th>Descripción</th>
                                 <th>Volumen</th>
                             </tr>
                             <?php foreach ($avRest['dptos'] as $dpto): ?>
                                 <tr>
                                     <td><?php echo $dpto->getCodDepartamento(); ?></td>
                                     <td><?php echo $dpto->getDescDepartamento(); ?></td>
                                     <td><?php echo number_format($dpto->getVolumenDeNegocio(), 2); ?> €</td>
                                 </tr>
                             <?php endforeach; ?>
                         </table>
                     <?php else: ?>
                         <p>No se han encontrado departamentos en WordPress.</p>
                     <?php endif; ?>
                 </div>
             </div>

         </div>

     </section>
 </main>