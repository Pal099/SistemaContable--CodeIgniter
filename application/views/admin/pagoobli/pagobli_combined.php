<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Estilo de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_pago_obli.css" rel="stylesheet">
    <!-- Script para el sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('assets/sweetalert-helper/sweetAlertHelper.js'); ?>"></script>
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Movimientos</li>
                <li class="breadcrumb-item active">Pago de Obligaciones</li>
            </ol>
        </nav>

        <div class="container-fluid bg-white border rounded-3">
            <!-- Encabezado con botones -->
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Pago de Obligación</h1>
                    </div>
                    <div class="col-md-6 mt-4 ">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <!-- Switch -->
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="retencionSwitch"
                                    disabled>
                                <label class="form-check-label" for="retencionSwitch">Retención</label>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary" title="Nuevo" data-bs-toggle="modal"
                                    data-bs-target="#modalListaObligacion">
                                    <i class="bi bi-plus" style="font-size: 20px;"></i>
                                </button>
                                <button type="button" class="btn btn-danger" title="Generar PDF"
                                    onclick="window.open('<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/pdfs')">
                                    <i class="bi bi-filetype-pdf" style="font-size: 20px;"></i>
                                </button>
                                <button type="button" class="btn btn-success" itle="Generar EXCEL" id="openModalBtn">
                                    <i class="bi bi-file-excel" style="font-size: 20px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Final del encabezado -->
            <hr> <!-- barra separadora -->

            <section class="section dashboard">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Campos principales -->
                        <div class="row">
                            <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';">
                                <div class="container-fluid mt-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="row g-3 align-items-center mt-2">

                                                        <?php
                                                        // Conexión a la base de datos (debes configurar tu conexión)
                                                        $conexion = new mysqli('localhost', 'root', '', 'contanuevo');

                                                        // Verificar la conexión
                                                        if ($conexion->connect_error) {
                                                            die("La conexión a la base de datos falló: " . $conexion->connect_error);
                                                        }

                                                        // Obtener el número actual registrado en la base de datos
                                                        $consulta = "SELECT MAX(num_asi) as ultimo_numero FROM num_asi";
                                                        $resultado = $conexion->query($consulta);

                                                        if ($resultado->num_rows > 0) {
                                                            // Obtiene el último número registrado
                                                            $fila = $resultado->fetch_assoc();
                                                            $numero_actual = $fila['ultimo_numero'];

                                                            // Incrementar el número actual en 1 para el próximo registro
                                                            $numero_siguiente = $numero_actual + 1;
                                                        } else {
                                                            // Si no hay registros, establece el número inicial como 1
                                                            $numero_actual = 1;
                                                            $numero_siguiente = 2; // Si es el primer registro, el próximo número será 2
                                                        }

                                                        // Obtener el número actual registrado en la base de datos
                                                        $consulta = "SELECT MAX(op) as op FROM num_asi";
                                                        $resultado = $conexion->query($consulta);

                                                        // Verificar si hay filas en el resultado
                                                        if ($resultado !== false && $resultado->num_rows > 0) {
                                                            $op = $resultado->fetch_assoc();
                                                            $op_actual = $op['op'];
                                                            // Incrementar el número actual en 1 para el próximo registro
                                                            $op_actual = $op_actual + 1;
                                                        } else {
                                                            $op_actual = 0; // Manejar el caso en que la consulta no fue exitosa
                                                        }

                                                        // Cierra la conexión a la base de datos
                                                        $conexion->close();
                                                        ?>

                                                        <div class="form-group col-md-1 columna-hidden">
                                                            <label for="op">N° Op</label>
                                                            <input type="text" class="form-control" id="op" name="op"
                                                                value="<?= $op_actual ?>" readonly>
                                                        </div>
                                                        <div class="form-group col-md-2 columna-hidden">
                                                            <input type="text" class="form-control w-100" id="num_asio"
                                                                name="num_asio" readonly>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="num_asi">N° asiento:</label>
                                                            <input type="text" class="form-control w-100" id="num_asi"
                                                                name="num_asi" value="<?php echo $numero_siguiente; ?> "
                                                                readonly>
                                                        </div>
                                                        <div
                                                            class="form-group col-md-2 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                            <label for="ruc">RUC / CI:</label>
                                                            <input type="text" class="form-control" id="ruc" name="ruc">
                                                            <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="contabilidad">Nombre y Apellido:</label>
                                                            <input type="text" class="form-control w-100"
                                                                id="contabilidad" name="contabilidad">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="fecha">Fecha:</label>
                                                            <input type="date" class="form-control" id="fecha"
                                                                name="fecha" required>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="concepto">Concepto:</label>
                                                            <input type="text" class="form-control w-100" id="concepto"
                                                                name="concepto">
                                                        </div>
                                                    </div>
                                                    <table
                                                        class="table table-hover table-bordered table-sm rounded-3 mt-4"
                                                        id="miTabla">
                                                        <thead class="align-middle">
                                                            <tr>
                                                                <th class="columna-ancha">Programa</th>
                                                                <th class="columna-fuente">Fuente</th>
                                                                <th class="columna-origen">Origen</th>
                                                                <th class="columna-ctncontable">Cuenta Contable</th>
                                                                <th>Comprobante</th>
                                                                <th>Detalles</th>
                                                                <th class="columna-hidden">Monto de Pago</th>
                                                                <th>Debe</th>
                                                                <th>Haber</th>
                                                                <th class="columna-hidden">Cheque</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group input-group-sm ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_pro" name="id_pro">
                                                                            <?php foreach ($programa as $prog): ?>
                                                                            <option
                                                                                value="<?php echo $prog->id_pro; ?>">
                                                                                <?php echo $prog->codigo; ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_ff" name="id_ff">
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
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_of" name="id_of">
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
                                                                            id="idcuentacontable"
                                                                            name="idcuentacontable">
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
                                                                            id="detalles" name="detalles">
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="MontoPago" name="MontoPago" readonly>
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="MontoTotal" name="MontoTotal" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <?php if (isset($Debe)): ?>
                                                                        <?php $debe_value = number_format($Debe, 2, ',', '.'); ?>
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
                                                                    <div class="input-group input-group-sm ">
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
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_pro_2" name="id_pro_2" required>
                                                                            <?php foreach ($programa as $prog): ?>
                                                                            <option
                                                                                value="<?php echo $prog->id_pro; ?>">
                                                                                <?php echo $prog->codigo; ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
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
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
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
                                                                            id="codigo_cc_2" name="codigo_cc_2"
                                                                            required>
                                                                        <input style="font-size: small;" type="text"
                                                                            class="form-control border-0 bg-transparent descripcion_cc_2"
                                                                            id="descripcion_cc_2"
                                                                            name="descripcion_cc_2">
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
                                                                    <div class="input-group input-group-sm ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="MontoPago_2" name="MontoPago_2"
                                                                            readonly>
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
                                                                        <?php $haber_2_value = number_format($haber_2, 2, ',', '.'); ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent form formatoNumero haber_reten"
                                                                            id="Haber_2" name="Haber_2"
                                                                            value="<?php echo $haber_2_value; ?>">
                                                                        <?php else: ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent formatoNumero haber_reten"
                                                                            id="Haber_2" name="Haber_2"
                                                                            oninput="formatNumber('Haber_2')">
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="cheques_che_id_2"
                                                                            name="cheques_che_id_2">
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
                                                        class="table table-bordered table-sm rounded-3 mt-4 text-center">
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
                                                                    <input type="text" id="DebeC"
                                                                        class="form-control border-0 bg-transparent celda-debe fw-bold text-center"
                                                                        disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="HaberC"
                                                                        class="form-control border-0 bg-transparent celda-haber fw-bold text-center"
                                                                        disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="diferencia"
                                                                        class="form-control border-0 bg-transparent celda-diferencia fw-bold text-center"
                                                                        value=0 disabled>
                                                                </td>
                                                        </tbody>
                                                    </table>
                                                    <!-- Tabla de los calculos de retención -->
                                                    <div class="collapse" id="calculoderetencion">
                                                        <div class="card border">
                                                            <div class="card-body">
                                                                <div class="col-md-6 mt-4">
                                                                    <h5>Calculo de Retención</h5>
                                                                </div>
                                                                <hr>
                                                                <table class="table table-hover text center">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Concepto</th>
                                                                            <th class="col-md-5 text-center"></th>
                                                                            <th class="col-md-2 text-center"></th>
                                                                            <th class="col-md-3 text-center">Base
                                                                                Retención
                                                                            </th>
                                                                            <th class="col-md-1 text-center">Acciones
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Fila de Retencion IVA -->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Retención
                                                                                    IVA:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0" id="iva-retencion"
                                                                                            data-id-cuenta="1311"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="30" step="1" max="99"
                                                                                            min="0" id="porcentaje-iva"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="iva-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-iva"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1311">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        for="selec-iva"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-iva"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-iva">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Retencion IVA -->
                                                                        <!-- Fila de Retencion Renta -->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Retención
                                                                                    Renta:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2 w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="renta-retencion"
                                                                                            data-id-cuenta="1312"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="3" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-renta"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="renta-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-renta"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1312">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-renta">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-renta"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-renta">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Retencion Renta -->
                                                                        <!-- Fila de Retencion Ley 2051 -->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Retención
                                                                                    Ley 2051:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2 w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0" id="ley-retencion"
                                                                                            data-id-cuenta="1319"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="0.5" step="1"
                                                                                            max="99" min="0"
                                                                                            id="porcentaje-ley"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="ley-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-ley"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1319">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-ley">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-ley"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-ley">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Retencion Ley 2051 -->
                                                                        <!-- Fila de Retencion Aporte Jubilatorio -->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Aporte
                                                                                    Jubilatorio:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="aporte-jubilatorio"
                                                                                            data-id-cuenta="1308"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="16" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-jubilatorio"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="jubilatorio-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-jubilatorio"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1308">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-jubilatorio">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-jubilatorio"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-jubilatorio">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Retencion Aporte Jubilatorio -->
                                                                        <!-- Fila de Deduccion por Anticipo-->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Deducción
                                                                                    por Anticipo:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="deduccion-anticipo"
                                                                                            data-id-cuenta="1310"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="20" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-anticipo"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="anticipo-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-anticipo"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1310">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-anticipo">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-anticipo"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-anticipo">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Deduccion por Anticipo -->
                                                                        <!-- Fila de Deduccion por Fondo de Reparo-->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Deducción
                                                                                    por Fondo de Reparo:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="deduccion-reparo"
                                                                                            data-id-cuenta="1300"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="5" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-reparo"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="reparo-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-reparo"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1300">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-reparo">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-reparo"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-reparo">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Deduccion por Fondo de Reparo -->
                                                                        <!-- Fila de Incuplimiento de Contrato-->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Incuplimiento
                                                                                    de Contrato:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="incuplimiento-contrato"
                                                                                            data-id-cuenta="1444"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="1" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-contrato"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="contrato-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-contrato"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1444">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-contrato">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-contrato"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-contrato">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Incuplimiento de Contrato -->
                                                                        <!-- Fila de Otras Retenciones-->
                                                                        <tr>
                                                                            <td>
                                                                                <span
                                                                                    class="input-group-text border-0 bg-transparent">Otras
                                                                                    Retenciones:</span>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group me-2">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-retencion"
                                                                                            value="0"
                                                                                            id="otras-retenciones"
                                                                                            data-id-cuenta="1313"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">$GS</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group mx-auto my-auto">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="number"
                                                                                            class="form-control text-end editable-input"
                                                                                            value="0" step="1" max="99"
                                                                                            min="0"
                                                                                            id="porcentaje-otras"
                                                                                            readonly>
                                                                                        <span
                                                                                            class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="form-group d-flex align-items-center">
                                                                                    <div class="input-group w-100">
                                                                                        <input type="text"
                                                                                            class="form-control text-end input-baserentencion"
                                                                                            value="0"
                                                                                            id="otras-baserentencion"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex justify-content-center align-items-center">
                                                                                    <input type="checkbox"
                                                                                        class="btn-check select-retencion"
                                                                                        id="selec-otras"
                                                                                        autocomplete="off"
                                                                                        data-id-cuenta="1313">
                                                                                    <label
                                                                                        class="btn btn-outline-success me-2"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Seleccionar retención"
                                                                                        for="selec-otras">
                                                                                        <i class="bi bi-check2"></i>
                                                                                    </label>
                                                                                    <input type="checkbox"
                                                                                        class="btn-check edit-checkbox"
                                                                                        id="edit-otras"
                                                                                        autocomplete="off">
                                                                                    <label
                                                                                        class="btn btn-outline-warning"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="Editar Porcentaje"
                                                                                        for="edit-otras">
                                                                                        <i
                                                                                            class="bi bi-pencil-fill"></i>
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- Fila de Otras Retenciones -->
                                                                    </tbody>
                                                                </table>
                                                                <div
                                                                    class="d-flex justify-content-end align-items-center">
                                                                    <span
                                                                        class="input-group-text border-0 bg-transparent fw-bold">Total
                                                                        Retención:</span>
                                                                    <div
                                                                        class="form-group d-flex align-items-center ms-2">
                                                                        <div class="input-group me-2">
                                                                            <input type="text"
                                                                                class="form-control text-end fw-bold"
                                                                                value="0" id="total-retenciones"
                                                                                readonly>
                                                                            <span class="input-group-text">$GS</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Acá termina lo de retención -->
                                                    <div class="container-fluid mt-3 mb-3">
                                                        <div class="col-md-12 d-flex flex-row justify-content-center">
                                                            <button style="margin-right: 8px;" type="submit"
                                                                class="btn btn-success" id="guardarFilas"><span
                                                                    class="fa fa-save"></span>Guardar</button>
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/add'">
                                                                <span class="fa fa-remove"></span> Cancelar
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Tabla de los asientos -->
                                            <div class="card border">
                                                <div class="card-body">
                                                    <h4 class="mt-4">Asientos Pagados</h4>
                                                    <hr><!-- Separador -->
                                                    <table id="vistapago"
                                                        class="table table-hover table-bordered table-sm rounded-3">
                                                        <thead>
                                                            <tr>
                                                                <th>N° asiento</th>
                                                                <th>N° OP</th>
                                                                <th>Fecha de Emisión</th>
                                                                <th>Proveedor</th>
                                                                <th>Monto Total</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($asiento)): ?>
                                                            <?php foreach ($asiento as $asien): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $asien->num_asi ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->op ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->FechaEmision ?>
                                                                </td>
                                                                <td class="texto-izquierda">
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
                                                                        <button type="button" class="btn btn-danger"
                                                                            title="Generar PDF"
                                                                            onclick="window.open('<?php echo base_url(); ?>obligaciones/diario_obligaciones/pdfs')">
                                                                            <i class="bi bi-filetype-pdf"
                                                                                style="font-size: 20px;"></i>OP
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-view-presupuesto btn-sm"
                                                                            onclick="window.location.href='<?php echo base_url() ?>Pdf_reten/generarPDF_reten/<?php echo $asien->IDNum_Asi; ?>'">
                                                                            <i class="fas fa-file-pdf"></i> Retención
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-warning btn-sm"
                                                                            onclick="window.location.href='<?php echo base_url() ?>obligaciones/pago_de_obligaciones/edit/<?php echo $asien->IDNum_Asi; ?>'">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-remove btn-sm"
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
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Toast del total para la retencion -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toastRetenciones" class="toast text-bg-warning" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: red;"></i>
                    <strong class="me-auto">Advertencia</strong>
                </div>
                <div class="toast-body">
                    El total de la retención no puede ser mayor que el valor del Debe. Por favor, ajusta los
                    porcentajes.
                </div>
            </div>
        </div>

        <!-- Toast del total para la diferencia de Debe y Haber -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toastDebeHaber" class="toast text-bg-warning" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: red;"></i>
                    <strong class="me-auto">Advertencia</strong>
                </div>
                <div class="toast-body">
                    El debe y el haber no pueden ser diferentes.
                </div>
            </div>
        </div>

    </main>

    <!-- Modal Lista de Obligaciones-->
    <div class="modal fade" id="modalListaObligacion" tabindex="-1" aria-labelledby="ModalListaObligaciones"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered lista-obligacion">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lista de Obligaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table style="width: 100%;" class="table table-hover" id="TablaListaObligacion">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ruc</th>
                                <th>Razon Social</th>
                                <th>Nro. asiento</th>
                                <th>Fecha</th>
                                <th hidden></th> <!-- Columna oculta -->
                                <th>M. Pagado</th>
                                <th>M. Restante</th>
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th>Fuente</th>
                                <th>Programa</th>
                                <th>Origen</th>
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asientos as $asientoN => $asi): ?>
                            <?php if (($asi->id_form == 1) && ($asi->Debe == 0)): ?>
                            <!-- hacemos que traiga solo obligaciones  -->

                            <tr class="list-item"
                                onclick="selectAsi('<?= $asi->ruc_proveedor ?>', '<?= $asi->razso_proveedor ?>', '<?= $asi->fecha ?>', '<?= $asi->concepto ?>', '<?= $asi->total ?>',
                                        '<?= $asi->Debe ?>','<?= $asi->Haber ?>', '<?= $asi->id_ff ?>', '<?= $asi->id_pro ?>', '<?= $asi->id_of ?>', 
                                        '<?= $asi->codigo ?>',  '<?= $asi->descrip ?>','<?= $asi->detalles ?>','<?= $asi->comprobante ?>','<?= $asi->cheques_che_id ?>','<?= $asi->idcuenta ?>','<?= $asi->id_numasi ?>','<?= $asi->pagado ?>',)"
                                data-bs-dismiss="modal">
                                <td>
                                    <?= $asientoN + 1 ?>
                                </td>
                                <td>
                                    <?= $asi->ruc_proveedor ?>
                                </td>
                                <td>
                                    <?= $asi->razso_proveedor ?>
                                </td>
                                <td>
                                    <?= $asi->numero ?>
                                </td>
                                <td>
                                    <?= $asi->fecha ?>
                                </td>
                                <td hidden>
                                    <?= $asi->concepto ?>
                                </td>
                                <td>
                                    <?= number_format($asi->pagado, 0, ',', '.') ?>
                                </td>
                                <td>
                                    <?= number_format($asi->total - $asi->pagado, 0, ',', '.') ?>
                                </td>

                                <td hidden>
                                    <?= $asi->Debe ?>
                                </td>
                                <td hidden>
                                    <?= $asi->Haber ?>
                                </td>
                                <td hidden>
                                    <?= $asi->idcuenta ?> -
                                    <?= $asi->codigo ?> -
                                    <?= $asi->descrip ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_fuente ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_programa ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_origen ?>
                                </td>
                                <td hidden>
                                    <?= $asi->detalles ?>
                                </td>
                                <td hidden>
                                    <?= $asi->comprobante ?>
                                </td>
                                <td hidden>
                                    <?= $asi->cheques_che_id ?>
                                </td>
                                <td hidden>
                                    <?= $asi->id_numasi ?>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Script modal lista de obligaciones (seleccionar) ubiqué acá para que se entienda mejor (isaac)-->

    <script>
    function selectAsi(ruc, razonSocial, fechas, concepto, montos, debes, haber, fuentes, programas, origens, cuentas,
        descrip,
        deta, comp, cheq, idcuenta, numasio, pagado) {

        // var descripcionConPrefijo = 'A.P. ' + descrip;
        // var descripcionCodificada = encodeURIComponent(descripcionConPrefijo);

        document.getElementById('ruc').value = ruc;
        document.getElementById('contabilidad').value = razonSocial;
        document.getElementById('fecha').value = fechas;
        document.getElementById('concepto').value = concepto;
        document.getElementById('Debe').value = haber;
        document.getElementById('Haber').value = debes;
        document.getElementById('MontoPago').value = montos;
        document.getElementById('MontoTotal').value = montos;
        document.getElementById('id_ff').value = fuentes;
        document.getElementById('id_pro').value = programas;
        document.getElementById('id_of').value = origens;

        document.getElementById('idcuentacontable').value = idcuenta;
        document.getElementById('codigo_cc').value = cuentas;
        document.getElementById('descripcion_cc').value = descrip;

        document.getElementById('detalles').value = deta;
        document.getElementById('comprobante').value = comp;
        document.getElementById('cheques_che_id').value = cheq;
        document.getElementById('num_asio').value = numasio;
        document.getElementById('MontoPago_2').value = pagado;

        // Verifica si el campo 'ruc' tiene un valor y habilita/deshabilita el switch
        const rucInput = document.getElementById('ruc');
        const retencionSwitch = document.getElementById('retencionSwitch');

        if (rucInput.value.trim() !== "") {
            retencionSwitch.removeAttribute('disabled');
        } else {
            retencionSwitch.setAttribute('disabled', true);
            retencionSwitch.checked = false;
        }

    }
    // Inicializar el estado del switch cuando se cargue la página
    document.addEventListener('DOMContentLoaded', function() {
        const rucInput = document.getElementById('ruc');
        const retencionSwitch = document.getElementById('retencionSwitch');

        if (rucInput.value.trim() !== "") {
            retencionSwitch.removeAttribute('disabled');
        } else {
            retencionSwitch.setAttribute('disabled', true);
            retencionSwitch.checked = false;
        }
    });
    </script>
    <!-- Script encargado de las tabla de Lista de Obligacion -->
    <script>
    $(document).ready(function() {
        $('#TablaListaObligacion').DataTable({
            paging: true,
            pageLength: 10,
            lengthChange: true,
            searching: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    });
    </script>

    <!-- Script que controla los tooltips -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar todos los tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>

    <!-- Script para mostrar los campos de retencion -->
    <script>
    document.getElementById('retencionSwitch').addEventListener('change', function() {
        var calculoderetencion = new bootstrap.Collapse(document.getElementById(
            'calculoderetencion'));
        calculoderetencion.toggle();
    });
    </script>

    <!-- funcion para mostrar el toast -->
    <script>
    function showToastDebe(message, bgColor = 'text-bg-warning', makeTextWhite = false) {
        // Seleccionar el toast
        var toastElement = document.getElementById('toastDebeHaber');

        // Actualizar el mensaje y el color de fondo del toast
        var toastBody = toastElement.querySelector('.toast-body');
        toastBody.innerText = message;

        // Cambiar el color de fondo del toast
        toastElement.classList.remove('text-bg-warning', 'text-bg-danger',
            'text-bg-success'); // Limpiar clases anteriores
        toastElement.classList.add(bgColor);

        // Hacer el texto del cuerpo blanco si es necesario
        if (makeTextWhite) {
            toastBody.classList.add('text-white');
        } else {
            toastBody.classList.remove('text-white');
        }

        // Mostrar el toast
        var toast = new bootstrap.Toast(toastElement, {
            animation: true,
            autohide: true, // Ocultar automáticamente después de un tiempo
            delay: 8000 // Duración en milisegundos (5 segundos)
        });
        toast.show();
    }
    </script>

    <!-- Script de Edicion del porcentaje de retencion -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.edit-checkbox');
        const inputs = document.querySelectorAll('.editable-input');

        checkboxes.forEach((checkbox, index) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    inputs[index].removeAttribute('readonly');
                } else {
                    inputs[index].setAttribute('readonly', true);
                }
            });
        });
    });
    </script>

    <!-- Script donde se realiza los calculos de la retencion -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selecIva = document.getElementsByClassName('select-retencion');
        const debeInput = document.getElementById('Debe');
        const porcentajeIva = document.getElementsByClassName('editable-input');
        const ivaRetencion = document.getElementsByClassName('input-retencion');
        const ivaBaseRetencion = document.getElementsByClassName('input-baserentencion');
        const totalRetenciones = document.getElementById('total-retenciones');
        const myToast = new bootstrap.Toast(document.getElementById('myToast'));

        function showToast() {
            const toastEl = document.getElementById('toastRetenciones');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }


        for (let i = 0; i < selecIva.length; i++) {
            selecIva[i].addEventListener('change', updateValues);
            porcentajeIva[i].addEventListener('input', updateValues);

            function updateValues() {
                const debeValue = parseFloat(debeInput.value.replace(/[.,]/g, '')) || 0;
                console.log("Valor Actual del debe: ", debeValue);
                const porcentaje = parseFloat(porcentajeIva[i].value) || 0;
                let retencion = (debeValue * porcentaje) / 100;
                retencion = Math.round(retencion); // Redondear al número entero más cercano
                ivaRetencion[i].value = formatNumber(retencion);

                const baseRetencion = debeValue - retencion;
                ivaBaseRetencion[i].value = formatNumber(baseRetencion);

                if (!selecIva[i].checked) {
                    ivaRetencion[i].value = 0;
                    ivaBaseRetencion[i].value = 0;
                }

                // Suma todos los valores de los inputs de "input-retencion"
                let total = 0;
                for (let j = 0; j < ivaRetencion.length; j++) {
                    total += parseFloat(ivaRetencion[j].value.replace(/\./g, '').replace(',', '.')) || 0;
                }
                totalRetenciones.value = formatNumber(total);

                // Verifica si el total de retenciones es mayor que el valor de "Debe"
                if (total > debeValue) {
                    // Revierte los cambios
                    ivaRetencion[i].value = 0;
                    ivaBaseRetencion[i].value = 0;
                    totalRetenciones.value = formatNumber(total - retencion);
                    showToast();
                }
            }
        }

        function formatNumber(num) {
            return num.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    });
    </script>

