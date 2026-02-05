<div class="tituloCentralCuenta">
    <p>MANTENIMIENTO DE USUARIOS</p>
</div>
<form class="botonesDetalles">
    <div class="botonVolverLogin">
        <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avMtoUsuarios2['inicial']; ?></button>
    <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sessión</button>
</form>
</header>
<main>
    <?php if (isset($_SESSION['errorAltaUsuario'])): ?>
        <div class="errorAltaUsuarioDiv">
            <?php
            echo $_SESSION['errorAltaUsuario'];
            // Se borra para que no se repita
            unset($_SESSION['errorAltaUsuario']);
            ?>
        </div>
    <?php endif; ?>
    <section class="contenedorInputUsuario">
      <div class="contenedorInputUsuarioDiv"></div>


    </section>
    <section class="">
        <div class="contenedorTabla">
            <table id="tablaDpto">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Nº Accesos</th>
                        <th>Fecha Ultima Conexión</th>
                        <th>Perfil</th>
                        <th colspan="4">Acción</th>

                    </tr>
                </thead>
                <tbody>
                  
                            <tr class="">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <form class="formDpto" method="post">
                                    <td class="iconosDpto">
                                        <button type="submit" name="consultar" value="" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="iconosDpto">
                                        <button type="submit" name="modificar" value="" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                    <td class="iconosDpto">
                                        <button type="submit" name="eliminar" value="" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>                                    
                                </form>
                            </tr>
                    
                        <tr>
                            <td colspan="9">No se han encontrado usuarios con esta descripción.</td>
                        </tr>
                    

                </tbody>
            </table>

        </div>
    </section>
</main>