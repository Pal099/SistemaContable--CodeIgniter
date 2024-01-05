<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="<?php echo base_url();?>assets/css/style_pago_obli.css" rel="stylesheet">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

</head>

<body>
    <main id="main" class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-container">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Vista del Pago de obligaciones</li>
                    </ol>
                </nav>
                <h1>Pago de Obligaciones</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center">
                            <h1 style="color: #030E50; font-size: 20px; margin-right: auto;">Datos del asiento</h1>
                            <div class="btn-group">  
                            <div class="form-group">
                            <?php

                                // Configuración de la base de datos
                                $host = 'localhost';  // Cambia a tu host
                                $usuario = 'root';  // Cambia a tu nombre de usuario
                                $clave = '';  // Cambia a tu contraseña
                                $base_de_datos = 'contanuevo';  // Cambia a tu nombre de base de datos

                                // Crear conexión
                                $conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

                                // Verificar la conexión
                                if ($conexion->connect_error) {
                                    die("La conexión a la base de datos falló: " . $conexion->connect_error);
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


                            <label for="op">N° Op</label>
                            <input type="text" class="form-control" id="op"
                                name="op" value="<?= $op_actual ?>"readonly>
                                </div>
                                <button class="btn btn-sm btn-primary ms-2" title="Nuevo" id="openModalBtn">
                                    <i class="bi bi-plus"></i> Nuevo
                                </button>
                                <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/edit" class="btn btn-primary btn-flat">
                                    <span class="fa fa-edit ms-2"></span> Modificar
                                </a>
                                <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/pdfs" target="_blank" class="btn btn-primary">
                                    <i class="bi bi-file-pdf"></i> Generar PDF
                                </a>

                            
                                <label class="switch" for="optionalFieldsSwitch">
                                    <input type="checkbox" id="optionalFieldsSwitch">
                                    <span class="slider"></span>Campos Opciopnales
                                </label>
                                
                            </div>

                        </div>
                    </div>

                    <!-- Campos principales -->
                    <div class="row">
                        <div class="col-md-10">
                            <table id="example1" class="table table-bordered table-hover">

                                <form action="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/store"
                                    method="POST">
                                    <div class="content3">
                                        <div class="content-container3">
                                            <div class="main-fields">
                                                <div
                                                    class="form-group <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
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

                                                // Cierra la conexión a la base de datos
                                                $conexion->close();
                                                ?>

                                                <div class="form-group">
                                                    <label for="num_asi">Numero:</label>
                                                    <input type="text" class="form-control" id="num_asi" name="num_asi"
                                                        value="<?php echo $numero_siguiente; ?>" readonly>
                                                </div>




                                                <div class="form-group">
                                                    <label for="contabilidad">Contabilidad:</label>
                                                    <input type="text" class="form-control" id="contabilidad"
                                                        name="contabilidad">
                                                </div>
                                                <div class="form-group">
                                                    <label for="direccion">Dirección:</label>
                                                    <input type="text" class="form-control" id="direccion"
                                                        name="direccion">
                                                </div>
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono:</label>
                                                    <input type="text" class="form-control" id="telefono"
                                                        name="telefono">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tesoreria">Tesoreria:</label>
                                                    <input type="text" class="form-control" id="tesoreria"
                                                        name="tesoreria">
                                                </div>
                                                <div class="form-group">
                                                    <label for="observacion">Observación:</label>
                                                    <input type="text" class="form-control" id="observacion"
                                                        name="observacion">
                                                </div>
                                                <div class="form-group">
                                                <label for="fecha">Fecha:</label>
                                                <input type="datetime-local" class="form-control" id="fecha" name="fecha">
                                            </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Primer asiento de la obligación  -->
                                    <div class="content4">
                                        <div class="content-container4">
                                            <div class="main-fields">
                                            <div class="form-group">
                                                <label for="cuentacontable">Código y Descripción de Cuenta Contable:</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="cuentacontable" name="cuentacontable">
                                                        <?php foreach ($cuentacontable as $cc): ?>
                                                            <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                                <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-primary ms-2" id="openModalBtn">
                                                            <i class="bi bi-search"></i> Busqueda Cuenta
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                                <!-- Monto de Pago -->
                                                <div class="form-group">
                                                    <label for="MontoPago">Monto de Pago:</label>
                                                    <input type="text" class="form-control" id="MontoPago"
                                                        name="MontoPago">
                                                </div>

                                                <!-- Debe -->
                                                <div class="form-group">
                                                    <label for="Debe">Debe:</label>
                                                    <input type="text" class="form-control" id="Debe" name="Debe">
                                                </div>

                                                <!-- Haber -->
                                                <div class="form-group">
                                                    <label for="Haber">Haber:</label>
                                                    <input type="text" class="form-control" id="Haber" name="Haber">
                                                </div>

                                                <!-- Comprobante -->
                                                <div class="form-group">
                                                    <label for="comprobante">Comprobante:</label>
                                                    <input type="text" class="form-control" id="comprobante"
                                                        name="comprobante">
                                                </div>

                                                <!-- Origen de Financiamiento -->
                                                <div class="form-group">
                                                    <label for="id_of">Origen de Financiamiento:</label>
                                                    <select class="form-control" id="id_of" name="id_of">
                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                            <option value="<?php echo $of->id_of; ?>">
                                                                <?php echo $of->nombre; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Programa -->
                                                <div class="form-group">
                                                    <label for="id_pro">Programa:</label>
                                                    <select class="form-control" id="id_pro" name="id_pro">
                                                        <?php foreach ($programa as $prog): ?>
                                                            <option value="<?php echo $prog->id_pro; ?>">
                                                                <?php echo $prog->nombre; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Fuente de Financiamiento -->
                                                <div class="form-group">
                                                    <label for="id_ff">Fuente de Financiamiento:</label>
                                                    <select class="form-control" id="id_ff" name="id_ff">
                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                            <option value="<?php echo $ff->id_ff; ?>">
                                                                <?php echo $ff->nombre; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Cheque -->
                                                <div class="form-group">
                                                    <label for="">Cheque ID:</label>
                                                    <input type="text" class="form-control" id="cheques_che_id"
                                                        name="cheques_che_id">
                                                </div>
                                                <?php
// Conexión a la base de datos (debes configurar tu conexión)
$conexion = new mysqli('localhost', 'root', '', 'contanuevo');

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión a la base de datos falló: " . $conexion->connect_error);
}