</body>

<!-- Script para agregar la retencion desde el boton a la tabla -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definir el objeto cuentasContables
    var cuentasContables = <?php echo json_encode($cuentacontable); ?>;
    // Agregar fila
    function agregarFila(idCuentaContable, valorRetencion) {
        // Clonar la fila base
        var nuevaFila = $("#filaBase").clone();

        // Quitar el atributo 'hidden' del botón Eliminar en la fila clonada
        nuevaFila.find(".eliminarFila").removeAttr('hidden');

        // Quitar el ID para evitar duplicados en todos los elementos de la fila clonada
        nuevaFila.find("[id]").removeAttr('id');

        // Agregar una clase a todos los elementos de la fila clonada
        nuevaFila.find("select, input").addClass("filaClonada");

        // Limpiar los valores de los campos en la nueva fila, exceptuando ciertos campos
        nuevaFila.find("select, input").not(".idcuentacontable_2, .codigo_cc_2, .descripcion_cc_2").val("");

        // Asociar la función formatNumber al evento oninput para campos con la clase formatoNumero
        nuevaFila.find(".formatoNumero").each(function() {
            // Obtener el campo actual
            var campo = $(this);

            // Asociar la función formatNumber al evento oninput
            campo.on('input', function() {
                formatNumber(campo);
            });
        });

        // Buscar los datos de la cuenta contable correspondiente
        var cuentaBuscada = cuentasContables.find(function(cuenta) {
            return cuenta.IDCuentaContable == idCuentaContable;
        });

        // Verificar si se encontró la cuenta contable
        if (cuentaBuscada) {
            // Asignar los valores de la cuenta contable a los campos correspondientes
            nuevaFila.find(".codigo_cc_2").val(cuentaBuscada
                .Codigo_CC);
            nuevaFila.find(".descripcion_cc_2").val(cuentaBuscada
                .Descripcion_CC);

            // Asignar el valor al campo #Haber_2 en la fila clonada
            nuevaFila.find(".haber_reten").val(valorRetencion);
        } else {
            console.error('Cuenta contable no encontrada para ID:', idCuentaContable);
        }

        // Asignar el ID de la cuenta contable al valor del campo de entrada oculto
        nuevaFila.find(".idcuentacontable_2").val(idCuentaContable);

        // Asignamos el valor de la retencion a la fila
        nuevaFila.find(".haber_reten").val(valorRetencion);

        // Eliminar el atributo 'hidden' de la nueva fila clonada
        nuevaFila.removeAttr('hidden');

        // Añadir la nueva fila clonada al contenedor de la tabla
        $("#miTabla").append(nuevaFila);
    }
    // Eliminar fila con botón
    $("#miTabla").on("click", ".eliminarFila", function(e) {
        e.preventDefault();

        $(this).closest("tr").remove();
    });

    // Eliminar fila con el check de la retención
    function eliminarFila(idCuentaContable) {
        // Encuentra el input oculto con el valor específico y elimina la fila más cercana
        $("input.idcuentacontable_2").each(function() {
            if ($(this).val() == idCuentaContable) {
                $(this).closest("tr").remove();
            }
        });
    }

    function formatNumber(campo) {
        var value = parseFloat(campo.val().replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
        if (!isNaN(value)) {
            campo.val(value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,'));
        }
    }

    // Controlador de eventos para todos los checkboxes de retención
    $(".select-retencion").on("change", function() {
        // Obtener el ID de la cuenta contable del atributo de datos personalizado
        var idCuentaContable = $(this).data("id-cuenta");

        // Obtener el valor de retención del input asociado
        var valorRetencion = $('.input-retencion[data-id-cuenta="' + idCuentaContable + '"]').val();

        // Remover los puntos y comas para obtener el número real
        valorRetencion = valorRetencion.replace(/\./g, '').replace(',', '.');
        valorRetencion = parseFloat(valorRetencion);

        // Llamar a las funciones agregarFila y eliminarFila con el ID de la cuenta contable y el valor de retención
        if (this.checked) {
            agregarFila(idCuentaContable, valorRetencion);
        } else {
            eliminarFila(idCuentaContable);
        }
    });

});
</script>
<!-- Script de DataTable de vista  -->
<script>
$(document).ready(function() {
    $('#vistapago').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        info: true,
        order: [
            [0, 'desc']
        ], // Ordena la primera columna en orden descendiente
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        }
    });
});
</script>

