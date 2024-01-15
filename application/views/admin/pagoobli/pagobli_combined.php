<!DOCTYPE html>
<html lang="es">

<head>
<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="<?php echo base_url(); ?>assets/css/style_pago_obli.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap5/css/bootstrap.min.css">
=======
    <!-- Estilo de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_pago_obli.css" rel="stylesheet">
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
<<<<<<< HEAD
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/add">Pago de Obligaciones</a></li>
            </ol>
        </nav>

        <div class="container-fluid bg-white rounded-3">
            <!-- Encabezado con botones -->
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 ">
                        <h1>Pago de Obligación</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-2 ">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" title="Nuevo" id="openModalBtn">
                                <i class="bi bi-plus"></i> Nuevo
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/edit'">
                                <span class="fa fa-edit ms-2"></span> Modificar
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.open('<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/pdfs')">
                                Generar PDF
=======
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
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
                            </button>
                            <button class="btn btn-danger ml-3 " title="Eliminar">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
            </div>
=======
            </div> <!-- Final del encabezado -->
            <hr> <!-- barra separadora -->
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9

            <section class="section dashboard">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Campos principales -->
                        <div class="row">
                            <form id="formularioPrincipal">
<<<<<<< HEAD
                                <div class="container-fluid mt-4">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row g-3 align-items-center">
                                                        <div class="form-group col-md-4 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                            <label for="ruc">Ruc:</label>
                                                            <input type="text" class="form-control" id="ruc" name="ruc">
                                                            <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                        </div>

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
                                                        <div class="form-group col-md-4">
                                                            <label for="op">N° Op</label>
                                                            <input type="text" class="form-control" id="op" name="op" value="<?= $op_actual ?>" readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="num_asi">Numero:</label>
                                                            <input type="text" class="form-control w-100" id="num_asi" name="num_asi" value="<?php echo $numero_siguiente; ?> " readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="contabilidad">Contabilidad:</label>
                                                            <input type="text" class="form-control" id="contabilidad" name="contabilidad">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="direccion">Dirección:</label>
                                                            <input type="text" class="form-control" id="direccion" name="direccion">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="telefono">Teléfono:</label>
                                                            <input type="text" class="form-control w-100" id="telefono" name="telefono">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="tesoreria">Tesoreria:</label>
                                                            <input type="text" class="form-control" id="tesoreria" name="tesoreria">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="observacion">Observación:</label>
                                                            <input type="text" class="form-control" id="observacion" name="observacion">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="fecha">Fecha:</label>
                                                            <input type="datetime-local" class="form-control" id="fecha" name="fecha">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="mp">MP</label>
                                                            <input type="text" class="form-control" id="mp" name="mp">
                                                        </div>
                                                    </div>
                                                </div>
