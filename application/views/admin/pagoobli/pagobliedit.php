<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>assets/css/style_diario_obli.css" rel="stylesheet">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
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
                <li class="breadcrumb-item"><a
                        href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/add">Pago
                        de Obligaciones</a></li>
                <li class="breadcrumb-item active">Edición del Pago de Obligación</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar Pago</h1>
                    </div>
                    <div class="col-md-6 mt-4 ">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="retencionSwitch">
                                <label class="form-check-label" for="retencionSwitch">Retención</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fin del encabezado -->
                <hr> <!-- barra separadora -->
                <section class="seccion_editar_obligacion">
                    <div class="container-fluid">
                        <div class="row">
                            <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';">
                                <div class="container-fluid mt-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="row g-3 align-items-center mt-2">
                                                        <div class="form-group col-md-2">
                                                            <label for="num_asi">N° asiento:</label>
                                                            <input type="text" class="form-control" id="num_asi"
                                                                name="num_asi"
                                                                value="<?php echo $asiento[0]['datosFijos']['num_asi']; ?>"
                                                                readonly>
                                                        </div>
                                                        <div
                                                            class="form-group col-md-2 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                            <label for="ruc">Ruc:</label>
                                                            <input type="text" class="form-control" id="ruc" name="ruc"
                                                                value="<?php echo $proveedor->ruc ?>" readonly>
                                                            <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="razon_social">Nombre y Apellido:</label>
                                                            <input type="text" class="form-control w-100"
                                                                id="razon_social" name="razon_social"
                                                                value="<?php echo $proveedor->razon_social ?>" readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="fecha">Fecha:</label>
                                                            <input type="date" class="form-control" id="fecha"
                                                                name="fecha"
                                                                value="<?php echo date('Y-m-d', strtotime($asiento[0]['datosFijos']['FechaEmision'])); ?>"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="concepto">Concepto:</label>
                                                            <input type="text" class="form-control" id="concepto"
                                                                name="concepto"
                                                                value="<?php echo $asiento[0]['datosFijos']['concepto']; ?>"
                                                                readonly>
                                                        </div>
                                                        <!-- Campos Opcionales del formulario -->
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4 mb-2">
                                                                    <label for="pedi_matricula">Ped. Mat:</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pedi_matricula" name="pedi_matricula"
                                                                        value="<?php echo $asiento[0]['datosFijos']['ped_mat']; ?>"
                                                                        readonly>
                                                                </div>
                                                                <div class="col-md-4 mb-2">
                                                                    <label for="modalidad">Modalidad:</label>
                                                                    <input type="text" class="form-control"
                                                                        id="modalidad" name="modalidad"
                                                                        value="<?php echo $asiento[0]['datosFijos']['modalidad']; ?>"
                                                                        readonly>
                                                                </div>
                                                                <div class="col-md-4 mb-2">
                                                                    <label for="tipo_presupuesto">Tipo de
                                                                        Presupuesto:</label>
                                                                    <input type="text" class="form-control w-100"
                                                                        id="tipo_presupuesto" name="tipo_presupuesto"
                                                                        value="<?php echo $asiento[0]['datosFijos']['tipo_presu']; ?>"
                                                                        readonly>
                                                                </div>
                                                                <div class="col-md-4 mb-2">
                                                                    <label for="nro_exp">Nro. Exp:</label>
                                                                    <input type="text" class="form-control" id="nro_exp"
                                                                        name="nro_exp"
                                                                        value="<?php echo $asiento[0]['datosFijos']['nro_exp']; ?>"
                                                                        readonly>
                                                                </div>
                                                                <div class="col-md-4 mb-2">
                                                                    <label for="total">Total:</label>
                                                                    <input type="text" class="form-control w-100"
                                                                        id="total" name="total"
                                                                        value="<?php echo $asiento[0]['datosFijos']['MontoTotal']; ?>"
                                                                        readonly>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="op">N° OP</label>
                                                                    <input type="text" class="form-control" id="op"
                                                                        name="op"
                                                                        value="<?php echo $asiento[0]['datosFijos']['op']; ?>"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Aca comienza la tabla -->
                                                    <table
                                                        class="table table-hover table-bordered table-sm rounded-3 mt-4"
                                                        id="miTabla">
                                                        <thead class="align-middle">
                                                            <tr>
                                                                <th class="columna-hidden">IDNum_Asi_Deta</th>
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
                                                            <tr id="PrimeraFila" class="PrimeraFila">
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="IDNum_Asi_Deta" name="IDNum_Asi_Deta"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->IDNum_Asi_Deta ?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_pro" name="id_pro" disabled>
                                                                            <!-- En este ciclo se busca el id del programa en el array que se envia en la primera posicion, 
                                                                        una vez encuentra ese id en el ciclo lo selecciona y lo muestra en el select -->
                                                                            <?php foreach ($programa as $prog) : ?>
                                                                            <option value="<?php echo $prog->id_pro ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][0]->id_pro == $prog->id_pro) ? 'selected' : ''; ?>>
                                                                                <?php echo $prog->codigo; ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <!-- Campo para el valor ya que el select está deshabilitado -->
                                                                        <input type="hidden" name="id_pro"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->id_pro; ?>" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_ff" name="id_ff" disabled>
                                                                            <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                                            <option value="<?php echo $ff->id_ff ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][0]->id_ff == $ff->id_ff) ? 'selected' : ''; ?>>
                                                                                <?php echo $ff->codigo; ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <!-- Campo para el valor ya que el select está deshabilitado -->
                                                                        <input type="hidden" name="id_ff"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->id_ff; ?>" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_of" name="id_of" disabled>
                                                                            <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                                            <option value="<?php echo $of->id_of ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][0]->id_of == $of->id_of) ? 'selected' : ''; ?>>
                                                                                <?php echo $of->codigo; ?>
                                                                            </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <!-- Campo para el valor ya que el select está deshabilitado -->
                                                                        <input type="hidden" name="id_of"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->id_of; ?>" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                        <input type="hidden" class="form-control"
                                                                            id="idcuentacontable"
                                                                            name="IDCuentaContable"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->IDCuentaContable ?>">
                                                                        <input style="width: 40%; font-size: small;"
                                                                            type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="codigo_cc" name="codigo_cc"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->Codigo_CC ?>"
                                                                            readonly>
                                                                        <input style="font-size: small;" type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="descripcion_cc" name="descripcion_cc"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->Descripcion_CC ?>"
                                                                            readonly>
                                                                        <button type="button" data-bs-toggle="modal"
                                                                            data-bs-target="#modalCuentasCont1"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            id="openModalBtn_3" disabled>
                                                                            <i class="bi bi-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="input-group input-group-sm align-items-center  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="comprobante" name="Comprobante"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->Comprobante ?>"
                                                                            readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="detalles" name="detalles"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][0]->detalles ?>"
                                                                            readonly>
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="MontoPago" name="MontoPago"
                                                                            value="<?php echo $asiento[0]['datosFijos']['MontoPagado'] ?>"
                                                                            readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <?php 
                                                                        // Se define $Debe_value como una cadena vacía por defecto
                                                                        $Debe_value = '';
                                                                        if (isset($asiento[0]['camposDinamicos'][0]->Debe)) {
                                                                            $Debe = $asiento[0]['camposDinamicos'][0]->Debe;
                                                                            $Debe_value = number_format($Debe, 0, ',', ',');
                                                                        }
                                                                        ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="Debe" name="Debe"
                                                                            value="<?php echo isset($Debe_value) ? $Debe_value : ''; ?>"
                                                                            oninput="formatNumber('Debe')">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <?php 
                                                                        // Se define $Debe_value como una cadena vacía por defecto
                                                                        $Haber_value = '';
                                                                        if (isset($asiento[0]['camposDinamicos'][0]->Haber)) {
                                                                            $Haber = $asiento[0]['camposDinamicos'][0]->Haber;
                                                                            $Haber_value = number_format($Haber, 0, ',', ',');
                                                                        }
                                                                        ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="Haber" name="Haber"
                                                                            value="<?php echo isset($Haber_value) ? $Haber_value : ''; ?>"
                                                                            oninput="formatNumber('Haber')" required>
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
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            id="IDNum_Asi_Deta_2" name="IDNum_Asi_Deta"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->IDNum_Asi_Deta ?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="id_pro_2" name="id_pro" required>
                                                                            <?php foreach ($programa as $prog) : ?>
                                                                            <option value="<?php echo $prog->id_pro ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][1]->id_pro == $prog->id_pro) ? 'selected' : ''; ?>>
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
                                                                            id="id_ff_2" name="id_ff" required>
                                                                            <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                                            <option value="<?php echo $ff->id_ff ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][1]->id_ff == $ff->id_ff) ? 'selected' : ''; ?>>
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
                                                                            id="id_of_2" name="id_of" required>
                                                                            <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                                            <option value="<?php echo $of->id_of ?>"
                                                                                <?php echo ($asiento[0]['camposDinamicos'][1]->id_of == $of->id_of) ? 'selected' : ''; ?>>
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
                                                                            name="IDCuentaContable"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->IDCuentaContable ?>">
                                                                        <input style="font-size: small; width: 40%"
                                                                            type="text"
                                                                            class="form-control border-0 bg-transparent codigo_cc_2"
                                                                            id="codigo_cc_2" name="Codigo_cc"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->Codigo_CC ?>"
                                                                            required>
                                                                        <input style="font-size: small;" type="text"
                                                                            class="form-control border-0 bg-transparent descripcion_cc_2"
                                                                            id="descripcion_cc_2" name="Descripcion_cc"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->Descripcion_CC ?>">
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
                                                                            id="comprobante_2" name="Comprobante"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->Comprobante ?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="detalles_2" name="detalles"
                                                                            value="<?php echo $asiento[0]['camposDinamicos'][1]->detalles ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="MontoPago_2" name="MontoPago" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <?php 
                                                                    // Se define $haber_2_value como una cadena vacía por defecto
                                                                    $Debe_2_value = '';
                                                                    if (isset($asiento[0]['camposDinamicos'][1]->Debe)) {
                                                                        $Debe_2 = $asiento[0]['camposDinamicos'][1]->Debe;
                                                                        $Debe_2_value = number_format($Debe_2, 0, ',', ','); 
                                                                    }
                                                                    ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent form formatoNumero"
                                                                            id="Debe_2" name="Debe"
                                                                            value="<?php echo isset($Debe_2_value) ? $Debe_2_value : ''; ?>"
                                                                            oninput="formatNumber('Debe_2')">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <?php 
                                                                    // Se define $haber_2_value como una cadena vacía por defecto
                                                                    $haber_2_value = '';
                                                                    if (isset($asiento[0]['camposDinamicos'][1]->Haber)) {
                                                                        $haber_2 = $asiento[0]['camposDinamicos'][1]->Haber;
                                                                        $haber_2_value = number_format($haber_2, 0, ',', ','); 
                                                                    }
                                                                    ?>
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent form formatoNumero haber_reten"
                                                                            id="Haber_2" name="Haber"
                                                                            value="<?php echo isset($haber_2_value) ? $haber_2_value : ''; ?>"
                                                                            oninput="formatNumber('Haber_2')">
                                                                    </div>
                                                                </td>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent"
                                                                            id="cheques_che_id_2" name="cheques_che_id">
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
                                                            <!-- Fila destinada a la edicion -->
                                                            <tr id="filaEdicion" hidden>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm  ">
                                                                        <input type="text"
                                                                            class="form-control small border-0 bg-transparent"
                                                                            name="IDNum_Asi_Deta">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            id="id_pro_din" name="id_pro">
                                                                            <!-- Opciones generadas dinámicamente -->
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="id_ff">
                                                                            <!-- Opciones generadas dinámicamente -->
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <select
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="id_of">
                                                                            <!-- Opciones generadas dinámicamente -->
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                        <input type="hidden"
                                                                            class="form-control border-0 bg-transparent campoDinamico idcuentacontable_edi"
                                                                            name="IDCuentaContable">
                                                                        <input style="font-size: small; width: 40%"
                                                                            type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico codigoCC_edi"
                                                                            name="Codigo_CC">
                                                                        <input style="font-size: small;" type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico descripCC_edi"
                                                                            name="Descripcion_CC">
                                                                        <button type="button" data-bs-toggle="modal"
                                                                            data-bs-target="#modalCuentasCont2"
                                                                            class="btn btn-sm btn-outline-primary openModalBtn_4">
                                                                            <i class="bi bi-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="Comprobante">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="detalles">
                                                                    </div>
                                                                </td>
                                                                <td class="columna-hidden">
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="MontoPago" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="Debe">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                            class="form-control border-0 bg-transparent campoDinamico"
                                                                            name="Haber">
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
                                                            <!-- acá termina la fila de edicion -->
                                                        </tbody>
                                                    </table>
                                                    <!-- Acá termina la tabla -->

                                                    <!-- Tabla del debe y haber diferencia -->
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
                                                            </tr>
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

                                                    <!-- Toast del total para la retencion -->
                                                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                                                        <div id="toastRetenciones" class="toast text-bg-warning"
                                                            role="alert" aria-live="assertive" aria-atomic="true">
                                                            <div class="toast-header">
                                                                <i class="bi bi-exclamation-triangle-fill me-2"
                                                                    style="color: red;"></i>
                                                                <strong class="me-auto">Advertencia</strong>
                                                            </div>
                                                            <div class="toast-body">
                                                                El total de la retención no puede ser mayor que el valor
                                                                del Debe. Por favor, ajusta los
                                                                porcentajes.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Botones guardar y cancelar -->
                                    <div class="container-fluid mt-3 mb-3">
                                        <div class="col-md-12 d-flex flex-row justify-content-center">
                                            <button style="margin-right: 8px;" type="submit"
                                                class="btn btn-success "><span class="fa fa-save"></span>Guardar
                                            </button>
                                            <button type="button" class="btn btn-danger ml-3"
                                                onclick="window.location.href='<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/add'">
                                                <i class="fa fa-remove"></i> Cancelar
                                            </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
    </main>

    <!-- alerta toast -->
    <div id="toastErrorFila" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>

    <!-- Toast del total para la diferencia de Debe y Haber -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastDebeHaber" class="toast text-bg-warning" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-exclamation-triangle-fill me-2" style="color: red;"></i>
                <strong class="me-auto">Advertencia</strong>
            </div>
            <div class="toast-body">
                El debe y el haber no pueden ser diferentes.
            </div>
        </div>
    </div>

    <!-- Modal Proveedores con boostrap -->
    <div class="modal fade mi-modal" id="modal_proveedores" tabindex="-1" aria-labelledby="ModalProveedores"
        aria-hidden="true">
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
                            <?php foreach ($proveedoresALL as $index => $proveedor): ?>
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

    <!-- Script para mostrar los campos de retencion -->
    <script>
    document.getElementById('retencionSwitch').addEventListener('change', function() {
        var calculoderetencion = new bootstrap.Collapse(document.getElementById(
            'calculoderetencion'));
        calculoderetencion.toggle();
    });
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
    <!-- Script para agregar la retencion desde el boton a la tabla -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Definir el objeto cuentasContables
        var cuentasContables = <?php echo json_encode($cuentacontable); ?>;
        // Agregar fila
        function agregarFila(idCuentaContable, valorRetencion) {
            // Clonar la fila base
            var nuevaFila = $("#filaBase").clone();

            // Eliminar el campo IDNum_Asi_Deta de la fila clonada
            nuevaFila.find("input[name='IDNum_Asi_Deta']").remove();

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

    <!-- Script destinado al segundo modal con bootstrap (seleccionar) -->
    <script>
    var currentRow = null;

    // Función para abrir el modal de las cuentas contables
    function openModal_4(currentRowParam) {
        var modalContainer = document.getElementById('modalCuentasCont2');
        currentRow = currentRowParam; // Almacenar la fila actual
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

    // Función para seleccionar la cuenta contable
    function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
        // Verificar si currentRow está definido y no es null
        if (currentRow) {
            // Utilizar currentRow para actualizar los campos
            currentRow.find('.idcuentacontable_2').val(IDCuentaContable);
            currentRow.find('.codigo_cc_2').val(Codigo_CC);
            currentRow.find('.descripcion_cc_2').val(Descripcion_CC);

            // Está parte corresponde a los campos que se traen desde el array
            currentRow.find('.idcuentacontable_edi').val(IDCuentaContable);
            currentRow.find('.codigoCC_edi').val(Codigo_CC);
            currentRow.find('.descripCC_edi').val(Descripcion_CC);
        } else {
            console.error("currentRow no está definido o es null. No se pueden actualizar los campos.");
        }
    }
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
    $(document).ready(function() {
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
    $(document).ready(function() {
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

    <!-- Script para agregar nuevas filas a la tabla -->
    <script>
    $(document).ready(function() {
        function formatNumber(campo) {
            var value = parseFloat(campo.val().replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
            if (!isNaN(value)) {
                campo.val(value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,'));
            }
        }
        //Acá se formatea los campos Dinamicos del haber cuando el usuario ingresa algo

        //Este Script se encarga de crear las opciones del select para los campos que se clonan
        function crearOpciones(datos, select, valorSeleccionado, campoValor, campoTexto) {
            // Se vacía el select antes de agregar nuevas opciones
            select.empty();

            // Recorre los datos y crea una opción para cada elemento
            for (var i = 0; i < datos.length; i++) {
                var opcion = $('<option>');
                opcion.val(datos[i][campoValor]);
                opcion.text(datos[i][campoTexto]);
                select.append(opcion);
            }

            // Selecciona automáticamente la opción correspondiente al valor proporcionado
            select.val(valorSeleccionado);
        }
        //Script para crear filas en base al array de editar
        function crearFila(datos) {
            //Variables para pasar los datos al select
            var programa = <?php echo json_encode($programa); ?>;
            var fuenteF = <?php echo json_encode($fuente_de_financiamiento); ?>;
            var origenF = <?php echo json_encode($origen_de_financiamiento); ?>;

            // Clonar la fila de edicion
            var nuevaFila = $("#filaEdicion").clone();

            // Quitar el atributo 'hidden' del botón Eliminar en la fila clonada
            nuevaFila.find(".eliminarFila").removeAttr('hidden');
            nuevaFila.removeAttr('hidden');

            // Quitar el ID para evitar duplicados en todos los elementos de la fila clonada
            nuevaFila.find("[id]").removeAttr('id');

            // Agregar una clase a todos los elementos de la fila clonada
            nuevaFila.find("select, input").addClass("campoDinamico");

            // Asignar los valores de los campos en la nueva fila basándote en los datos
            nuevaFila.find(".campoDinamico").each(function() {
                var campo = $(this);
                var nombreCampo = campo.attr('name');
                if (datos[nombreCampo]) {
                    campo.val(datos[nombreCampo]);

                    // Aplicar la función formatNumber al campo "Haber" y "Debe"
                    if (nombreCampo === 'Haber' || nombreCampo === 'Debe') {
                        formatNumber(campo);
                        campo.on('input', function() {
                            formatNumber(campo);
                        });
                    }
                }
            });

            // Asignar los valores de los selectores en la nueva fila basándote en los datos
            nuevaFila.find("select.campoDinamico").each(function() {
                var select = $(this);
                var nombreCampo = select.attr('name');

                if (datos[nombreCampo]) {

                    // Seleccionamos el conjunto de datos adecuado según el nombre del campo
                    var conjuntoDatos = [];
                    switch (nombreCampo) {
                        case 'id_pro':
                            conjuntoDatos = programa;
                            campoValor = 'id_pro';
                            campoTexto = 'codigo';
                            break;
                        case 'id_ff':
                            conjuntoDatos = fuenteF;
                            campoValor = 'id_ff';
                            campoTexto = 'codigo';
                            break;
                        case 'id_of':
                            conjuntoDatos = origenF;
                            campoValor = 'id_of';
                            campoTexto = 'codigo';
                            break;
                        default:
                            // Acá se puede manejar de otra forma en caso que no sea ninguno de los otro id
                    }

                    // Llama a la función crearOpciones para generar las opciones del nuevo select
                    crearOpciones(conjuntoDatos, select, datos[nombreCampo], campoValor, campoTexto);
                }
            });

            // Mostrar la nueva fila
            nuevaFila.show();
            return nuevaFila;
        }
        //-----Acá termina la funcion de crear filas de editar-----

        var camposDinamicos =
            <?php echo json_encode($asiento[0]['camposDinamicos']); ?>; // datos de los asientos
        // si camposDinamicos es mayor a 2 objetos entonces se puede iterar para poder agregar los datos de forma dinamica
        if (camposDinamicos.length > 2) {
            for (var i = 2; i < camposDinamicos.length; i++) {
                // Crear una nueva fila basada en los datos del objeto actual
                var nuevaFila = crearFila(camposDinamicos[i]);

                // Agregar la nueva fila al cuerpo de la tabla
                $("#miTabla tbody").append(nuevaFila);
            }
        }

        // Agregar fila
        $(document).on("click", ".agregarFila", function(e) {
            e.preventDefault();
            // Clonar la fila base
            var nuevaFila = $("#filaBase").clone();
            //eliminamos está fila ya que para cada fila unica debe de tener un unico identificador en la base de datos
            nuevaFila.find("#IDNum_Asi_Deta_2").remove();
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
        //array declarado de forma global para poder acceder después en el envio de formulario
        window.idNumAsiDetaEliminados = [];

        // Eliminar fila
        $("#miTabla").on("click", ".eliminarFila", function(e) {
            e.preventDefault();

            // Obtener el valor de IDNum_Asi_Deta antes de eliminar la fila
            var idNumAsiDeta = $(this).closest("tr").find("input[name='IDNum_Asi_Deta']").val();

            if (idNumAsiDeta) {
                // Guardar el IDNum_Asi_Deta en el array global
                window.idNumAsiDetaEliminados.push(idNumAsiDeta);
            }

            // Eliminar la fila
            $(this).closest("tr").remove();

            calcularTotalesYDiferencia();
        });

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

    <!-- Función para formatear números con separadores de miles y dos decimales -->
    <script>
    function formatNumber(inputId) {
        var input = document.getElementById(inputId);
        var value = parseFloat(input.value.replace(/[^\d.-]/g, '')); // Elimina caracteres no numéricos
        if (!isNaN(value)) {
            input.value = value.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,');
        }
    }
    </script>

    <!-- Esta funcion simplemente sirve para el desarrolador -->
    <script>
    function verDatos() {
        //datos que no son de la tabla dinamica
        var datosFormulario = {
            IDNum_Asi: '<?= $asiento[0]['datosFijos']['IDNum_Asi'] ?>',
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
        };

        var filas = [];
        $("#miTabla tbody tr:visible").each(function() {
            var fila = {};

            // Itera sobre los elementos de entrada en la fila
            $(this).find('input, select').each(function() {
                var nombreCampo = $(this).attr('name');
                var valorCampo = $(this).val();

                if (nombreCampo === 'Debe' || nombreCampo === 'Haber') {
                    valorCampo = valorCampo.replace(/[^\d.-]/g, '');
                }
                fila[nombreCampo] = valorCampo;
            });
            fila['Asi_Deta_NULL'] = !('IDNum_Asi_Deta' in fila);
            filas.push(fila);
        });


        // Combinar datos del formulario principal y de las filas dinámicas
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
            filasEliminadas: window.idNumAsiDetaEliminados,
        };

        console.log('Todos los datos: ', JSON.stringify(datosCompletos, null, 2));
    }
    </script>

    <!-- Envio de formulario principal -->
    <script>
    $("#formularioPrincipal").on("submit", function(e) {
        e.preventDefault();
        //validacion de los campos dianmicos para evitar conflictos a la hora de enviar el form
        if ($("#filaEdicion").is(":visible")) {
            var id_pro = $("select[name='id_pro']").val();
            var id_ff = $("select[name='id_ff']").val();
            var id_of = $("select[name='id_of']").val();
            var Debe = $("select[name='Debe']").val();
            var Codigo_CC = $("select[name='Codigo_CC']").val();

            // Lógica de validación
            if (id_pro === "" || id_ff === "" || id_of === "" || Debe === "" || Codigo_CC === "") {
                alert("Por favor, complete todos los campos obligatorios.");
                e.preventDefault(); // Detener el envío del formulario si no pasa la validación
            }
        }

        //datos que no son de la tabla dinamica
        var datosFormulario = {
            IDNum_Asi: '<?= $asiento[0]['datosFijos']['IDNum_Asi'] ?>',
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
        };

        // variable para saber si el debe es igual a haber
        let sumahaber = 0;

        var filas = [];

        $("#miTabla tbody tr:visible").each(function() {
            var fila = {};

            // Itera sobre los elementos de entrada en la fila
            $(this).find('input, select').each(function() {
                var nombreCampo = $(this).attr('name');
                var valorCampo = $(this).val();
                if (nombreCampo === 'Debe' || nombreCampo === 'Haber') {
                    valorCampo = valorCampo.replace(/[^\d.-]/g, '');
                }
                fila[nombreCampo] = valorCampo;
            });
            fila['Asi_Deta_NULL'] = !('IDNum_Asi_Deta' in fila);
            filas.push(fila);
        });


        // Combinar datos del formulario principal y de las filas dinámicas
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
            filasEliminadas: window.idNumAsiDetaEliminados,
        };

        console.log('Todos los datos: ', datosCompletos);

        var diferenciaActualizada = parseFloat($("#diferencia").val());

        if (diferenciaActualizada == 0 && diferenciaActualizada >= 0) {
            $.ajax({
                url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/update"); ?>',
                type: 'POST',
                data: {
                    datos: datosCompletos
                },
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    console.log(response);
                    if (response.success) {
                        console.log(response);
                        redirect =
                            '<?php echo base_url("obligaciones/pago_de_obligaciones/add"); ?>';
                        mostrarAlertaEdicion(redirect);
                    } else {
                        redirect =
                            '<?php echo base_url("obligaciones/pago_de_obligaciones/add"); ?>';
                        mostrarAlertaEdicion(redirect);
                        console.log("Error");
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr
                        .responseText); // Agrega esta línea para ver la respuesta del servidor
                    console.log(datosCompletos);
                    alert("Error en la solicitud AJAX: " + status + " - " + error);
                }
            });
        } else {
            showToastDebe('El debe y el haber no pueden ser diferentes, por favor revise lo ingresado.',
                'text-bg-warning');
            return false;
        }


    });
    </script>

    <!-- Calcula la diferencia de los debes y haberes este script -->
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
        calcularTotalesYDiferencia();
    });
    </script>

    <script>
    $('#id_ff').on('change', function() {
        $(this).prop('selectedIndex', $(this)[0].selectedIndex);
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
</body>

</html>