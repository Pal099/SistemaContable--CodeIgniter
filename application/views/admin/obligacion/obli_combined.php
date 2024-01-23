<!DOCTYPE html>
<html lang="es">

<head>
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
</head>


<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a
                        href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/add">Diario de Obligación</a>
                </li>
            </ol>
        </nav>

        <!-- Content Wrapper.  Contains page content -->
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Diario de Obligación</h1>
                    </div>
                    <div class="col-md-6 mt-4 ">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="camposOpcionalesSwitch">
                                <label class="form-check-label" for="camposOpcionalesSwitch">Campos
                                    Opcionales</label>
                            </div>
                            <button type="button" class="btn btn-primary" title="Nuevo" data-bs-toggle="modal"
                                data-bs-target="#modalContainer_proveedores">
                                <i class="bi bi-plus"></i>
                            </button>

                            <button type="button" class="btn btn-pdf"
                                onclick="window.open('<?php echo base_url(); ?>obligaciones/diario_obligaciones/pdfs')">
                                <i class="bi bi-file-pdf"></i> PDF
                            </button>
                            <button type="button" class="btn btn-excel" title="Ec" id="openModalBtn">
                                <i class="bi bi-file-excel"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- End Page Title -->
            <hr> <!-- barra separadora -->
            <section class="section dashboard">
                <div class="container-fluid">
                    <!-- Campos principales -->
                    <div class="row">
                        <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <h4 class="mt-4">Obligación</h4>
                                                <hr><!-- Separador -->
                                                <div class="row row g-3 align-items-center mt-2">
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
                                                        $op_actual = 0;
                                                    } else {
                                                        $op_actual = 0;
                                                    }

                                                    $conexion->close();
                                                    ?>
                                                    <div class="form-group col-md-2">
                                                        <label for="num_asi">Numero:</label>
                                                        <input type="text" class="form-control" id="num_asi"
                                                            name="num_asi" value="<?php echo $numero_siguiente; ?>"
                                                            readonly>
                                                    </div>
                                                    <div
                                                        class="form-group col-md-2 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                        <label for="ruc">Ruc:</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc"
                                                            readonly>
                                                        <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                    </div>


                                                    <div class="form-group col-md-4">
                                                        <label for="razon_social">Nombre y Apellido:</label>
                                                        <input type="text" class="form-control w-100" id="razon_social"
                                                            name="razon_social" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha:</label>
                                                        <input type="datetime-local" class="form-control" id="fecha"
                                                            name="fecha" required>
                                                    </div>
                                                    <!-- Borré la mayoría de campos a pedido de mi papá  -->
                                                    <!--     <div class="form-group col-md-4">
                                                                <label for="direccion">Dirección:</label>
                                                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                            </div> -->

                                                    <div class="form-group col-md-12">
                                                        <label for="concepto">Concepto:</label>
                                                        <input type="text" class="form-control" id="concepto"
                                                            name="concepto">
                                                    </div>

                                                    <!-- Campos Opcionales del formulario -->
                                                    <div class="collapse mt-4" id="camposOpcionalesCollapse">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label for="pedi_matricula">Ped. Mat:</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pedi_matricula" name="pedi_matricula">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="modalidad">Modalidad:</label>
                                                                    <input type="text" class="form-control"
                                                                        id="modalidad" name="modalidad">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="tipo_presupuesto">Tipo de
                                                                        Presupuesto:</label>
                                                                    <input type="text" class="form-control w-100"
                                                                        id="tipo_presupuesto" name="tipo_presupuesto">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="nro_exp">Nro. Exp:</label>
                                                                    <input type="text" class="form-control" id="nro_exp"
                                                                        name="nro_exp">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="total">Total:</label>
                                                                    <input type="text" class="form-control w-100"
                                                                        id="total" name="total">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="pagado">Pagado:</label>
                                                                    <input type="text" class="form-control w-100"
                                                                        id="pagado" name="pagado" value="<?= 0 ?>">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="op">N° Op</label>
                                                                    <input type="text" class="form-control" id="op"
                                                                        name="op" value="<?= $op_actual ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-hover table-bordered table-sm rounded-3 mt-4"
                                                    id="miTabla">

                                                    <thead class="align-middle">
                                                        <tr>
                                                            <th class="columna-ancha">Prog</th>
                                                            <th class="columna-fuente">F.F.</th>
                                                            <th class="columna-origen">O.F.</th>
                                                            <th class="columna-ctncontable">Cuenta Contable</th>
                                                            <th>Comprobante</th>
                                                            <th>Detalles</th>
                                                            <th class="columna-hidden">Monto de Pago</th>
                                                            <th>Debe</th>
                                                            <th>Haber</th>
                                                            <th class="columna-hidden">Cheque</th>
                                                            <th>Nuevo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="align-items-center">
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_pro" name="id_pro">
                                                                        <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>">
                                                                            <?php echo $prog->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_ff" name="id_ff" required>
                                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>">
                                                                            <?php echo $ff->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_of" name="id_of" required>
                                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                        <option value="<?php echo $of->id_of; ?>">
                                                                            <?php echo $of->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <input type="hidden" class="form-control"
                                                                        id="idcuentacontable" name="idcuentacontable">
                                                                    <input style="width: 40%; font-size: small;"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="codigo_cc" name="codigo_cc" required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="descripcion_cc" name="descripcion_cc">
                                                                    <button type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCuentasCont1"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        id="openModalBtn_3">
                                                                        <i class="bi bi-search"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm align-items-center  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="comprobante" name="comprobante">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="detalles" name="detalles" required>
                                                                </div>
                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="MontoPago" name="MontoPago" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <?php if (isset($Debe)): ?>
                                                                    <?php $debe_value = number_format($Debe, 2, '.', '.'); ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="Debe" name="Debe"
                                                                        value="<?php echo $Debe_value; ?>">
                                                                    <?php else: ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="Debe" name="Debe"
                                                                        oninput="formatNumber('Debe')">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="Haber" name="Haber" required>
                                                                </div>
                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="cheques_che_id" name="cheques_che_id">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary border-0 agregarFila">
                                                                        <i class="bi bi-plus-square"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="filaBase" class="filaBase">
                                                            <!-- segundo asiento  -->
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_pro_2" name="id_pro_2" required>
                                                                        <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>">
                                                                            <?php echo $prog->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_ff_2" name="id_ff_2" required>
                                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>">
                                                                            <?php echo $ff->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_of_2" name="id_of_2" required>
                                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                        <option value="<?php echo $of->id_of; ?>">
                                                                            <?php echo $of->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <input type="hidden"
                                                                        class="form-control border-0 bg-transparent idcuentacontable_2"
                                                                        id="idcuentacontable_2"
                                                                        name="idcuentacontable_2">
                                                                    <input style="font-size: small; width: 40%"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent codigo_cc_2"
                                                                        id="codigo_cc_2" name="codigo_cc_2" required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent descripcion_cc_2"
                                                                        id="descripcion_cc_2" name="descripcion_cc_2">
                                                                    <button type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCuentasCont2"
                                                                        class="btn btn-sm btn-outline-primary openModalBtn_4"
                                                                        id="botonBuscar2">
                                                                        <i class="bi bi-search"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="comprobante_2" name="comprobante_2">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="detalles_2" name="detalles_2">
                                                                </div>
                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="MontoPago_2" name="MontoPago_2" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="Debe_2" name="Debe_2" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <?php if (isset($haber_2)): ?>
                                                                    <?php $haber_2_value = number_format($haber_2, 2, '.', '.'); ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent form formatoNumero"
                                                                        id="Haber_2" name="Haber_2"
                                                                        value="<?php echo $haber_2_value; ?>">
                                                                    <?php else: ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent formatoNumero"
                                                                        id="Haber_2" name="Haber_2"
                                                                        oninput="formatNumber('Haber_2')">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>

                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="cheques_che_id_2" name="cheques_che_id_2">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary border-0 agregarFila">
                                                                        <i class="bi bi-plus-square"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger border-0 eliminarFila"
                                                                        hidden>
                                                                        <i class="bi bi-trash3"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table id="miTabla2"
                                                    class="table table-hover table-bordered table-sm rounded-3 mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>Debe</th>
                                                            <th>Haber</th>
                                                            <th>Diferencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="DebeC" class="form-control border-0 bg-transparent">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="HaberC" class="form-control border-0 bg-transparent">
                                                            </td>
                                                            <td id="diferencia">0</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Botones guardar y cancelar -->
                                                <div class="container-fluid mt-4 mb-3">
                                                    <div class="col-md-12 d-flex flex-row justify-content-center">
                                                        <button style="margin-right: 8px;" type="submit"
                                                            class="btn btn-success btn-primary"><span
                                                                class="fa fa-save"></span>Guardar</button>
                                                        <button type="button" class="btn btn-danger ml-3"
                                                            onclick="window.location.href='<?php echo base_url(); ?>obligaciones/diario_obligaciones'">
                                                            <i class="fa fa-remove"></i> Cancelar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border">
                                            <div class="card-body">
                                                <h4 class="mt-4">Asientos</h4>
                                                <hr><!-- Separador -->
                                                <table id="vistaobli"
                                                    class="table table-hover table-bordered table-sm rounded-3">
                                                    <thead>
                                                        <tr>
                                                            <th>Numero</th>
                                                            <th>Fecha de Emisión</th>
                                                            <th>Proveedor</th>
                                                            <th>Monto</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($asientos)): ?>
                                                        <?php foreach ($asientos as $asien): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $asien->num_asi ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $asien->FechaEmision ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $asien->razon_social ?>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($asien->MontoTotal, 0, '.', '.'); ?>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-view-presupuesto btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modalPresupuesto"
                                                                        value="<?php echo $asien->IDNum_Asi; ?>">
                                                                        <span class="fa fa-search"></span>
                                                                    </button>
                                                                    <button type="button" class="btn btn-warning btn-sm"
                                                                        onclick="window.location.href='<?php echo base_url() ?>obligaciones/Diario_obligaciones/edit/<?php echo $asien->IDNum_Asi; ?>'">
                                                                        <i class="bi bi-pencil-fill"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-remove btn-sm"
                                                                        onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Diario_obligaciones/delete/<?php echo $asien->IDNum_Asi; ?>'">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <p>No se encontraron datos.</p>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                    </div>

                    </form>
                </div>
        </div>
        </section>
        </div>
        <!-- Botones -->


        <!-- Modal Proveedores con boostrap -->
        <div class="modal fade mi-modal" id="modalContainer_proveedores" tabindex="-1"
            aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de Proveedores</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="TablaProveedores" class="table table-hover table-sm">
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
                                <?php foreach ($proveedores as $index => $proveedor): ?>
                                    <tr class="list-item"
                                        onclick="selectProveedor('<?= $proveedor->ruc ?>', '<?= $proveedor->razon_social ?>')"
                                        data-bs-dismiss="modal">
                                        <td>
                                            <?= $index + 1 ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->ruc ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->razon_social ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->direccion ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->telefono ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->email ?>
                                        </td>
                                        <td>
                                            <?= $proveedor->observacion ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- Script para agregar nuevas filas a la tabla -->
        <script>
            $(document).ready(function () {

                function formatNumber(campo) {
                    var value = parseFloat(campo.val().replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
                    if (!isNaN(value)) {
                        campo.val(value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,'));
                    }
                }
                // Agregar fila
                $(document).on("click", ".agregarFila", function (e) {
                    e.preventDefault();

                    // Clonar la fila base
                    var nuevaFila = $("#filaBase").clone();

                    // Quitar el atributo 'hidden' del botón Eliminar en la fila clonada
                    nuevaFila.find(".eliminarFila").removeAttr('hidden');

                    // Quitar el ID para evitar duplicados en todos los elementos de la fila clonada
                    nuevaFila.find("[id]").removeAttr('id');

                    // Agregar una clase a todos los elementos de la fila clonada
                    nuevaFila.find("select, input").addClass("filaClonada");

                    // Limpiar los valores de los campos en la  nueva fila
                    nuevaFila.find("select, input").val("");

                    nuevaFila.find(".formatoNumero").each(function () {
                        // Obtener el campo actual
                        var campo = $(this);

                        // Asociar la función formatNumber al evento oninput
                        campo.on('input', function () {
                            formatNumber(campo);
                        });
                    });

                    // Mostrar la nueva fila
                    nuevaFila.show();

                    // Agregar la nueva fila al cuerpo de la tabla
                    $("#miTabla tbody").append(nuevaFila);
                });



                // Eliminar fila
                $("#miTabla").on("click", ".eliminarFila", function (e) {
                    e.preventDefault();

                    $(this).closest("tr").remove();

                });

            });
        </script>
        <!-- Envio de formulario principal -->
        <script>


            $("#formularioPrincipal").on("submit", function () {

                //datos que no son de la tabla dinamica
                var datosFormulario = {

                    op: $("#op").val(),
                    ruc: $("#ruc").val(),
                    num_asi: $("#num_asi").val(),
                    contabilidad: $("#razon_social").val(),
                    concepto: $("#concepto").val(),
                    fecha: $("#fecha").val(),
                    pedmat: $("#pedi_matricula").val(),
                    modalidad: $("#modalidad").val(),
                    tipo_presu: $("#tipo_presupuesto").val(),
                    nro_exp: $("#nro_exp").val(),
                    total: $("#total").val(),
                    pagado: $("#pagado").val(),
                    MontoPago: $("#MontoPago").val(),
                    //MontoPago2: $("#MontoPago_2").val(),
                    // Agrega más campos según sea necesario
                    id_pro: $("#id_pro").val(),
                    id_ff: $("#id_ff").val(),
                    id_of: $("#id_of").val(),
                    IDCuentaContable: $("#idcuentacontable").val(),
                    comprobante: $("#comprobante").val(),
                    Debe: $("#Debe").val().replace(/[^\d.-]/g, ''),
                    Haber: $("#Haber").val(),
                    cheques_che_id: $("#cheques_che_id").val(),
                    detalles: $("#detalles").val(),

                };


                // variable para saber si el debe es igual a haber
                let sumahaber = 0;

                var filas = [];


                $("#miTabla tbody tr:gt(0)").each(function () {

                    var fila = {
                        id_pro: $(this).find("select[name='id_pro_2']").val(),
                        id_ff: $(this).find("select[name='id_ff_2']").val(),
                        id_of: $(this).find("select[name='id_of_2']").val(),
                        IDCuentaContable: $(this).find("input[name='idcuentacontable_2']").val(),
                        detalles: $(this).find("input[name='detalles_2']").val(),
                        comprobante: $(this).find("input[name='comprobante_2']").val(),
                        Debe: $(this).find("input[name='Debe_2']").val(),
                        Haber: $(this).find("input[name='Haber_2']").val().replace(/[^\d.-]/g, ''),
                        cheques_che_id: $(this).find("input[name='cheques_che_id_2']").val(),
                    };

                    
                    filas.push(fila);
                });


                // Combinar datos del formulario principal y de las filas dinámicas
                var datosCompletos = {
                    datosFormulario: datosFormulario,
                    filas: filas,
                };

                var diferenciaActualizada = parseFloat($("#diferencia").text());

                if (diferenciaActualizada == 0 && diferenciaActualizada >= 0) {
                    $.ajax({
                        url: '<?php echo base_url("obligaciones/diario_obligaciones/store"); ?>',
                        type: 'POST',
                        data: { datos: datosCompletos },
                        //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                        success: function (response) {
                            console.log(response);
                            if (response.includes('Datos guardados exitosamente.')) {
                                alert('Datos guardados exitosamente.');
                                // ... (código adicional si es necesario)
                            } else {
                                alert('Error al guardar los datos: ' + response);
                                console.log(response);
                            }
                        },
                        error: function (xhr, status, error) {

                            console.log(xhr.responseText); // Agrega esta línea para ver la respuesta del servidor
                            console.log(datosCompletos);
                            alert("Error en la solicitud AJAX: " + status + " - " + error);


                            console.log(xhr.responseText); // Agrega esta línea para ver la respuesta del servidor
                            console.log(datosCompletos);
                            alert("Error en la solicitud AJAX: " + status + " - " + error);

                        }
                    });
                } else {
                    alert('El debe y el haber son diferentes');
                    return false;
                }


            });
        </script>

        <!-- Modal con Bootstrap Cuentas Contables numero 1-->
        <div class="modal fade mi-modal" id="modalCuentasCont1" tabindex="-1" aria-labelledby="ModalCuentasContables"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered cuentas-contables">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-sm" id="TablaCuentaCont1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código de Cuenta</th>
                                    <th>Descripción de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cuentacontable as $dato): ?>
                                    <tr class="list-item"
                                        onclick="selectCC(<?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')"
                                        data-bs-dismiss="modal">
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
        <div class="modal fade mi-modal" id="modalCuentasCont2" tabindex="-1" aria-labelledby="ModalCuentasContables"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered cuentas-contables">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-hover table-sm" id="TablaCuentaCont2">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código de Cuenta</th>
                                    <th>Descripción de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cuentacontable as $dato): ?>
                                    <tr class="list-item"
                                        onclick="selectCC2(<?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')"
                                        data-bs-dismiss="modal">
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

        <!-- Script destinado al primer modal con bootstrap (seleccionar) -->
        <script>
            function selectCC(IDCuentaContable, Codigo_CC, Descripcion_CC) {
                // Actualizar los campos de texto en la vista principal con los valores seleccionados
                document.getElementById('idcuentacontable').value = IDCuentaContable;
                document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
                document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

            }

            $(document).ready(function () {
            // Agregar un controlador de eventos de clic al botón
            $('#openModalBtn_3').on('click', function (event) {
                // Detener la propagación del evento
                event.stopPropagation();
                event.preventDefault();
                // Tu lógica para abrir el modal aquí si es necesario
            });
        }); 
        </script>

        <!-- Script destinado al segundo modal con bootstrap (seleccionar) -->
        <script>

            var currentRow = null;

            // Función para abrir el modal de las cuentas contables
            function openModal_4(currentRowParam) {

                var modalContainer = document.getElementById('modalCuentasCont2');

                currentRow = currentRowParam; // Almacenar la fila actual

            }


            // Función para seleccionar la cuenta contable
            function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
                // Verificar si currentRow está definido y no es null
                if (currentRow) {
                    // Utilizar currentRow para actualizar los campos
                    currentRow.find('.idcuentacontable_2').val(IDCuentaContable);
                    currentRow.find('.codigo_cc_2').val(Codigo_CC);
                    currentRow.find('.descripcion_cc_2').val(Descripcion_CC);

                } else {
                    console.error("currentRow no está definido o es null. No se pueden actualizar los campos.");
                }
            }

            // Abrir modal en fila dinamica
            const openModalBtn_4 = document.getElementById("openModalBtn_4");
            // Actualiza la función de clic para pasar la fila actual al abrir el modal
            document.getElementById("miTabla").addEventListener("click", function (event) {

                // Encuentra la fila desde la cual se abrió el modal
                var row = $(event.target).closest('tr');
                if (
                    (event.target && event.target.className.includes("openModalBtn_4")) ||
                    (event.target && event.target.parentNode && event.target.parentNode.className.includes("openModalBtn_4"))
                ) {
                    event.stopPropagation();
                    event.preventDefault();
                    openModal_4(row);
                }
            });

        </script>

        <!-- Script para mostrar los campos opcionales -->
        <script>
            document.getElementById('camposOpcionalesSwitch').addEventListener('change', function () {
                var camposOpcionalesCollapse = new bootstrap.Collapse(document.getElementById('camposOpcionalesCollapse'));
                camposOpcionalesCollapse.toggle();
            });
        </script>

        <!-- Seleccionar un Proveedor -->
        <script>
            function selectProveedor(ruc, razonSocial) {
                document.getElementById('ruc').value = ruc;
                document.getElementById('razon_social').value = razonSocial;
                //document.getElementById('direccion').value = direccion;
            }
        </script>

        <!-- Script encargado de las tablas de proveedores -->
        <script>
            $(document).ready(function () {
                $('#TablaProveedores').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });
            });
        </script>

        <!-- Script para las tablas de lo modales de cuentas contables -->
        <script>
            $(document).ready(function () {
                var table1 = $('#TablaCuentaCont1').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });

                var table2 = $('#TablaCuentaCont2').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });
            });
        </script>

        <!--         <script>
            // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
            document.getElementById('Debe').addEventListener('input', function () {
                document.getElementById('MontoPago').value = this.value;
            });
        </script>
 -->
        <script>
            // Agrega esta pequeña función de JavaScript para actualizar Comprobante al ingresar el Debe
            document.getElementById('comprobante').addEventListener('input', function () {
                document.getElementById('comprobante_2').value = this.value;
            });
        </script>

        <script>
            // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
            document.getElementById('detalles').addEventListener('input', function () {
                document.getElementById('detalles_2').value = this.value;
            });
        </script>
        <script>
            // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
            document.getElementById('detalles').addEventListener('input', function () {
                document.getElementById('detalles_2').value = this.value;
            });
        </script>

        <!-- Script de DataTable de jquery -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
        <!-- Script de DataTable de vista  -->
        <script>
            $(document).ready(function () {
                $('#vistaobli').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "language": {
                        "search": "Busqueda de asientos:"
                    }
                });
            });
        </script>
        <script>
            // Función para formatear números con separadores de miles y dos decimales
            function formatNumber(inputId) {
                var input = document.getElementById(inputId);
                var value = parseFloat(input.value.replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
                if (!isNaN(value)) {
                    input.value = value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,');
                }
            }
        </script>
         <script>
            // Este script escucha los cambios en el campo 'debe'
            // y actualiza automáticamente el campo 'haber' a 0 cada vez que 'debe' cambia.
                document.getElementById('Debe').addEventListener('input', function () {
                document.getElementById('Haber_2').value = this.value;
                document.getElementById('Haber').value = 0;
                document.getElementById('Debe_2').value = 0;
            });
        </script>
        <script>
            function calcularTotalesYDiferencia() {
                var sumaDebe = 0;
                var sumaHaber = 0;


                $("#miTabla tbody tr").each(function () {
                    // Limpiar y obtener el valor de los campos 'Debe' y 'Haber'
                    var valorDebe = $(this).find("input[name*='Debe']").val();
                    var valorHaber = $(this).find("input[name*='Haber']").val();
                    // Realizar reemplazo por separado
                    valorDebe = valorDebe.replace(/[^0-9.-]+/g, "");
                    valorHaber = valorHaber.replace(/[^0-9.-]+/g, "");
                    // Convertir a número y sumar
                    sumaDebe += parseFloat(valorDebe) || 0;
                    sumaHaber += parseFloat(valorHaber) || 0;
                });

                            // Formatear como número con separadores de miles
                    $("#DebeC").val(formatearNumero(sumaDebe));
                    $("#HaberC").val(formatearNumero(sumaHaber));
                    var diferenciaTotal = sumaDebe - sumaHaber;
                    $("#diferencia").text(formatearNumero(diferenciaTotal));
                }

                function formatearNumero(numero) {
                    // Asegurarse de que el número es un tipo flotante
                    numero = parseFloat(numero);
                    // Convertir a texto y añadir separadores de miles
                    return numero.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                $(document).ready(function () {
                    $("#miTabla").on("input", "input[name*='Debe'], input[name*='Haber']", calcularTotalesYDiferencia);
                });

        </script>



    </main>

</body>

</html>