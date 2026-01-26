<div class="tituloCentralCuenta">
    <p>MANTENIMIENTO DE DEPARTAMENTO</p>
</div>
<form class="botonesDetalles">
    <div class="botonVolverLogin">
        <button id="botonVolverDetalles" class="botonAzul" type="submit" name="volver">Volver</button>
    </div>
    <button id="botonCuenta" class="botonCuenta" type="submit" name="cuenta"><?php echo $avDepartamentos['inicial']; ?></button>
    <button id="botonSessionIPrivado" class="botonSession" type="submit" name="cerrar">Cerrar Sessión</button>
</form>
</header>
<main>

    <section class="contenedorInputDpto">
        <form id="buscarDpto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="descDepartamento">Descripción:</label>
            <a style='color:red'><?php echo $aErrores['descDepartamento'] ?></a><br>
            <input type="text" name="descDepartamento" id="descDepartamento" value="<?php echo $avDepartamentos['busqueda']; ?>">
            <button id="botonSessionIPrivado" class="botonSession" type="submit" name="buscar">Buscar</button>
        </form>
    </section>
    <section class="">
        <div class="contenedorTabla">
            <table id="tablaDpto">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Volumen</th>
                        <th>Fecha de baja</th>
                        <th>Ver</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($avDepartamentos['dptos']) > 0): ?>
                        <?php foreach ($avDepartamentos['dptos'] as $dpto) { ?>
                            <tr>
                                <td><?php echo $dpto['codDepartamento']; ?></td>
                                <td><?php echo $dpto['descDepartamento']; ?></td>
                                <td><?php echo $dpto['fechaCreacionDepartamento']; ?></td>
                                <td><?php echo $dpto['volumenDeNegocio']; ?></td>
                                <td><?php echo $dpto['fechaBajaDepartamento']; ?></td>
                                 <td class="iconosDpto"><i class="fa-solid fa-eye"></td>
                                 <td class="iconosAltaBaja">
                                    <?php if ($dpto['fechaBajaDepartamento'] === null): ?>
                                        <span id="activo" ><i class="fa-regular fa-flag"></i></span>
                                    <?php else: ?>
                                        <span id="baja" ><i class="fa-regular fa-flag"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="iconosDpto"><i class="fa-regular fa-pen-to-square"></i></td>
                                <td class="iconosDpto"><i class="fa-regular fa-trash-can"></i></td>
                            </tr>
                        <?php } ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No se han encontrado departamentos.</td>
                        </tr>
                    <?php endif; ?>
                    
                </tbody>
            </table>

        </div>
    </section>
</main>