<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap5/css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
</head>


<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/add">Diario de Obligación</a></li>
            </ol>
        </nav>
        <!-- Content Wrapper. Contains page content -->
        <div class="container-fluid bg-white rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 ">
                        <h1>Diario de Obligación</h1>
                    </div>
                    <div class="col-md-6 mt-2 ">
                        <div class="d-flex gap-2 justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                                <input class="form-check-input" type="checkbox" role="switch" id="camposOpcionalesSwitch">
                                <label class="form-check-label" for="camposOpcionalesSwitch">Campos Opcionales</label>
                            </div>
                            <button type="button" class="btn btn-primary" title="Nuevo" data-bs-toggle="modal" data-bs-target="#modalContainer_proveedores">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>obligaciones/diario_obligaciones/edit'">
                                <span class="fa fa-edit"></span>
                            </button>
                            <button type="button" class="btn btn-pdf" onclick="window.open('<?php echo base_url(); ?>obligaciones/diario_obligaciones/pdfs')">
                                <i class="bi bi-file-pdf"></i> PDF
                            </button>
                            <button type="button" class="btn btn-excel" title="Ec" id="openModalBtn">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="container-fluid">
                    <!-- Campos principales -->
                    <div class="row">
                        <form action="<?php echo base_url(); ?>obligaciones/diario_obligaciones/store" method="POST">
                            <div class="container-fluid mt-4">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-4 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                        <label for="ruc">Ruc:</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc" readonly>
                                                        <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                    </div>

                                                    <?php
                                                    $conexion = new mysqli('localhost', 'root', '', 'contanuevo');
                                                    if ($conexion->connect_error) {
                                                        die("La conexión a la base de datos falló: " . $conexion->connect_error);
                                                    }

                                                    $consulta = "SELECT MAX(num_asi) as ultimo_numero FROM num_asi";
                                                    $resultado = $conexion->query($consulta);

                                                    if ($resultado->num_rows > 0) {
                                                        $fila = $resultado->fetch_assoc();
                                                        $numero_actual = $fila['ultimo_numero'];
                                                        $numero_siguiente = $numero_actual + 1;
                                                    } else {
                                                        $numero_actual = 1;
                                                        $numero_siguiente = 2;
                                                    }

                                                    $consulta = "SELECT MAX(op) as op FROM num_asi";
                                                    $resultado = $conexion->query($consulta);

                                                    if ($resultado !== false && $resultado->num_rows > 0) {
                                                        $op = $resultado->fetch_assoc();
                                                        $op_actual = $op['op'];
                                                        $op_actual = $op_actual + 1;
                                                    } else {
                                                        $op_actual = 0;
                                                    }

                                                    $conexion->close();
                                                    ?>

                                                    <div class="form-group col-md-4">
                                                        <label for="num_asi">Numero:</label>
                                                        <input type="text" class="form-control" id="num_asi" name="num_asi" value="<?php echo $numero_siguiente; ?>" readonly>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="razon_social">Razón Social:</label>
                                                        <input type="text" class="form-control w-100" id="razon_social" name="razon_social" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="direccion">Dirección:</label>
                                                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="telefono">Teléfono:</label>
                                                        <input type="text" class="form-control" id="telefono" name="telefono">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="tesoreria">Tesoreria:</label>
                                                        <input type="text" class="form-control w-100" id="tesoreria" name="tesoreria" required>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="observacion">Observación:</label>
                                                        <input type="text" class="form-control w-100" id="observacion" name="observacion">
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="fecha">Fecha:</label>
                                                        <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                                                    </div>
                                                    <!-- Campos Opcionales del formulario -->
                                                    <div class="collapse mt-4" id="camposOpcionalesCollapse">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="pedi_matricula">Ped. Mat:</label>
                                                                    <input type="text" class="form-control" id="pedi_matricula" name="pedi_matricula">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="modalidad">Modalidad:</label>
                                                                    <input type="text" class="form-control" id="modalidad" name="modalidad">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="tipo_presupuesto">Tipo de Presupuesto:</label>
                                                                    <input type="text" class="form-control w-100" id="tipo_presupuesto" name="tipo_presupuesto">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="unidad_respon">Unidad responsable:</label>
                                                                    <input type="text" class="form-control" id="unidad_respon" name="unidad_respon">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="proyecto">Proyecto:</label>
                                                                    <input type="text" class="form-control" id="proyecto" name="proyecto">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="estado">Estado:</label>
                                                                    <input type="text" class="form-control w-100" id="estado" name="estado">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="nro_pac">Nro. Pac:</label>
                                                                    <input type="text" class="form-control" id="nro_pac" name="nro_pac">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="nro_exp">Nro. Exp:</label>
                                                                    <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="total">Total:</label>
                                                                    <input type="text" class="form-control w-100" id="total" name="total">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="pagado">Pagado:</label>
                                                                    <input type="text" class="form-control w-100" id="pagado" name="pagado">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="OP">N° Op</label>
                                                                    <input type="text" class="form-control w-100" id="OP" name="OP" value="<?= $op_actual ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tabla -->
                                <!-- Primer asiento de la obligación  -->
                                <table class="table table-hover table-bordered table-sm rounded-3  ">
                                    <thead class="align-middle">
                                        <tr>
                                            <th class="columna-ancha" scope="col">Programa</th>
                                            <th class="columna-fuente" scope="col">Fuente</th>
                                            <th class="columna-origen" scope="col">Origen</th>
                                            <th class="columna-ctncontable" scope="col">Cuenta Contable</th>
                                            <th scope="col">Comprobante</th>
                                            <th scope="col">Detalles</th>
                                            <th scope="col">Monto de Pago</th>
                                            <th scope="col">Debe</th>
                                            <th scope="col">Haber</th>
                                            <th scope="col">Cheque</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <tr class="align-items-center">
                                            <td>
                                                <div class="input-group input-group-sm ">
                                                    <select class="form-control small border-0 bg-transparent" id="id_pro" name="id_pro" required>
                                                        <?php foreach ($programa as $prog) : ?>
                                                            <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm ">
                                                    <select class="form-control small border-0 bg-transparent" id="id_ff" name="id_ff" required>
                                                        <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                            <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <select class="form-control small border-0 bg-transparent" id="id_of" name="id_of" required>
                                                        <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                            <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" class="form-control small border-0 bg-transparent" id="idcuentacontable" name="idcuentacontable">
                                                    <input style="font-size: smaller;" type="text" class="form-control small border-0 bg-transparent" id="codigo_cc" name="codigo_cc">
                                                    <input style="width: 60%; font-size: smaller;" type="text" class="form-control small border-0 bg-transparent" id="descripcion_cc" name="descripcion_cc">
                                                    <button data-bs-toggle="modal" data-bs-target="#modalCuentasCont1" style="height: 30px;" class="btn btn-sm btn-outline-primary" id="openModalBtn_3">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm align-items-center  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="comprobante" name="comprobante">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="detalles" name="detalles" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control small border-0 bg-transparent" id="MontoPago" name="MontoPago" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control small border-0 bg-transparent" id="Debe" name="Debe" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control small border-0 bg-transparent" id="Haber" name="Haber" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control small border-0 bg-transparent" id="cheques_che_id" name="cheques_che_id">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- segundo asiento  -->
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <select class="form-control border-0 bg-transparent" id="id_pro_2" name="id_pro_2" required>
                                                        <?php foreach ($programa as $prog) : ?>
                                                            <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <select class="form-control border-0 bg-transparent" id="id_ff_2" name="id_ff_2" required>
                                                        <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                            <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <select class="form-control border-0 bg-transparent" id="id_of_2" name="id_of_2" required>
                                                        <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                            <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" class="form-control border-0 bg-transparent" id="idcuentacontable_2" name="idcuentacontable_2">
                                                    <input style="font-size: smaller;" type="text" class="form-control border-0 bg-transparent" id="codigo_cc_2" name="codigo_cc_2">
                                                    <input style="width: 60%; font-size: smaller;" type="text" class="form-control border-0 bg-transparent" id="descripcion_cc_2" name="descripcion_cc_2">
                                                    <button data-bs-toggle="modal" data-bs-target="#modalCuentasCont2" style="height: 30px;" class="btn btn-sm btn-outline-primary" id="botonBuscar2">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="comprobante_2" name="comprobante_2">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="detalles_2" name="detalles_2" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="MontoPago_2" name="MontoPago_2" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="Debe_2" name="Debe_2" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="Haber_2" name="Haber_2" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm  ">
                                                    <input type="text" class="form-control border-0 bg-transparent" id="cheques_che_id_2" name="cheques_che_id_2">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid mt-4 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span class="fa fa-save"></span>Guardar</button>
                                    <button class="btn btn-danger ml-3" onclick="window.location.href='<?php echo base_url(); ?>obligaciones/diario_obligaciones'">
                                        <i class="fa fa-remove"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
            </section>
        </div>
        <thead>
            <tr>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)) : ?>
                <?php foreach ($data as $item) : ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->ruc; ?></td>
                        <td><?php echo $item->numero; ?></td>
                        <td><?php echo $item->razon_social; ?></td>
                        <td><?php echo $item->direccion; ?></td>
                        <td><?php echo $item->telefono; ?></td>
                        <td><?php echo $item->observacion; ?></td>
                        <td><?php echo $item->fecha; ?></td>
                        <td><?php echo $item->tesoreria; ?></td>
                        <td><?php echo $item->pedi_matricula; ?></td>
                        <td><?php echo $item->modalidad; ?></td>
                        <td><?php echo $item->tipo_presupuesto; ?></td>
                        <td><?php echo $item->unidad_respon; ?></td>
                        <td><?php echo $item->proyecto; ?></td>
                        <td><?php echo $item->estado; ?></td>
                        <td><?php echo $item->nro_pac; ?></td>
                        <td><?php echo $item->nro_exp; ?></td>
                        <td><?php echo $item->total; ?></td>
                        <td><?php echo $item->pagado; ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-view-Diario_obligaciones" data-toggle="modal" data-target="#modal-default" value="<?php echo $data->id; ?>">
                                    <span class="fa fa-search"></span>
                                </button>

                                <a href="<?php echo base_url(); ?>mantenimiento/Diario_obligaciones/delete/<?php echo $data->id; ?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        </table>
        <!-- Botones -->


        <!-- Modal Proveedores con boostrap -->
        <div class="modal fade mi-modal" data-bs-backdrop="false" id="modalContainer_proveedores" tabindex="-1" aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de Proveedores</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchInput" placeholder="Buscar por RUC o Razon Social...">
                        <table class="table table-hover table-bordered table-sm rounded-3" id="tablaProveedor">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ruc</th>
                                    <th>Razón Social</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proveedores as $index => $proveedor) : ?>
                                    <tr class="list-item" onclick="selectProveedor('<?= $proveedor->ruc ?>', '<?= $proveedor->razon_social ?>', '<?= $proveedor->direccion ?>')" data-bs-dismiss="modal">
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $proveedor->ruc ?></td>
                                        <td><?= $proveedor->razon_social ?></td>
                                        <td><?= $proveedor->direccion ?></td>
                                        <td><?= $proveedor->telefono ?></td>
                                        <td><?= $proveedor->email ?></td>
                                        <td><?= $proveedor->observacion ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal con Bootstrap Cuentas Contables numero 1-->
        <div class="modal fade mi-modal" data-bs-backdrop="false" id="modalCuentasCont1" tabindex="-1" aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchInput_4" placeholder="Buscar por código o descripción...">
                        <table class="table table-bordered table-hover" id="cuentasContablesTable_4">
                            <thead>
                                <tr>
                                    <th>IDCuentaContable</th>
                                    <th>Código de Cuenta</th>
                                    <th>Descripción de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cuentacontable as $dato) : ?>
                                    <tr class="list-item" onclick="selectCC(  <?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')" data-bs-dismiss="modal">
                                        <td>
                                            <?= $dato->IDCuentaContable ?>
                                        </td>
                                        <td>
                                            <?= $dato->Codigo_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->Descripcion_CC ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal con Bootstrap Cuentas Contables numero 2-->
        <div class="modal fade" data-bs-backdrop="false" id="modalCuentasCont2" tabindex="-1" aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchInput_3" placeholder="Buscar por código o descripción...">
                        <table class="table table-bordered table-hover" id="cuentasContablesTable_3">
                            <thead>
                                <tr>
                                    <th>IDCuentaContable</th>
                                    <th>Código de Cuenta</th>
                                    <th>Descripción de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cuentacontable as $dato) : ?>
                                    <tr class="list-item" onclick="selectCC2(  <?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')" data-bs-dismiss="modal">
                                        <td>
                                            <?= $dato->IDCuentaContable ?>
                                        </td>
                                        <td>
                                            <?= $dato->Codigo_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->Descripcion_CC ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script destinado al primer modal con bootstrap (Buscar y seleccionar) -->
        <script>
            function selectCC(IDCuentaContable, Codigo_CC, Descripcion_CC) {
                // Actualizar los campos de texto en la vista principal con los valores seleccionados
                document.getElementById('idcuentacontable').value = IDCuentaContable;
                document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
                document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

            }

            function filterResults() {
                var input, filter, table, tr, td1, td2, i, txtValue;
                input = document.getElementById("searchInput_4"); // Ajusta el ID según tu campo de búsqueda
                filter = input.value.toUpperCase();
                table = document.getElementById("cuentasContablesTable_4");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
                    td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)

                    if (td1 && td2) {
                        // Combina los textos de ambas posiciones en una cadena
                        txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);

                        // Busca en la cadena combinada
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            document.getElementById("searchInput_4").addEventListener("input", filterResults);
        </script>


        <!-- Script destinado al segundo modal con bootstrap (Buscar y seleccionar) -->
        <script>
            function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
                // Actualizar los campos de texto en la vista principal con los valores seleccionados
                document.getElementById('idcuentacontable_2').value = IDCuentaContable;
                document.getElementById('codigo_cc_2').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
                document.getElementById('descripcion_cc_2').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'
            }

            function filterResults() {
                var input, filter, table, tr, td1, td2, i, txtValue;
                input = document.getElementById("searchInput_3"); // Ajusta el ID según tu campo de búsqueda
                filter = input.value.toUpperCase();
                table = document.getElementById("cuentasContablesTable_3");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
                    td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)

                    if (td1 && td2) {
                        // Combina los textos de ambas posiciones en una cadena
                        txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);

                        // Busca en la cadena combinada
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            document.getElementById("searchInput_3").addEventListener("input", filterResults);
        </script>

        <!-- Script para mostrar los campos opcionales -->
        <script>
            document.getElementById('camposOpcionalesSwitch').addEventListener('change', function() {
                var camposOpcionalesCollapse = new bootstrap.Collapse(document.getElementById('camposOpcionalesCollapse'));
                camposOpcionalesCollapse.toggle();
            });
        </script>

        <!-- Seleccionar un Proveedor -->
        <script>
            function selectProveedor(ruc, razonSocial, direccion) {
                document.getElementById('ruc').value = ruc;
                document.getElementById('razon_social').value = razonSocial;
                document.getElementById('tesoreria').value = razonSocial;
                document.getElementById('direccion').value = direccion;
                // Agrega el resto de los campos si es necesario
            }
            function filterResults() {
                var input, filter, table, tr, td1, td2, i, txtValue;
                input = document.getElementById("searchInput"); // Ajusta el ID según tu campo de búsqueda
                filter = input.value.toUpperCase();
                table = document.getElementById("tablaProveedor");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
                    td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)
                    
                    if (td1 && td2) {
                        // Combina los textos de ambas posiciones en una cadena
                        txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);
                        
                        // Busca en la cadena combinada
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            document.getElementById("searchInput").addEventListener("input", filterResults);
        </script>

        <!-- Script de bootstrap -->
        <script src="<?php echo base_url(); ?>/assets/bootstrap5/js/bootstrap.min.js"></script>


    </main>

</body>

</html>