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
    <?php if (isset($_SESSION['errorAltaDepartamento'])): ?>
        <div class="errorAltaDepartamentoDiv">
            <?php
            echo $_SESSION['errorAltaDepartamento'];
            // Se borra para que no se repita
            unset($_SESSION['errorAltaDepartamento']);
            ?>
        </div>
    <?php endif; ?>
    <section class="contenedorInputDpto">
        <form id="buscarDpto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="descDepartamento">Descripción:</label>
            <a style='color:red'><?php echo $aErrores['descDepartamento'] ?></a><br>
            <input type="text" name="descDepartamento" id="descDepartamento" value="<?php echo $avDepartamentos['busqueda']; ?>">
            <button id="botonSessionIPrivado" class="botonSession" type="submit" name="buscar">Buscar</button>
            <button id="botonAltaDpto" class="botonSessionAltaDpto" type="submit" name="altaDpto">Añadir Departamento</button>
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
                        <th colspan="4">Acción</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (count($avDepartamentos['dptos']) > 0): ?>
                        <?php foreach ($avDepartamentos['dptos'] as $dpto) { ?>
                            <tr class="<?php echo ($dpto['fechaBajaDepartamento'] !== '') ? 'dptoBaja' : ''; ?>">
                                <td><?php echo $dpto['codDepartamento']; ?></td>
                                <td><?php echo $dpto['descDepartamento']; ?></td>
                                <td><?php echo $dpto['fechaCreacionDepartamento']; ?></td>
                                <td><?php echo $dpto['volumenDeNegocio']; ?></td>
                                <td><?php echo $dpto['fechaBajaDepartamento']; ?></td>
                                <form class="formDpto" method="post">
                                    <td class="iconosDpto">
                                        <button type="submit" name="consultar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="iconosDpto">
                                        <button type="submit" name="modificar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                    <td class="iconosDpto">
                                        <button type="submit" name="eliminar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                    <td class="iconosAltaBaja">
                                        <?php if ($dpto['fechaBajaDepartamento'] === ''): ?>
                                            <span id="activo"><i class="fa-solid fa-circle-arrow-down"></i></span>
                                        <?php else: ?>
                                            <span id="baja"><i class="fa-solid fa-circle-arrow-up"></i></span>
                                        <?php endif; ?>
                                    </td>
                                </form>

                            </tr>
                        <?php } ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No se han encontrado departamentos con esta descripción.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>

        </div>
    </section>
</main>