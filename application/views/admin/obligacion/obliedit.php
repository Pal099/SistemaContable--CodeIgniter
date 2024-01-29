<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>assets/css/style_diario_obli.css" rel="stylesheet">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">

</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Movimientos</li>
                <li class="breadcrumb-item"><a
                        href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/add">Diario de
                        Obligación</a></li>
                <li class="breadcrumb-item">Edición de Obligación</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar Obligación</h1>
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
                                                        <input type="text" class="form-control w-100" id="razon_social"
                                                            name="razon_social"
                                                            value="<?php echo $proveedor->razon_social ?>" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha:</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            value="<?php echo date('Y-m-d', strtotime($asiento[0]['datosFijos']['FechaEmision'])); ?>"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="concepto">Concepto:</label>
                                                        <input type="text" class="form-control" id="concepto"
                                                            name="concepto"
                                                            value="<?php echo $asiento[0]['datosFijos']['concepto']; ?>">
                                                    </div>
                                                    <!-- Campos Opcionales del formulario -->
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label for="pedi_matricula">Ped. Mat:</label>
                                                                <input type="text" class="form-control"
                                                                    id="pedi_matricula" name="pedi_matricula"
                                                                    value="<?php echo $asiento[0]['datosFijos']['ped_mat']; ?>">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="modalidad">Modalidad:</label>
                                                                <input type="text" class="form-control" id="modalidad"
                                                                    name="modalidad"
                                                                    value="<?php echo $asiento[0]['datosFijos']['modalidad']; ?>">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="tipo_presupuesto">Tipo de
                                                                    Presupuesto:</label>
                                                                <input type="text" class="form-control w-100"
                                                                    id="tipo_presupuesto" name="tipo_presupuesto"
                                                                    value="<?php echo $asiento[0]['datosFijos']['tipo_presu']; ?>">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="nro_exp">Nro. Exp:</label>
                                                                <input type="text" class="form-control" id="nro_exp"
                                                                    name="nro_exp"
                                                                    value="<?php echo $asiento[0]['datosFijos']['nro_exp']; ?>">
                                                            </div>
                                                            <div class="col-md-4 mb-2">
                                                                <label for="total">Total:</label>
                                                                <input type="text" class="form-control w-100" id="total"
                                                                    name="total"
                                                                    value="<?php echo $asiento[0]['datosFijos']['MontoTotal']; ?>">
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
                                                <table class="table table-hover table-bordered table-sm rounded-3 mt-4"
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
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_pro" name="id_pro">
                                                                        <!-- En este ciclo se busca el id del programa en el array que se envia en la primera posicion, 
                                                                        una vez encuentra ese id en el ciclo lo selecciona y lo muestra en el select -->
                                                                        <?php foreach ($programa as $prog) : ?>
                                                                        <option value="<?php echo $prog->id_pro ?>"
                                                                            <?php echo ($asiento[0]['camposDinamicos'][0]->id_pro == $prog->id_pro) ? 'selected' : ''; ?>>
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
                                                                        <?php foreach ($fuente_de_financiamiento as $ff) : ?>
                                                                        <option value="<?php echo $ff->id_ff ?>"
                                                                            <?php echo ($asiento[0]['camposDinamicos'][0]->id_ff == $ff->id_ff) ? 'selected' : ''; ?>>
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
                                                                        <?php foreach ($origen_de_financiamiento as $of) : ?>
                                                                        <option value="<?php echo $of->id_of ?>"
                                                                            <?php echo ($asiento[0]['camposDinamicos'][0]->id_of == $of->id_of) ? 'selected' : ''; ?>>
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
                                                                        id="idcuentacontable" name="IDCuentacontable"
                                                                        value="<?php echo $asiento[0]['camposDinamicos'][0]->IDCuentaContable ?>">
                                                                    <input style="width: 40%; font-size: small;"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="codigo_cc" name="codigo_cc"
                                                                        value="<?php echo $asiento[0]['camposDinamicos'][0]->Codigo_CC ?>"
                                                                        required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="descripcion_cc" name="descripcion_cc"
                                                                        value="<?php echo $asiento[0]['camposDinamicos'][0]->Descripcion_CC ?>">
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
                                                                        id="comprobante" name="comprobante"
                                                                        value="<?php echo $asiento[0]['camposDinamicos'][0]->Comprobante ?>">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="detalles" name="detalles"
                                                                        value="<?php echo $asiento[0]['camposDinamicos'][0]->detalles ?>"
                                                                        required>
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
                                                                    <select class="form-control border-0 bg-transparent"
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
                                                                    <select class="form-control border-0 bg-transparent"
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
                                                                    <select class="form-control border-0 bg-transparent"
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
                                                                        id="idcuentacontable_2" name="IDCuentacontable"
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
                                                                        id="comprobante_2" name="comprobante"
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
                                                                        class="form-control small border-0 bg-transparent form formatoNumero"
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
                                                        <tr id="filaEdicion" style="display: none;">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botones guardar y cancelar -->
                                <div class="container-fluid mt-3 mb-3">
                                    <div class="col-md-12 d-flex flex-row justify-content-center">
                                        <button style="margin-right: 8px;" type="submit" class="btn btn-success "><span
                                                class="fa fa-save"></span>Guardar</button>
                                        <button type="button" class="btn btn-primary ml-3" onclick=verDatos()>
                                            <i class="fa fa-remove"></i> mirar datos
                                        </button>
                                        <button type="button" class="btn btn-danger ml-3"
                                            onclick="window.location.href='<?php echo base_url(); ?>obligaciones/diario_obligaciones/add'">
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

                    // Aplicar la función formatNumber solo al campo "Haber"
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

        // Eliminar fila
        $("#miTabla").on("click", ".eliminarFila", function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
        });

    });
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
        };
        console.log('Datos de filas: ', JSON.stringify(filas, null, 2));
        console.log('Datos Formulario: ', JSON.stringify(datosFormulario, null, 2));

    }
    </script>

    <!-- Envio de formulario principal -->
    <script>
    $("#formularioPrincipal").on("submit", function() {

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
        };

        console.log('Todos los datos: ', datosCompletos);

        var diferenciaActualizada = parseFloat($("#diferencia").val());

        if (diferenciaActualizada == 0 && diferenciaActualizada >= 0) {
            $.ajax({
                url: '<?php echo base_url("obligaciones/diario_obligaciones/update"); ?>',
                type: 'POST',
                data: {
                    datos: datosCompletos
                },
                //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                success: function(response) {
                    console.log(response);
                    if (response.includes('Datos guardados exitosamente.')) {
                        alert('Datos guardados exitosamente.');
                    } else {
                        alert('Error al guardar los datos: ' + response);
                        console.log(response);
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

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>