// Obtener el número actual registrado en la base de datos
$consulta = "SELECT SumaMonto as suma_m FROM num_asi";
$resultado = $conexion->query($consulta);

// Verificar si hay filas en el resultado
if ($resultado->num_rows > 0) {
    $suma_monto = $resultado->fetch_assoc();
    $numero_actual = $suma_monto['suma_m'];
} else {
    $numero_actual = 0; // Manejar el caso en que la consulta no fue exitosa
}

// Cierra la conexión a la base de datos
$conexion->close();
?>

<!-- Monto de Pago -->
<div class="form-group">
    <label for="monto_pagado_acumulado">Monto Pagado:</label>
    <input type="text" class="form-control" id="monto_pagado_acumulado" name="monto_pagado_acumulado" value="<?php echo $numero_actual; ?>" readonly>
</div>





                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>

                    <!-- Segundo asiento de la obligación  -->
                    <div class="main-fields">
                        <div class="form-group">
                            <label for="cuentacontable_2">Código y Descripción de Cuenta Contable:</label>
                            <select class="form-control" id="cuentacontable_2" name="cuentacontable_2">
                                <?php foreach ($cuentacontable as $cc): ?>
                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                        <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Campo oculto para el select, para poder separar IDCuentaContable-->
                        <div class="form-group" style="display: none;">
                            <label for="cuentacontable_text_">Cuenta Contable Seleccionada:</label>
                            <input type="text" class="form-control" id="cuentacontable_text" name="cuentacontable_text"
                                readonly>
                        </div>

                        <!-- Monto de Pago -->
                        <div class="form-group">
                            <label for="MontoPago_2">Monto de Pago:</label>
                            <input type="text" class="form-control" id="MontoPago_2" name="MontoPago_2">
                        </div>

                        <!-- Debe -->
                        <div class="form-group <?php echo form_error('Debe_2') == true ? 'has-error' : '' ?>">
                            <label for="Debe_2">Debe:</label>
                            <input type="text" class="form-control" id="Debe_2" name="Debe_2">
                            <?php echo form_error("Debe_2", "<span class='help-block'>", "</span>"); ?>
                            <h2>
                                <?php if (isset($mensaje))
                                    echo $mensaje; ?>
                            </h2>
                            <?= validation_errors(); ?> <!--mostrar los errores de validación-->
                        </div>

                        <!-- Haber -->
                        <div class="form-group <?php echo form_error('Haber_2') == true ? 'has-error' : '' ?>">
                            <label for="Haber_2">Haber:</label>
                            <input type="text" class="form-control" id="Haber_2" name="Haber_2">
                            <?php echo form_error("Haber_2", "<span class='help-block'>", "</span>"); ?>
                            <h2>
                                <?php if (isset($mensaje))
                                    echo $mensaje; ?>
                            </h2>
                            <?= validation_errors(); ?> <!--mostrar los errores de validación-->
                        </div>

                        <!-- Comprobante -->
                        <div class="form-group">
                            <label for="comprobante_2">Comprobante:</label>
                            <input type="text" class="form-control" id="comprobante_2" name="comprobante_2">
                        </div>

                        <!-- Origen de Financiamiento -->
                        <div class="form-group">
                            <label for="id_of_2">Origen de Financiamiento:</label>
                            <select class="form-control" id="id_of_2" name="id_of_2">
                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                    <option value="<?php echo $of->id_of; ?>">
                                        <?php echo $of->nombre; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Programa -->
                        <div class="form-group">
                            <label for="id_pro_2">Programa:</label>
                            <select class="form-control" id="id_pro_2" name="id_pro_2">
                                <?php foreach ($programa as $prog): ?>
                                    <option value="<?php echo $prog->id_pro; ?>">
                                        <?php echo $prog->nombre; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Fuente de Financiamiento -->
                        <div class="form-group">
                            <label for="id_ff_2">Fuente de Financiamiento:</label>
                            <select class="form-control" id="id_ff_2" name="id_ff_2">
                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                    <option value="<?php echo $ff->id_ff; ?>">
                                        <?php echo $ff->nombre; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Cheque -->
                        <div class="form-group">
                            <label for="cheques_che_id_2">Cheque ID:</label>
                            <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                        </div>
                    </div>

                </div>
        </div>
        </div>
        </div>
        </div>
        <div class="row">
            <!-- Campos opcionales (ocultos por defecto) -->
            <div class="row optional-fields">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="pedi_matricula">Ped. Mat:</label>
                                <input type="text" class="form-control" id="pedi_matricula" name="pedi_matricula">
                            </div>
                            <div class="col-md-6">
                                <label for="modalidad">Modalidad:</label>
                                <input type="text" class="form-control" id="modalidad" name="modalidad">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tipo_presupuesto">Tipo de Presupuesto:</label>
                                <input type="text" class="form-control" id="tipo_presupuesto" name="tipo_presupuesto">
                            </div>
                            <div class="col-md-6">
                                <label for="unidad_respon">Unidad responsable:</label>
                                <input type="text" class="form-control" id="unidad_respon" name="unidad_respon">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="proyecto">Proyecto:</label>
                                <input type="text" class="form-control" id="proyecto" name="proyecto">
                            </div>
                            <?php