=======
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

                                                        <div class="form-group col-md-1">
                                                            <label for="op">N° Op</label>
                                                            <input type="text" class="form-control" id="op" name="op"
                                                                value="<?= $op_actual ?>" readonly>
                                                        </div>
                                                        <div class="form-group col-md-1">
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
                                                        <div class="form-group col-md-8">
                                                            <label for="contabilidad">Nombre y Apellido:</label>
                                                            <input type="text" class="form-control w-100"
                                                                id="contabilidad" name="contabilidad">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="observacion">Concepto:</label>
                                                            <input type="text" class="form-control w-100"
                                                                id="observacion" name="observacion">
                                                        </div>
                                                        <div class="form-group col-12 mb-3">
                                                            <label for="fecha">Fecha:</label>
                                                            <input type="datetime-local" class="form-control" id="fecha"
                                                                name="fecha" required>
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
                                                                <th>Monto de Pago</th>
                                                                <th>Debe</th>
                                                                <th>Haber</th>
                                                                <th>Cheque</th>
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
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="hidden" class="form-control"
                                                                            id="idcuentacontable"
                                                                            name="idcuentacontable">
                                                                        <input style="font-size: smaller;" type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="codigo_cc" name="codigo_cc">
                                                                        <input style="width: 60%; font-size: smaller;"
                                                                            type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="descripcion_cc" name="descripcion_cc">
                                                                        <button data-bs-toggle="modal"
                                                                            data-bs-target="#modalCuentasCont1"
                                                                            style="height: 30px;"
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
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="MontoPago" name="MontoPago" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="Debe" name="Debe" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="Haber" name="Haber" required>
                                                                    </div>
                                                                </td>
                                                                <td>
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
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="hidden"
                                                                            class="form-control border-0 bg-transparent idcuentacontable_2"
                                                                            id="idcuentacontable_2"
                                                                            name="idcuentacontable_2">
                                                                        <input style="font-size: smaller;" type="text"
                                                                            class="form-control border-0 bg-transparent codigo_cc_2"
                                                                            id="codigo_cc_2" name="codigo_cc_2">
                                                                        <input style="width: 60%; font-size: smaller;"
                                                                            type="text"
                                                                            class="form-control border-0 bg-transparent descripcion_cc_2"
                                                                            id="descripcion_cc_2"
                                                                            name="descripcion_cc_2">
                                                                        <button data-bs-toggle="modal"
                                                                            data-bs-target="#modalCuentasCont2"
                                                                            style="height: 30px;"
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
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
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
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="Haber_2" name="Haber_2" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
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
                                                </div>
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
                                            </div>
                                            <!-- Acá termina el card que envuelve los campos del formulario y comienza la tabla -->
                                            <table class="table table-hover table-bordered table-sm rounded-3" id="miTabla">
                                                <thead class="align-middle">
                                                    <tr>
                                                        <th class="columna-ancha">Programa</th>
                                                        <th class="columna-fuente">Fuente</th>
                                                        <th class="columna-origen">Origen</th>
                                                        <th class="columna-ctncontable">Cuenta Contable</th>
                                                        <th>Comprobante</th>
                                                        <th>Detalles</th>
                                                        <th>Monto de Pago</th>
                                                        <th>Debe</th>
                                                        <th>Haber</th>
                                                        <th>Cheque</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <select class="form-control border-0 bg-transparent" id="id_pro" name="id_pro">
                                                                    <?php foreach ($programa as $prog) : ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <select class="form-control border-0 bg-transparent" id="id_ff" name="id_ff">
                                                                    <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <select class="form-control border-0 bg-transparent" id="id_of" name="id_of">
                                                                    <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                                        <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="hidden" class="form-control" id="idcuentacontable" name="idcuentacontable">
                                                                <input style="font-size: smaller;" type="text" class="form-control border-0 bg-transparent" id="codigo_cc" name="codigo_cc">
                                                                <input style="width: 60%; font-size: smaller;" type="text" class="form-control border-0 bg-transparent" id="descripcion_cc" name="descripcion_cc">
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
                                                            <div class="input-group input-group-sm align-items-center  ">
                                                                <input type="text" class="form-control border-0 bg-transparent" id="detalles" name="detalles">
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
                                                        <td>
                                                            <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                <button type="button" class="btn btn-outline-primary border-0 agregarFila" id="agregarFila">
                                                                    <i class="bi bi-plus-square"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr id="filaBase" class="filaBase">
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
                                                                <input type="hidden" class="form-control border-0 bg-transparent idcuentacontable_2" id="idcuentacontable_2" name="idcuentacontable_2">
                                                                <input style="font-size: smaller;" type="text" class="form-control border-0 bg-transparent codigo_cc_2" id="codigo_cc_2" name="codigo_cc_2">
                                                                <input style="width: 60%; font-size: smaller;" type="text" class="form-control border-0 bg-transparent descripcion_cc_2" id="descripcion_cc_2" name="descripcion_cc_2">
                                                                <button data-bs-toggle="modal" data-bs-target="#modalCuentasCont2" style="height: 30px;" class="btn btn-sm btn-outline-primary openModalBtn_4" id="botonBuscar2">
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
                                                                <input type="text" class="form-control border-0 bg-transparent" id="detalles_2" name="detalles_2">
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
                                                        <td>
                                                            <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                <button type="button" class="btn btn-outline-primary border-0 agregarFila" >
                                                                    <i class="bi bi-plus-square"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-outline-danger border-0 eliminarFila" hidden>
                                                                    <i class="bi bi-trash3"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid mt-3 mb-3">
<<<<<<< HEAD
                                    <div class="col-md-12 d-flex flex-row justify-content-end">
                                        <button style="margin-right: 8px;" type="submit" class="btn btn-success" id="guardarFilas"><span class="fa fa-save"></span>Guardar</button>
                                        <div class="notification" id="notification">
                                            <div class="icon">
                                            </div>
                                            <div class="message">Guardado Correctamente</div>
                                        </div>

                                        <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones'">
