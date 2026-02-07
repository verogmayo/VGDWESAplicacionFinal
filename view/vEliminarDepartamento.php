</header>
<main class="mainForm">
    <section class="formulario">
        <div class="imagen"><img src="webroot/images/logoV2.png" alt="logo" />
            <p class="pInicioSession">Eliminar Departamento en Aplicación Final</p>
        </div>
        <form class="form" action="index.php" method="post">

            <div class="contenedorInput">
                <div class="textoBorrarDpto">¿Estás seguro de que quieres borrar el departamento <span><?php echo $avEliminarDepartamento['dptoAEliminar'];?></span> 
                    Los datos se borrarán de forma permanente y no podrás recuperarlos.
                </div>
                <!-- Mensaje de error si no se pouede borrar el usuario -->
                <?php if (!empty($errorBorrar)): ?>
                    <div class="errorBorrar">
                        <p><?php echo $errorBorrar; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="divBotones">
                <button id="botonSessionLogin" class="botonSession" type="submit" name="eliminar">Eliminar</button>
                <div class="botonVolverLogin">
                    <button id="botonVolverLogin" class="botonAzul" type="submit" name="volver">Volver</button>
                </div>

            </div>
        </form>
    </section>
</main>