// Configuración de la conexión a la base de datos
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'contanuevo';

// Conexión a la base de datos
$conexion = new mysqli($host, $user, $pass, $dbname);

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Función para determinar el estado
function determinarEstado($conexion)
{
    // Consulta SQL para obtener la información más reciente de la tabla num_asi
    $consulta = "SELECT * FROM num_asi ORDER BY FechaEmision DESC LIMIT 1";
    
    // Ejecuta la consulta
    $resultado = $conexion->query($consulta);

    // Verifica si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        // Verifica la condición para determinar el estado
        if ($row['SumaMonto'] < $row['MontoTotal']) {
            return 'Pendiente';
        } else {
            return 'No Aplicable';
        }
    } else {
        // En caso de no encontrar registros
        return 'No Aplicable';
    }
}

// Llama a la función para determinar el estado
$estado = determinarEstado($conexion);

// Cierra la conexión a la base de datos
$conexion->close();
?>

<div class="col-md-6">
    <label for="estado">Estado:</label>
    <input type="text" class="form-control" id="estado" name="estado" value="<?= $estado ?>" readonly>
</div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nro_pac">Nro. Pac:</label>
                                <input type="text" class="form-control" id="nro_pac" name="nro_pac">
                            </div>
                            <div class="col-md-6">
                                <label for="nro_exp">Nro. Exp:</label>
                                <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="total">Total:</label>
                                <input type="text" class="form-control" id="total" name="total">
                            </div>
                            <div class="col-md-6">
                                <label for="pagado">Pagado:</label>
                                <input type="text" class="form-control" id="pagado" name="pagado">
                            </div>
                            <div class="form-group">
                            <?php

                                // Configuración de la base de datos
                                $host = 'localhost';  // Cambia a tu host
                                $usuario = 'root';  // Cambia a tu nombre de usuario
                                $clave = '';  // Cambia a tu contraseña
                                $base_de_datos = 'contanuevo';  // Cambia a tu nombre de base de datos

                                // Crear conexión
                                $conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

                                // Verificar la conexión
                                if ($conexion->connect_error) {
                                    die("La conexión a la base de datos falló: " . $conexion->connect_error);
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


                            <label for="OP">N° Op</label>
                            <input type="text" class="form-control" id="OP"
                                name="OP" value="<?= $op_actual ?>"readonly>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            
                </div>
                <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-flat" onclick="showNotification()"><span
                                    class="fa fa-save"></span>Guardar</button>
                            <div class="notification" id="notification">
                                <div class="icon">
                                </div>
                                <div class="message">Guardado Correctamente</div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones"
                            class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                    </div>
            </div>
        </div>
        </form>

        <thead>
            
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $item): ?>
                    <tr>
                        <td>
                            <?php echo $item->id; ?>
                        </td>
                        <td>
                            <?php echo $item->ruc; ?>
                        </td>
                        <td>
                            <?php echo $item->numero; ?>
                        </td>
                        <td>
                            <?php echo $item->contabilidad; ?>
                        </td>
                        <td>
                            <?php echo $item->direccion; ?>
                        </td>
                        <td>
                            <?php echo $item->telefono; ?>
                        </td>
                        <td>
                            <?php echo $item->observacion; ?>
                        </td>
                        <td>
                            <?php echo $item->fecha; ?>
                        </td>
                        <td>
                            <?php echo $item->tesoreria; ?>
                        </td>
                        <td>
                            <?php echo $item->pedi_matricula; ?>
                        </td>
                        <td>
                            <?php echo $item->modalidad; ?>
                        </td>
                        <td>
                            <?php echo $item->tipo_presupuesto; ?>
                        </td>
                        <td>
                            <?php echo $item->unidad_respon; ?>
                        </td>
                        <td>
                            <?php echo $item->proyecto; ?>
                        </td>
                        <td>
                            <?php echo $item->estado; ?>
                        </td>
                        <td>
                            <?php echo $item->nro_pac; ?>
                        </td>
                        <td>
                            <?php echo $item->nro_exp; ?>
                        </td>
                        <td>
                            <?php echo $item->total; ?>
                        </td>
                        <td>
                            <?php echo $item->pagado; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-view-Pago_de_obligaciones" data-toggle="modal"
                                    data-target="#modal-default" value="<?php echo $data->id; ?>">
                                    <span class="fa fa-search"></span>
                                </button>

                                <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/delete/<?php echo $data->id; ?>"
                                    class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        </table>
    </main>
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
                        <th>Monto de Pago</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Codigo y Descripción CC</th>
                        <th>Origen de Financiamiento</th>
                        <th>Programa</th>
                        <th>Fuente de Financiamiento</th>
                        <th>Suma Monto</th>
                        <th>Estado</th>

                    </tr>
                </thead>
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

        <tr class="list-item" onclick="selectAsi('<?= $asi->ruc_proveedor ?>', '<?= $asi->razso_proveedor ?>', '<?= $asi->numero ?>', '<?= $asi->fecha ?>',
                  '<?= $asi->pagado ?>','<?= $asi->pago ?>','<?= $asi->pagado ?>','<?= $asi->Debe ?>', '<?= $asi->Haber ?>', '<?= $asi->id_ff ?>', '<?= $asi->id_pro ?>', '<?= $asi->id_of ?>','<?= $asi->suma_monto ?>'
                  ,'<?= $asi->IDCuentaContable ?>',  <?= $asi->IDCuentaContable ?>)">
            <td><?= $asi->ruc_proveedor ?></td>
            <td><?= $asi->razso_proveedor ?></td>
            <td><?= $asi->numero ?></td>
            <td><?= $asi->fecha ?></td>
            <td><?= $asi->total ?></td>
            <td><?= $asi->pagado ?></td>
            <td><?= $asi->pago ?></td>
            <td><?= $asi->Debe ?></td>
            <td><?= $asi->Haber ?></td>
            <td><?= $asi->codigo ?> - <?= $asi->descrip ?></td>
            <td><?= $asi->nombre_fuente ?></td>
            <td><?= $asi->nombre_programa ?></td>
            <td><?= $asi->nombre_origen ?></td>
            <td><?= $asi->suma_monto ?></td>
            <td><?= $estado_texto ?></td> <!-- Mostrar el estado en una nueva columna -->
        </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    </div>
