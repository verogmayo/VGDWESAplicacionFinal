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
                        <?php foreach ($avDepartamentos['dptos'] as $oDpto): ?>
                            <tr>
                                <td><?php echo $oDpto->getCodDepartamento(); ?></td>
                                <td><?php echo $oDpto->getDescDepartamento(); ?></td>
                                <td><?php
                                    $fechaAlta = new DateTime($oDpto->getFechaCreacionDepartamento());
                                    echo $fechaAlta->format('d-m-Y');
                                    ?>
                                </td>
                                <td><?php echo number_format($oDpto->getVolumenDeNegocio(), 2, ',', '.'); ?>€</td>
                                <td>
                                    <?php
                                    if ($oDpto->getFechaBajaDepartamento() !== null) {
                                        $fechaBaja = new DateTime($oDpto->getFechaBajaDepartamento());
                                        echo $fechaBaja->format('d-m-Y');
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                               
                                <td class="iconosDpto"><i class="fa-solid fa-eye"></td>
                                 <td class="iconosAltaBaja">
                                    <?php if ($oDpto->getFechaBajaDepartamento() === null): ?>
                                        <span id="activo" ><i class="fa-regular fa-flag"></i></span>
                                    <?php else: ?>
                                        <span id="baja" ><i class="fa-regular fa-flag"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="iconosDpto"><i class="fa-regular fa-pen-to-square"></i></td>
                                <td class="iconosDpto"><i class="fa-regular fa-trash-can"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No se han encontrado departamentos.</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td id="numRegistrosDpto" colspan="9"><strong>Número de registros:</strong> <?php echo count($avDepartamentos['dptos']); ?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>
</main>