=======
                                    <div class="col-md-12 d-flex flex-row justify-content-center">
                                        <button style="margin-right: 8px;" type="submit" class="btn btn-success"
                                            id="guardarFilas"><span class="fa fa-save"></span>Guardar</button>


                                        <button type="button" class="btn btn-danger"
                                            onclick="window.location.href='<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones'">
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
                                            <span class="fa fa-remove"></span> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </form>
<<<<<<< HEAD
=======
                            <!-- Tabla de Num_asi -->
                            <table id="vistapago" class="table table-hover table-bordered table-sm rounded-3">
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
                                                    <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                        <button type="button"
                                                            class="btn btn-primary btn-view-presupuesto btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modalPresupuesto"
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
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
<<<<<<< HEAD
    <!-- Contenedor del modal -->
    <div class="modal-container2" id="modalContainer_2">
        <div class="modal-content2">
            <span class="close_2" id="closeModalBtn_2" onclick="closeModal_2()">&times;</span>
            <h3>Lista de Obligaciones</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Ruc</th>
                        <th>Razon Social</th>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Monto Pagado</th>
                        <th>Debe</th>
                        <th>Codigo y Descripción CC</th>
                        <th>Origen de Financiamiento</th>
                        <th>Programa</th>
                        <th>Fuente de Financiamiento</th>   
                        <th>Suma de Monto Pagado</th>   
                        <th>Estado</th>                                  
                    </tr>
                </thead>
                <tbody>
                <?php
$registros_por_proveedor = array();

foreach ($asientos as $asi) {
    $clave_proveedor = $asi->provee;

    $resta_montos = $asi->total - $asi->suma_monto;

    // Evalúa diferentes casos usando un switch
    switch (true) {
        case $asi->suma_monto == $asi->total && $resta_montos == 0:
            break;

        case $asi->suma_monto < $asi->total && $resta_montos != 0 && $asi->id_form == 1:
                agregarRegistroProveedor($registros_por_proveedor, $clave_proveedor, $asi);

                break;

                case $asi->suma_monto == 0 && $asi->total !=0 && $resta_montos != 0 && $asi->id_form == 1:
                    agregarRegistroProveedor($registros_por_proveedor, $clave_proveedor, $asi);
    
                    break;
    }
}

function agregarRegistroProveedor(&$registros, $clave, $asi) {
    // Lógica adicional para verificar si el registro está pagado
    $resta_montos = $asi->total - $asi->suma_monto;

    // Verificar si SumaMonto y MontoTotal son iguales, y la resta es igual a 0
    if ($asi->suma_monto == $asi->total && $resta_montos == 0 && $asi->id_form==1) {
        // No agregar el registro si está pagado
        return;
    }
    // Verifica si ya existe un registro para este proveedor
    if (!isset($registros[$clave])) {
        $registros[$clave] = $asi;
    } 
}
?>

<tbody>
    <?php foreach ($registros_por_proveedor as $asi): ?>
        <?php
        // Agrega un bloque adicional para manejar la lógica de estados e Id_form
        $estado_texto = '';

        // Utilizamos un switch para manejar la lógica de estados
        switch ($asi->estado) {
            case 3:
                // Caso 1: Estado 3 (pendiente)
                $estado_texto = 'Pendiente';
                break;

            case 4:
                // Caso 2: Estado 4 (pagado)
                // Puedes agregar más lógica según tus requerimientos
                // También puedes añadir condiciones adicionales para casos específicos
                $estado_texto = 'Pagado';
                break;

            // Puedes agregar más casos según tus requerimientos

            default:
                // En caso de que el estado no coincida con ningún caso
                $estado_texto = 'Pendiente';
        }
        ?>

        <tr class="list-item" onclick="selectAsi('<?= $asi->ruc_proveedor ?>', '<?= $asi->razso_proveedor ?>', '<?= $asi->nume ?>', '<?= $asi->fecha ?>',
                  '<?= $asi->pagado ?>','<?= $asi->pago ?>','<?= $asi->pagado ?>','<?= $asi->Debe ?>', '<?= $asi->Haber ?>', '<?= $asi->id_ff ?>', '<?= $asi->id_pro ?>', '<?= $asi->id_of ?>','<?= $asi->suma_monto ?>'
                  ,'<?= $asi->telefono ?>','<?= $asi->suma_monto ?>','<?= $asi->comprobante ?>','<?= $asi->detalle?>','<?= $asi->IDCuentaContable ?>',  <?= $asi->IDCuentaContable ?>)">
            <td><?= $asi->ruc_proveedor ?></td>
            <td><?= $asi->razso_proveedor ?></td>
            <td><?= $asi->nume ?></td>
            <td><?= $asi->fecha ?></td>
            <td><?= $asi->total ?></td>
            <td><?= $asi->pagado ?></td>
            <td><?= $asi->Debe ?></td>
            <td><?= $asi->codigo ?> - <?= $asi->descrip ?></td>
            <td><?= $asi->nombre_fuente ?></td>
            <td><?= $asi->nombre_programa ?></td>
            <td><?= $asi->nombre_origen ?></td>
            <td><?= $asi->suma_monto?></td>
            <td><?= $estado_texto ?></td> <!-- Mostrar el estado en una nueva columna -->

        </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    </div>