<!-- script para las fechas -->
<script>
// Obtener la fecha y hora actual en el formato deseado (yyyy-MM-ddThh:mm)
function obtenerFechaHoraActual() {
    const fecha = new Date();
    const dia = fecha.getDate().toString().padStart(2, '0');
    const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    const año = fecha.getFullYear();
    return `${año}-${mes}-${dia}`;
}

// Preestablecer el campo de fecha con la fecha y hora actual
const fechaInput = document.getElementById('fecha');
fechaInput.value = obtenerFechaHoraActual();
</script>

<!-- funcion para mostrar el toast -->
<script>
function showToast(message, bgColor, makeTextWhite) {
    // Seleccionar el toast
    var toastElement = document.getElementById('toastErrorFila');

    // Animacion para el toast
    toastElement.setAttribute('data-mdb-animation-init', '');
    toastElement.setAttribute('data-mdb-animation-reset', 'true');
    toastElement.setAttribute('data-mdb-animation', 'slide-out-right');

    // Actualizar el mensaje y el color de fondo del toast
    var toastBody = toastElement.querySelector('.toast-body');
    toastBody.innerText = message;
    toastElement.classList.add(bgColor);

    // Hacer el texto del cuerpo blanco si es necesario
    if (makeTextWhite) {
        toastBody.classList.add('text-white');
    }

    // Mostrar el toast
    var toast = new bootstrap.Toast(toastElement, {
        animation: true
    });
    toast.show();
}
</script>