</div>



















<script>
    // Función para abrir el modal de búsqueda de cuenta
    function openModalBusqueda() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'flex';
        openModalBtn.style.zIndex = -1;
    }

    // Función para cerrar el modal de búsqueda de cuenta
    function closeModalBusqueda() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'none';
        openModalBtn.style.zIndex = 1;
    }

    // Evento al hacer clic en el botón de búsqueda para abrir el modal
    const openModalBtn = document.getElementById("openModalBtn");
    openModalBtn.addEventListener("click", () => {
        openModalBusqueda();
    });

    // Evento al hacer clic en el botón de cerrar para cerrar el modal de búsqueda
    const closeModalBtn_3 = document.getElementById("closeModalBtn_3");
    closeModalBtn_3.addEventListener("click", () => {
        closeModalBusqueda();
    });

    // Lógica para manejar la búsqueda y actualización de resultados
    document.getElementById('formBusquedaCuenta').addEventListener('submit', function (e) {
        e.preventDefault();

        // Obtener el valor de búsqueda
        var busquedaCuenta = document.getElementById('inputBusquedaCuenta').value;

        // Realizar la lógica de búsqueda (puedes usar AJAX para obtener resultados del servidor)
        // En este ejemplo, simplemente mostramos un mensaje
        document.getElementById('tablaResultadosCuenta').innerHTML = '<p>Resultados para: ' + busquedaCuenta + '</p>';

        // Puedes rellenar los resultados con datos obtenidos del servidor
        // y mostrarlos en la #tablaResultadosCuenta
    });
