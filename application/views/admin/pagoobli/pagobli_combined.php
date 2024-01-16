<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Estilo de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_pago_obli.css" rel="stylesheet">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a
                        href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/add">Pago de Obligaciones</a>
                </li>
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
                            <button class="btn btn-primary" title="Nuevo" data-bs-toggle="modal"
                                data-bs-target="#modalListaObligacion">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button type="button" class="btn btn-primary"
                                onclick="window.location.href='<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/edit'">
                                <i class="fa fa-edit ms-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary"
                                onclick="window.open('<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/pdfs')">
                                <i class="bi bi-file-pdf"></i> PDF
                            </button>
                            <button class="btn btn-danger ml-3 " title="Eliminar">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
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
                            <form id="formularioPrincipal">
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
                                                            <input type="datetime-local" class="form-control" id="fecha"
                                                                name="fecha" required>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="observacion">Concepto:</label>
                                                            <input type="text" class="form-control w-100"
                                                                id="observacion" name="observacion">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Acá termina el card que envuelve los campos del formulario y comienza la tabla -->
                                            <div class="card border">
                                                <div class="card-body">
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
                                                                        <button data-bs-toggle="modal"
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
                                                                        <button data-bs-toggle="modal"
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
                                                    <!-- Tabla del debe, haber y Diferencia -->
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
                                                                    <input type="text" id="DebeC" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="HaberC" class="form-control">
                                                                </td>
                                                                <td id="diferencia">0</td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Tabla de Num_asi -->
                                                    <h4>Asientos</h4>
                                                    <hr><!-- Separador -->
                                                    </hr>
                                                    <table id="vistapago"
                                                        class="table table-hover table-bordered table-sm rounded-3">
                                                        <thead>
                                                            <tr>
                                                                <th>id_num_asi</th>
                                                                <th>Fecha de Emisión</th>
                                                                <th>num_asi</th>
                                                                <th>op</th>
                                                                <th>Estado</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($asiento)): ?>
                                                            <?php foreach ($asiento as $asien): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $asien->IDNum_Asi ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->FechaEmision ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->num_asi ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->op ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $asien->estado ?>
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
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="window.location.href='<?php echo base_url() ?>obligaciones/Pago_de_obligaciones/edit/<?php echo $asien->IDNum_Asi; ?>'">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-remove btn-sm"
                                                                            onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/delete/<?php echo $asien->IDNum_Asi; ?>'">
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
                                                    <!-- Botones guardar y cancelar -->
                                                    <div class="container-fluid mt-3 mb-3">
                                                        <div class="col-md-12 d-flex flex-row justify-content-center">
                                                            <button style="margin-right: 8px;" type="submit"
                                                                class="btn btn-success" id="guardarFilas"><span
                                                                    class="fa fa-save"></span>Guardar</button>
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones'">
                                                                <span class="fa fa-remove"></span> Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
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
                                <th>M. Pagado</th>
                                <th>M. de Pago</th>
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th>Fuente</th>
                                <th>Programa</th>
                                <th>Origen</th>
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                                <th hidden></th> <!-- Columna oculta -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asientos as $asientoN => $asi): ?>
                            <?php if (($asi->id_form == 1 && $asi->Debe > 0)): ?>
                            <tr class="list-item"
                                onclick="selectAsi('<?= $asi->ruc_proveedor ?>', '<?= $asi->razso_proveedor ?>', '<?= $asi->fecha ?>', '<?= $asi->MontoPago ?>',
                                        '<?= $asi->Debe ?>', '<?= $asi->id_ff ?>', '<?= $asi->id_pro ?>', '<?= $asi->id_of ?>', 
                                        '<?= $asi->codigo ?>',  '<?= $asi->descrip ?>','<?= $asi->detalles ?>','<?= $asi->comprobante ?>','<?= $asi->cheques_che_id ?>','<?= $asi->idcuenta ?>')"
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
                                <td>
                                    <?= $asi->pagado ?>
                                </td>
                                <td>
                                    <?= $asi->MontoPago ?>
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
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script modal lista de obligaciones (seleccionar) -->
    <script>
    // Función para seleccionar un asi
    function selectAsi(ruc, razonSocial, fechas, montos, debes, fuentes, programas, origens, cuentas, descrip, deta,
        comp, cheq, idcuenta) {
        // Actualizar los campos de texto en la vista principal
        document.getElementById('ruc').value = ruc;
        document.getElementById('contabilidad').value = razonSocial;
        document.getElementById('fecha').value = fechas;
        document.getElementById('Debe').value = debes;
        document.getElementById('MontoPago').value = montos;
        document.getElementById('id_ff').value = fuentes;
        document.getElementById('id_pro').value = programas;
        document.getElementById('id_of').value = origens;
        document.getElementById('codigo_cc').value = cuentas;
        document.getElementById('descripcion_cc').value = descrip;
        document.getElementById('detalles').value = deta;
        document.getElementById('comprobante').value = comp;
        document.getElementById('cheques_che_id').value = cheq;
        document.getElementById('idcuentacontable').value = idcuenta;
    }
    </script>
    <!-- Script de la tabla Asientos  -->
    <script>
    $(document).ready(function() {
        $('#vistapago').DataTable({
            paging: true,
            lengthMenu: [
                [5, 15, 25, -1],
                ['5', '15', '25', 'Todo']
            ],
            lengthChange: true,
            searching: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            }
        });
    });
    </script>

    <!-- script para las fechas -->
    <script>
    // Obtener la fecha actual en el formato deseado (yyyy-mm-dd)
    function obtenerFechaActual() {
        const fecha = new Date();
        const dia = fecha.getDate().toString().padStart(2, '0');
        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
        const año = fecha.getFullYear();
        return `${dia}-${mes}-${año}`;
    }

    // Preestablecer el campo de fecha con la fecha actual
    const fechaInput = document.getElementById('fecha');
    //fechaInput.value = obtenerFechaActual();
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
    $("#formularioPrincipal").on("submit", function(e) {

        //datos que no son de la tabla dinamica
        var datosFormulario = {


            op: $("#op").val(),
            ruc: $("#ruc").val(),
            num_asi: $("#num_asi").val(),
            detalles: $("#detalles").val(),
            contabilidad: $("#contabilidad").val(),
            direccion: $("#direccion").val(),
            telefono: $("#telefono").val(),
            tesoreria: $("#tesoreria").val(),
            observacion: $("#observacion").val(),
            fecha: $("#fecha").val(),

            // Agrega más campos según sea necesario
            id_pro: $("#id_pro").val(),
            id_ff: $("#id_ff").val(),
            id_of: $("#id_of").val(),
            IDCuentaContable: $("#idcuentacontable").val(),
            MontoPago: $("#MontoPago").val(),
            comprobante: $("#comprobante").val(),
            Debe: $("#Debe").val().replace(/[^\d.-]/g, ''),
            Haber: $("#Haber").val(),
            cheques_che_id: $("#cheques_che_id").val(),

        };


        // variable para saber si el debe es igual a haber
        let sumahaber = 0;

        var filas = [];


        $("#miTabla tbody tr:gt(0)").each(function(e) {

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
            // Sumar los valores de "Haber" en cada fila clonada desde la segunda en adelante
            var valorClonado = parseFloat($(this).find("[name='Haber_2']").val()) || 0;
            sumahaber += valorClonado;
            filas.push(fila);
        });


        // Combinar datos del formulario principal y de las filas dinámicas
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
        };

        var diferenciaActualizada = parseFloat($("#diferencia").text());

        if (diferenciaActualizada < 0.0001) {
            $.ajax({
                url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/store"); ?>',
                type: 'POST',
                data: {
                    datos: datosCompletos
                },
                //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                success: function(response) {
                    alert(filas);
                    alert(filas);
                    console.log(response);
                    if (response.includes('Datos guardados exitosamente.')) {
                        alert('Datos guardados exitosamente.');
                        // ... (código adicional si es necesario)
                    } else {
                        alert('Error al guardar los datos: ' + response);
                        // ... (código adicional si es necesario)
                    }
                },
                error: function(xhr, status, error) {

                    console.log(xhr
                        .responseText); // Agrega esta línea para ver la respuesta del servidor
                    console.log(datosCompletos);
                    alert("Error en la solicitud AJAX: " + status + " - " + error);


                    console.log(xhr
                        .responseText); // Agrega esta línea para ver la respuesta del servidor
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

    <div class="modal fade mi-modal" id="modalCuentasCont1" tabindex="-1" aria-labelledby="ModalCuentasContables"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cuentas-contables">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchInput" placeholder="Buscar por código o descripción...">
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
                    <input type="text" id="searchInput_2" placeholder="Buscar por código o descripción...">
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
            closeModal_4();
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

        // Actualizar los campos y la diferencia
        $("#DebeC").val(sumaDebe.toFixed(2));
        $("#HaberC").val(sumaHaber.toFixed(2));
        var diferenciaTotal = sumaDebe - sumaHaber;
        $("#diferencia").text(diferenciaTotal.toFixed(2));
    }

    // Vincular eventos
    $(document).ready(function() {
        $("#miTabla").on("input", "input[name*='Debe'], input[name*='Haber_2']", calcularTotalesYDiferencia);
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

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
    <!-- Script de Popper para el toast -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
    <!-- Script de DataTable de vista  -->
    <script>
    $(document).ready(function() {
        $('#vistaobli').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "Busqueda de asientos:",
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            }
        });
    });
    </script>
</body>

</html>