<!-- Script para agregar nuevas filas a la tabla -->
<script>
$(document).ready(function() {

    function formatNumber(campo) {
        var value = parseFloat(campo.val().replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
        if (!isNaN(value)) {
            campo.val(value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,'));
        }
    }

    // Agregar fila
    $(document).on("click", ".agregarFila", function(e) {
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

        nuevaFila.find(".formatoNumero").each(function() {
            // Obtener el campo actual
            var campo = $(this);

            // Asociar la función formatNumber al evento oninput
            campo.on('input', function() {
                formatNumber(campo);
            });
        });

        // Mostrar la nueva fila
        nuevaFila.show();

        // Agregar la nueva fila al cuerpo de la tabla
        $("#miTabla tbody").append(nuevaFila);
    });

    // Eliminar fila
    $("#miTabla").on("click", ".eliminarFila", function(e) {
        e.preventDefault();

        $(this).closest("tr").remove();

    });

});
</script>
<!-- Envio de formulario principal -->
<script>
$(document).ready(function() {
    $("#formularioPrincipal").on("submit", function(e) {
        e.preventDefault();

        var datosFormulario = obtenerDatosFormulario();
        var filas = obtenerFilasDinamicas();
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
        };

        if (validarDatos(datosCompletos)) {
            enviarDatos(datosCompletos);
        }
    });

    function obtenerDatosFormulario() {
        return {
            op: $("#op").val(),
            ruc: $("#ruc").val(),
            num_asi: $("#num_asi").val(),
            detalles: $("#detalles").val(),
            contabilidad: $("#contabilidad").val(),
            direccion: $("#direccion").val(),
            telefono: $("#telefono").val(),
            tesoreria: $("#tesoreria").val(),
            concepto: $("#concepto").val(),
            fecha: $("#fecha").val(),
            idnumasi: $("#num_asio").val(),
            id_pro: $("#id_pro").val(),
            id_ff: $("#id_ff").val(),
            id_of: $("#id_of").val(),
            IDCuentaContable: parseInt($("#idcuentacontable").val(), 10),
            MontoPago: $("#MontoPago").val().replace(/[^\d.-]/g, ''),
            comprobante: $("#comprobante").val(),
            Debe: $("#Debe").val().replace(/[^\d.-]/g, ''),
            Haber: $("#Haber").val(),
            cheques_che_id: $("#cheques_che_id").val(),
        };
    }

    function obtenerFilasDinamicas() {
        var filas = [];
        $("#miTabla tbody tr:gt(0)").each(function() {
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
        return filas;
    }

    function validarDatos(datosCompletos) {
        var diferenciaActualizada = parseFloat($("#diferencia").val());
        var Totalpagado = parseFloat($("#MontoPago_2").val().replace(/[^\d.-]/g, ''));
        var debe = parseFloat($("#Debe").val().replace(/[^\d.-]/g, ''));
        var Suma = debe + Totalpagado;
        var total = parseFloat($("#MontoTotal").val().replace(/[^\d.-]/g, ''));

        if (Suma > total) {
            showToastDebe('El Monto Pagado es mayor al Total a Pagar.', 'text-bg-warning');
            return false;
        }

        if (diferenciaActualizada !== 0) {
            showToastDebe('El debe y el haber no pueden ser diferentes, por favor revise lo ingresado.',
                'text-bg-warning');
            return false;
        }

        return true;
    }

    function enviarDatos(datosCompletos) {
        $.ajax({
            url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/store"); ?>',
            type: 'POST',
            data: {
                datos: datosCompletos
            },
            success: function(response) {
                if (response.includes('Datos guardados exitosamente.')) {
                    mostrarAlertaExito();
                } else {
                    alert('Error al guardar los datos: ' + response);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(datosCompletos);
                alert("Error en la solicitud AJAX: " + status + " - " + error);
            }
        });
    }
});
</script>

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


<!-- alerta toast -->
<div id="toastErrorFila" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>
</div>

<!-- Script destinado al primer modal con bootstrap (seleccionar) -->
<script>
function selectCC(IDCuentaContable, Codigo_CC, Descripcion_CC) {
    // Actualizar los campos de texto en la vista principal con los valores seleccionados
    document.getElementById('idcuentacontable').value = IDCuentaContable;
    document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
    document.getElementById('descripcion_cc').value =
        Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

}
$(document).ready(function() {
    // Agregar un controlador de eventos de clic al botón
    $('#openModalBtn_3').on('click', function(event) {
        // Detener la propagación del evento
        event.stopPropagation();
        event.preventDefault();
        // Tu lógica para abrir el modal aquí si es necesario
    });
});
</script>


<!-- Script destinado al segundo modal con bootstrap (Buscar y seleccionar) -->
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
document.getElementById("miTabla").addEventListener("click", function(event) {

    // Encuentra la fila desde la cual se abrió el modal
    var row = $(event.target).closest('tr');
    if (
        (event.target && event.target.className.includes("openModalBtn_4")) ||
        (event.target && event.target.parentNode && event.target.parentNode.className.includes(
            "openModalBtn_4"))
    ) {
        event.stopPropagation();
        event.preventDefault();
        openModal_4(row);
    }
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
function calcularTotalesYDiferencia() {
    var sumaDebe = 0;
    var sumaHaber = 0;


    $("#miTabla tbody tr").each(function() {
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
    $("#diferencia").val(formatearNumero(diferenciaTotal));
}

function formatearNumero(numero) {
    // Asegurarse de que el número es un tipo flotante
    numero = parseFloat(numero);
    // Convertir a texto y añadir separadores de miles
    return numero.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function() {
    $("#miTabla").on("input", "input[name*='Debe'], input[name*='Haber']", calcularTotalesYDiferencia);
});
</script>


<!-- script de las tablas de cuentas contables -->
<script>
$(document).ready(function() {
    var table1 = $('#TablaCuentaCont1').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        info: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        }
    });

    var table2 = $('#TablaCuentaCont2').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        info: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        }
    });
});
</script>

<!-- script para las alertas -->
<script>
const toastTrigger = document.getElementById('liveToastBtn')
const toastLiveExample = document.getElementById('liveToast')

if (toastTrigger) {
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    toastTrigger.addEventListener('click', () => {
        toastBootstrap.show()
    })
}
</script>

<script>
// Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
document.getElementById('Debe').addEventListener('input', function() {
    document.getElementById('MontoPago').value = this.value;
});
</script>

<script>
// Este script escucha los cambios en el campo 'debe'
// y actualiza automáticamente el campo 'haber' a 0 cada vez que 'debe' cambia.
document.getElementById('Debe').addEventListener('input', function() {
    document.getElementById('Haber').value = 0;
    document.getElementById('Debe_2').value = 0;
});
</script>

<!-- Script de DataTable de jquery -->
<script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
<!-- Script de Popper para el toast -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<!-- Script de DataTable de jquery -->
<script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>