</script>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Agregar evento al botón "Cancelar"
            const cancelarBtn = document.getElementById("cancelarBtn");
            cancelarBtn.addEventListener("click", function () {
                // Limpia el contenido de la tabla de datos seleccionados
                const tablaDatosSeleccionados = document.getElementById("tablaolilist");
                const tbody = tablaDatosSeleccionados.querySelector("tbody");
                tbody.innerHTML = ""; // Borra todas las filas

                // Oculta el campo de comprobante
                const comprobanteContainer = document.querySelector('.comprobante-container');
                comprobanteContainer.style.display = 'none';
            });

        });

    </script>



<script>
    // Función para abrir el modal
    function openModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'flex';
        openModalBtn.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal_2() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'none';
        openModalBtn.style.zIndex = 1;
    }
 // Agregar evento al botón "Nuevo" para abrir el modal
 const openModalBtn_3 = document.getElementById("openModalBtn");
    openModalBtn_3.addEventListener("click", () => {
        openModal_3();
    });

    // Agregar evento al botón de cerrar para cerrar el modal
    const closeModalBtn_3 = document.getElementById("closeModalBtn_3");
    closeModalBtn_3.addEventListener("click", () => {
        closeModal_3();
    });

</script>

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
        modalContainer.style.display = 'none';2
        openModalBtn.style.zIndex = 1;
    }

    function selectAsi(ruc, razonSocial, numeros, fechas, montos, pagado, montoPagado, debes, habers, fuentes, programas, origens, cuentas, descrip, codigoDescrip) {
    // Actualizar los campos de texto en la vista principal
    console.log(fuentes, programas, origens);
    document.getElementById('ruc').value = ruc;
    document.getElementById('contabilidad').value = razonSocial;
    document.getElementById('tesoreria').value = razonSocial;
    document.getElementById('fecha').value = fechas;
    document.getElementById('num_asi').value = numeros;
    document.getElementById('Debe').value = debes;
    document.getElementById('Haber').value = habers;
    document.getElementById('MontoPago').value = montos;
    document.getElementById('monto_pagado_acumulado').value = montoPagado;
    document.getElementById('id_ff').value = fuentes;
    document.getElementById('id_pro').value = programas;
    document.getElementById('id_of').value = origens;
    document.getElementById('cuentacontable').value = cuentas;
    document.getElementById('cuentacontable').value = descrip;

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
        // Manejar la visibilidad de los campos opcionales
        const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
        const optionalFields = document.querySelector(".optional-fields");

        optionalFieldsSwitch.addEventListener("change", () => {
            if (optionalFieldsSwitch.checked) {
                optionalFields.style.display = "block";
            } else {
                optionalFields.style.display = "none";
            }


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
        fechaInput.value = obtenerFechaActual();
    </script>


<script>
    // Agrega esta pequeña función de JavaScript para actualizar MontoPago al ingresar el Debe
    document.getElementById('Debe').addEventListener('input', function() {
        document.getElementById('MontoPago').value = this.value;
    });
</script>




    <script>
        // Función para abrir el modal de programas
        function openModal_obli() {
            var modalContainer = document.getElementById('modalContainer_obli');
            modalContainer.style.display = 'flex';
        }

        // Función para cerrar el modal de programas
        function closeModal_obli() {
            var modalContainer = document.getElementById('modalContainer_obli');
            modalContainer.style.display = 'none';
        }



        // Agregar evento al botón "Seleccionar Datos" para abrir el modal de programas
        const openModalBtn_obli = document.getElementById("openModalBtn_obli");
        openModalBtn_obli.addEventListener("click", () => {
            openModal_obli();
        });

        // Agregar evento al botón de cerrar para cerrar el modal de programas
        const closeModalBtn_obli = document.getElementById("closeModalBtn_obli");
        closeModalBtn_obli.addEventListener("click", () => {
            closeModal_obli();
        });
    </script>


</body>

</html>