<div class="tituloCentralCuenta">
    <p>MANTENIMIENTO DE DEPARTAMENTOS</p>
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
        <form id="buscarDpto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="altaDptoDiv">
                <button class="botonSessionAltaDpto" type="submit" name="altaDpto">
                    <i class="fa-solid fa-plus"></i> Añadir Departamento
                </button>
                <button class="botonSessionAltaDpto" name="exportar" type="submit">
                    <i class="fa-solid fa-file-export"></i>Exportar</button>
                <input type="file" name="listaDptos" id="subirArchivo" style="display:none;" onchange="this.form.submit()">
        <button class="botonSessionAltaDpto" type="button" onclick="document.getElementById('subirArchivo').click();">
            <i class="fa-solid fa-file-import"></i> Importar
        </button>
        <input type="hidden" name="importar" value="1">
            </div>
            <div class="busquedaDpto">
               <div class="inputGrupo">
                    <input type="text" name="descDepartamento" id="buscarDescDepartamento"
                        placeholder="Indica la descripción a buscar"
                        value="<?php echo $avDepartamentos['busqueda']; ?>">
                    <button id="botonBuscar" type="submit" name="buscar">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                </div>
                di
            </div>
            </div>
        </form>
    </section>
    <section class="sectionTablaDpto">
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

                                <td class="iconosDpto">
                                    <form method="post">
                                        <button id="botonVerDpto" type="submit" name="consultar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="iconosDpto">
                                    <form method="post">
                                        <button id="botonModificarDpto" type="submit" name="modificar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="iconosDpto">
                                    <form method="post">
                                        <button id="botonBorrarDpto" type="submit" name="eliminar" value="<?php echo $dpto['codDepartamento']; ?>" style="background:none; border:none; cursor:pointer;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>

                                <td class="iconosAltaBaja">
                                    <form method="post">
                                        <?php
                                        // Si la fecha de baja está vacía, es que el departamento está ACTIVO
                                        if ($dpto['fechaBajaDepartamento'] === '') {
                                        ?>
                                            <button id="baja" type="submit" name="bajaLogica" value="<?php echo $dpto['codDepartamento']; ?>" style="border:none; background:none; cursor:pointer;">
                                                <i class="fa-solid fa-circle-arrow-down" style="color: red;"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id="activo" type="submit" name="rehabilitar" value="<?php echo $dpto['codDepartamento'] ?>" style="border:none; background:none; cursor:pointer;">
                                                <i class="fa-solid fa-circle-arrow-up" style="color: green;"></i>
                                            </button>
                                        <?php } ?>
                                    </form>
                                </td>
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