</div>


    <div class="modal-container" id="modalContainer_3">
                    <div class="modal-content">
                        
                        <span class="close_3" id="closeModalBtn_3" onclick="closeModal_3()">&times;</span>
                        <h3>Buscador de Cuentas Contables</h3>
                        <input type="text" id="searchInput" placeholder="Buscar por código o descripción...">
                        <table class="table table-bordered table-hover" id="cuentasContablesTable">
                        <thead>
                                            <tr >
                                               <th>IDCuentaContable</th>
                                                <th>Código de Cuenta</th>
                                                <th>Descripción de Cuenta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentacontable as $dato): ?>
                                                <tr class="list-item" onclick="selectCC( '<?= $dato->IDCuentaContable ?>','<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')">
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
=======

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
        function selectAsi(ruc, razonSocial, fechas, montos, debes, fuentes, programas, origens, cuentas, descrip, deta, comp, cheq, idcuenta) {
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
    <!-- Script de DataTable de vista  -->
    <script>
        $(document).ready(function () {
            $('#vistapago').DataTable({
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
        $(document).ready(function () {


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


        $("#formularioPrincipal").on("submit", function (e) {

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
                Debe: $("#Debe").val(),
                Haber: $("#Haber").val(),
                cheques_che_id: $("#cheques_che_id").val(),

            };


            // variable para saber si el debe es igual a haber
            let sumahaber = 0;

            var filas = [];


            $("#miTabla tbody tr:gt(0)").each(function (e) {

                var fila = {
                    id_pro: $(this).find("select[name='id_pro_2']").val(),
                    id_ff: $(this).find("select[name='id_ff_2']").val(),
                    id_of: $(this).find("select[name='id_of_2']").val(),
                    IDCuentaContable: $(this).find("input[name='idcuentacontable_2']").val(),
                    detalles: $(this).find("input[name='detalles_2']").val(),
                    comprobante: $(this).find("input[name='comprobante_2']").val(),
                    Debe: $(this).find("input[name='Debe_2']").val(),
                    Haber: $(this).find("input[name='Haber_2']").val(),
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



            if (Math.abs(sumahaber - datosFormulario.Debe) < 0.0001) {
                $.ajax({
                    url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/store"); ?>',
                    type: 'POST',
                    data: { datos: datosCompletos },
                    //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                    success: function (response) {
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

    <div class="modal fade mi-modal" id="modalCuentasCont1" tabindex="-1" aria-labelledby="ModalCuentasContables"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cuentas-contables">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
                </div>
                <div class="modal-body">
                    <input type="text" id="searchInput" placeholder="Buscar por código o descripción...">
                    <table class="table table-hover table-sm" id="TablaCuentaCont1">
                        <thead>
<<<<<<< HEAD
                                            <tr >
                                               <th>IDCuentaContable</th>
                                                <th>Código de Cuenta</th>
                                                <th>Descripción de Cuenta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentacontable as $dato): ?>
                                                <tr class="list-item" onclick="selectCC2(  <?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')">
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
  
    <script>
        // Función para abrir el modal
        function openModal_2() {
            var modalContainer = document.getElementById('modalContainer_2');
            modalContainer.style.display = 'flex';
            openModalBtn.style.zIndex = -1;
        }

        // Función para cerrar el modal
        function closeModal_2() {
            var modalContainer = document.getElementById('modalContainer_2');
            modalContainer.style.display = 'none';
            openModalBtn.style.zIndex = 1;
        }

      // Función para seleccionar un asi

      function selectAsi(ruc, razonSocial, numeros, fechas, montos, debes, habers, fuentes, programas, origens, codigos, comprobante, detalle, descrip, codigoDescrip) {
    // Actualizar los campos de texto en la vista principal
    document.getElementById('ruc').value = ruc;
    document.getElementById('contabilidad').value = razonSocial;
    document.getElementById('tesoreria').value = razonSocial;
    document.getElementById('num_asi').value = numeros;
    document.getElementById('fecha').value = fechas;
    document.getElementById('MontoPago').value = montos;
    document.getElementById('Debe').value = habers;
    document.getElementById('Haber').value = debes;
    document.getElementById('id_ff').value = fuentes;
    document.getElementById('id_pro').value = programas;
    document.getElementById('detalles').value = detalle;
    document.getElementById('id_of').value = origens;
    document.getElementById('codigo_cc').value = codigos;
    document.getElementById('descripcion_cc').value = detalle;
    document.getElementById('comprobante').value = descrip;


    
    closeModal_2(); // Cierra el modal después de seleccionar un proveedor
}


        // Agregar evento al botón "Nuevo" para abrir el modal
        const openModalBtn_2 = document.getElementById("openModalBtn");
        openModalBtn_2.addEventListener("click", () => {
            openModal_2();
        });

        // Agregar evento al botón de cerrar para cerrar el modal
        const closeModalBtn_2 = document.getElementById("closeModalBtn_2");
        closeModalBtn_2.addEventListener("click", () => {
            closeModal_2();
        });

    </script>

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

   
<script>
    $(document).ready(function () {
       
        
       // Agregar fila
        $(".agregarFila").on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            // Clonar la fila base
            var nuevaFila = $("#filaBase").clone();

            // Obtener el índice de la última fila original
            var lastOriginalIndex = $("#miTabla tbody tr[data-original='true']").index();

            // Incrementar el índice en 1 para la nueva fila clonada
            var newIndex = lastOriginalIndex + 1;

            // Establecer el índice en el atributo 'data-index'
            nuevaFila.attr('data-index', newIndex);

            // Quitar el atributo 'hidden' del botón Eliminar en la fila clonada
            nuevaFila.find(".eliminarFila").removeAttr('hidden');

            // Quitar el ID para evitar duplicados
            nuevaFila.removeAttr('id');

            // Agregar una clase a todos los elementos de la fila clonada
            nuevaFila.find("select, input").addClass("filaClonada");

            // Limpiar los valores de los campos en la nueva fila
            nuevaFila.find("select, input").val("");

            // Mostrar la nueva fila
            nuevaFila.show();

            // Agregar la nueva fila al cuerpo de la tabla
            $("#miTabla tbody").append(nuevaFila);
        });


        // Eliminar fila
        $("#miTabla").on("click", ".eliminarFila", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ($("#miTabla tbody tr").length > 2) {
            $(this).closest("tr").remove();
            } else {
            alert("No se puede eliminar la última fila.");
            }
        });
        
    });
</script>

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
            mp: $("#mp").val(),



            // Agrega más campos según sea necesario
            id_pro: $("#id_pro").val(),
            id_ff: $("#id_ff").val(),
            id_of: $("#id_of").val(),
            IDCuentaContable: $("#idcuentacontable").val(),
            comprobante: $("#comprobante").val(),
            Debe: $("#Debe").val(),
            Haber: $("#Haber").val(),
            cheques_che_id: $("#cheques_che_id").val(),

        };
        
        // variable para saber si el debe es igual a haber
        let sumahaber = 0;
       
        var filas = [];
        

        $("#miTabla tbody tr:gt(0)").each(function (e) {
            
            var fila = {
                id_pro: $(this).find("select[name='id_pro_2']").val(),
                id_ff: $(this).find("select[name='id_ff_2']").val(),
                id_of: $(this).find("select[name='id_of_2']").val(),
                IDCuentaContable: $(this).find("input[name='idcuentacontable_2']").val(),
                detalles: $(this).find("input[name='detalles_2']").val(),
                comprobante: $(this).find("input[name='comprobante_2']").val(),
                Debe: $(this).find("input[name='Debe_2']").val(),
                Haber: $(this).find("input[name='Haber_2']").val(),
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
        
        if(Math.abs(sumahaber - datosFormulario.Debe) < 0.0001){
            $.ajax({
                url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/store"); ?>',
                type: 'POST',
                data: {  datos: datosCompletos },
                //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                success: function(response) {
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
                    
                    console.log(xhr.responseText); // Agrega esta línea para ver la respuesta del servidor
                    console.log(datosCompletos);
                    alert("Error en la solicitud AJAX: " + status + " - " + error);
                    
                }
            });
        }else{
            alert('El debe y el haber son diferentes');
            return false;
        }
        
    });
</script>

<script>
    // Función para abrir el modal de las cuentas contables
    function openModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'flex';
        modalContainer.style.top = '30%';

        openModalBtn_3.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'none';
        openModalBtn_3.style.zIndex = 1;
    }
    function selectCC( IDCuentaContable,Codigo_CC, Descripcion_CC) {
        // Actualizar los campos de texto en la vista principal con los valores seleccionados
        document.getElementById('idcuentacontable').value = IDCuentaContable;
        document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
        document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'
        closeModal_3(); 
    }

 // Agregar evento al botón "buscar cuenta" para abrir el modal
    const openModalBtn_3 = document.getElementById("openModalBtn_3");
    openModalBtn_3.addEventListener("click", (event) => {
        event.preventDefault();
        
        openModal_3();
    });

    // Agregar evento al botón de cerrar para cerrar el modal
    const closeModalBtn_3 = document.getElementById("closeModalBtn_3");
    closeModalBtn_3.addEventListener("click", (event) => {
        event.preventDefault();
        closeModal_3();
    });
    
    function filterResults() {
        var input, filter, table, tr, td1, td2, i, txtValue;
        input = document.getElementById("searchInput"); // Ajusta el ID según tu campo de búsqueda
        filter = input.value.toUpperCase();
        table = document.getElementById("cuentasContablesTable");
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

<script>
      
        
    var currentRow = null;
    // Función para abrir el modal de las cuentas contables
    function openModal_4(currentRowParam) {
        
        var modalContainer = document.getElementById('modalContainer_4');
        modalContainer.style.display = 'flex';
        modalContainer.style.top = '30%';
        currentRow = currentRowParam; // Almacenar la fila actual
        openModalBtn_4.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal_4() {
        var modalContainer = document.getElementById('modalContainer_4');
        modalContainer.style.display = 'none';
        openModalBtn_4.style.zIndex = 1;
    }

        
    // Usa la fila actual almacenada al seleccionar la cuenta
    function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
        // Utiliza 'currentRow' en lugar de buscar la última fila
        currentRow.find('.idcuentacontable_2').val(IDCuentaContable);
        currentRow.find('.codigo_cc_2').val(Codigo_CC);
        currentRow.find('.descripcion_cc_2').val(Descripcion_CC);
        closeModal_4();
    }

        // Abrir modal en fila dinamica
        const openModalBtn_4 = document.getElementById("openModalBtn_4");
        // To this (using event delegation)
        // Actualiza la función de clic para pasar la fila actual al abrir el modal
        document.getElementById("miTabla").addEventListener("click", function(event) {
            
=======
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
            document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

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
        document.getElementById("miTabla").addEventListener("click", function (event) {

>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
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
<<<<<<< HEAD
            
        // Cerrar modal en fila dinamica
        const closeModalBtn_4 = document.getElementById("closeModalBtn_4");
        // To this (using event delegation)
        document.getElementById("miTabla").addEventListener("click", function(event) {
            if (event.target && event.target.id === "closeModalBtn_4") {
                event.preventDefault();
                closeModal_4();
            }
        });

            
        
        function filterResults() {
            var input, filter, table, tr, td1, td2, i, txtValue;
            input = document.getElementById("searchInput_2"); // Ajusta el ID según tu campo de búsqueda
            filter = input.value.toUpperCase();
            table = document.getElementById("cuentasContablesTable_2");
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
        document.getElementById("searchInput_2").addEventListener("input", filterResults);

    
    
</script>
<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('Debe').addEventListener('input', function() {
        document.getElementById('Haber_2').value = this.value;
    });
</script>   
<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('Debe').addEventListener('input', function() {
        document.getElementById('MontoPago').value = this.value;
    });
</script>
<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('Debe').addEventListener('input', function() {
        document.getElementById('mp').value = this.value;
    });
</script>
<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('Debe').addEventListener('input', function() {
        document.getElementById('MontoPago_2').value = this.value;
    });
</script>   
<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('comprobante').addEventListener('input', function() {
        document.getElementById('comprobante_2').value = this.value;
    });
</script> 

<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('detalles').addEventListener('input', function() {
        document.getElementById('detalles_2').value = this.value;
    });
</script> 

=======

    </script>

    <!-- Script encargado de las tabla de Lista de Obligacion -->
    <script>
        $(document).ready(function () {
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
        $(document).ready(function () {
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
        document.getElementById('Debe').addEventListener('input', function () {
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
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
</body>

</html>