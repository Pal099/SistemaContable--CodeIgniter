<!DOCTYPE html>
<html lang="es">

<head>
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Script para el sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('assets/sweetalert-helper/sweetAlertHelper.js'); ?>"></script>
</head>


<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>patrimonio/Comprobante_Gasto">Comprobante
                        Gastos</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/Comprobante_Gasto">Listado
                        Comprobantes de Gastos</a></li>
                <li class="breadcrumb-item">Agregar Comprobante Gastos</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar Comprobante Gastos</h1>
                    </div>

                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">

                                                    <!-- Nro. de Comprobante -->
                                                    <div class="form-group col-md-2">
                                                        <label for="npedido">Nro. de Comprobante:</label>
                                                        <input type="number" class="form-control" id="npedido"
                                                            name="npedido" value="<?php echo $nextPedido; ?>" required
                                                            readonly>
                                                    </div>

                                                    <!-- RUC -->
                                                    <div
                                                        class="form-group col-md-2 <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                        <label for="ruc">RUC:</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc"
                                                            readonly>
                                                        <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                                                    </div>

                                                    <!-- Id Proveedor -->
                                                    <input type="hidden" id="idproveedor" name="idproveedor">

                                                    <!-- Razón Social -->
                                                    <div class="form-group col-md-4">
                                                        <label for="razon_social">Razón Social:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="razon_social"
                                                                name="razon_social" required readonly>
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalContainer_proveedores">
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Fecha -->
                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha:</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            placeholder="Ej. YYYY/MM/DD" required>
                                                    </div>

                                                    <!-- Actividad -->
                                                    <div class="form-group col-md-6">
                                                        <label for="id_unidad">Actividad:</label>
                                                        <select name="id_unidad" id="id_unidad" class="form-control"
                                                            required>
                                                            <?php foreach ($unidad as $uni): ?>
                                                                <option value="<?php echo $uni->id_unidad ?>">
                                                                    <?php echo $uni->unidad . ' - ' . $uni->id_unidad; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <!-- Tipo -->
                                                    <div class="form-group col-md-6">
                                                        <label for="tipo">Tipo:</label>
                                                        <select class="form-select" id="tipo" name="tipo">
                                                            <option value="">Factura Credito</option>
                                                            <option value="x">Factura X</option>
                                                            <option value="y">Factura Y</option>
                                                            <option value="z">Factura Z</option>
                                                        </select>
                                                    </div>

                                                    <!-- Concepto -->
                                                    <div class="form-group col-md-12">
                                                        <label for="concepto">Concepto:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="concepto"
                                                                name="concepto" required>
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalPresupuestos"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"></i> Buscar Presupuesto
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="rubroSeleccionado" class="badge bg-primary mt-3 p-2 fs-7">
                                                    Rubro Seleccionado: <span id="rubroTexto"
                                                        class="fw-bold">Ninguno</span>
                                                </div>
                                                <div id="loading-saldo" style="display:none">
                                                    <i class="bi bi-arrow-clockwise"></i> Verificando saldo...
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <section class="seccion_tabla">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="container-fluid mt-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="card border">
                                                <div class="card-body mt-4">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="tablaP">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>Nro de Pedido</th>
                                                                    <th>Actividad</th>
                                                                    <th>Rubro</th>
                                                                    <th>Descripción</th>
                                                                    <th>Precio Unit</th>
                                                                    <th>Cantidad</th>
                                                                    <th>IVA</th>
                                                                    <th>Porcentaje IVA (%)</th>
                                                                    <th>Exenta</th>
                                                                    <th>Gravada</th>
                                                                    <th>Seleccionar Bien</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr id="filaB" class="filaB">
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent index"
                                                                                id="item" name="item" value="1"
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="number"
                                                                                class="form-control border-0 bg-transparent npedido"
                                                                                id="npedido" name="npedido"
                                                                                value="<?php echo $nextPedido; ?>"
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent actividad"
                                                                                id="actividad" name="actividad"
                                                                                value="1" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td hidden>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center">
                                                                            <input type="number"
                                                                                class="form-control border-0 bg-transparent IDbienservicio"
                                                                                id="id_item" name="id_item" value=""
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td hidden>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center">
                                                                            <input type="number"
                                                                                class="form-control border-0 bg-transparent IDpresupuesto"
                                                                                id="idpresupuesto" name="idpresupuesto"
                                                                                value="" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent rubro"
                                                                                id="rubro" name="rubro" value=""
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent descripcion"
                                                                                id="descrip" name="descrip" value=""
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent precioref"
                                                                                id="precioref" name="precioref"
                                                                                value="">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="number"
                                                                                class="form-control border-0 bg-transparent cantidad"
                                                                                id="cantidad" name="cantidad" value=""
                                                                                required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input type="checkbox"
                                                                                class="form-check-input iva iva-checkbox"
                                                                                id="iva" name="iva" value="">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="number"
                                                                                class="form-control border-0 bg-transparent piva"
                                                                                id="piva" name="piva" value="" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent exenta"
                                                                                id="exenta" name="exenta" value=""
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <input type="text"
                                                                                class="form-control border-0 bg-transparent gravada"
                                                                                id="gravada" name="gravada" value=""
                                                                                readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="input-group input-group-sm align-items-center  ">
                                                                            <button type="button" data-bs-toggle="modal"
                                                                                data-bs-target="#modalBienes"
                                                                                class="btn btn-primary openModalBtn_4">
                                                                                <i class="bi bi-search">
                                                                                </i>
                                                                            </button>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="container-fluid mt-3 mb-3">
                        <div class="col-md-12 d-flex flex-row justify-content-center">
                            <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span
                                    class="fa fa-save"></span>Guardar</button>
                            <button class="btn btn-danger ml-3"
                                onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto'">
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
    <!-- Modal Presupuestos -->
    <div class="modal fade" id="modalPresupuestos" tabindex="-1" aria-labelledby="modalPresupuestosLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Selección de Rubro Presupuestario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Solo se muestran rubros con presupuesto vigente para <?= date('F Y') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <table class="table table-hover table-sm table-striped" id="TablaPresupuestoModal">
                        <thead class="table-dark">
                            <tr>
                                <th>Año</th>
                                <th>Cuenta</th>
                                <th>Rubro</th>
                                <th>Presupuesto</th>
                                <th>Saldo Disponible
                                    <i class="bi bi-info-circle ms-1" data-bs-toggle="tooltip"
                                        title="Calculado en tiempo real al seleccionar">
                                    </i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos_vista as $dato):
                                $saldo = $dato['saldo_actual'];
                                $clase_fila = $saldo <= 0 ? 'table-danger' : '';
                                $icono = $saldo <= 0 ? '<i class="bi bi-lock-fill text-danger"></i>' : '<i class="bi bi-unlock-fill text-success"></i>';
                                ?>
                                <tr class="list-item <?= $clase_fila ?>" onclick="selectPresupuesto(
                                    '<?= $dato['ID_Presupuesto'] ?>', 
                                    '<?= htmlspecialchars($dato['rubro'], ENT_QUOTES) ?>',
                                    <?= $saldo ?>
                                )">
                                    <td><?= date('Y', strtotime($dato['Año'])) ?></td>
                                    <td><?= $dato['codigo'] ?></td>
                                    <td><?= $dato['rubro'] ?></td>
                                    <td class="text-end">$<?= number_format($dato['TotalPresupuestado'], 2) ?></td>
                                    <td class="text-end <?= $saldo > 0 ? 'text-success' : 'text-danger' ?>">
                                        $<?= number_format($saldo, 2) ?>
                                        <?= $icono ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalBienes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-presupuesto-large" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Rubros Asociados al Código</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="TablaBienesModal" style="width:100%">
                        <thead>
                            <tr>
                                <th class="columna-hidden"></th>
                                <th>#</th>
                                <th>Código</th>
                                <th>Rubro</th>
                                <th>Descripción</th>
                                <th>Catálogo</th>
                                <th>Descripción de Catálogo</th>
                                <th>Precio Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bienes_servicios as $index => $bienes): ?>
                                <tr class="list-item" onclick="selectBien('<?= $bienes->IDbienservicio ?>', '<?= $bienes->rubro ?>',
                            '<?= $bienes->descripcion ?>', '<?= $bienes->precioref ?>')" data-bs-dismiss="modal"
                                    data-rubro="<?= $bienes->rubro ?>">
                                    <td class="columna-hidden"><?= $bienes->IDbienservicio ?></td>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $bienes->codigo ?></td>
                                    <td><?= $bienes->rubro ?></td>
                                    <td><?= $bienes->descripcion ?></td>
                                    <td><?= $bienes->codcatalogo ?></td>
                                    <td><?= $bienes->descripcioncatalogo ?></td>
                                    <td><?= $bienes->precioref ?></td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                                    onclick="selectProveedor('<?= $proveedor->id ?>', '<?= $proveedor->ruc ?>', '<?= $proveedor->razon_social ?>')"
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
</body>
<script>
    $("#formularioPrincipal").on("submit", function (event) {
        event.preventDefault();

        const ivac = $("input[name='iva']").is(':checked') ? 1 : 0;

        const datosFormulario = {
            fecha: $("#fecha").val(),
            id_unidad: $("#id_unidad").val(),
            id_pedido: $("#id_pedido").val(),
            concepto: $("#concepto").val(),
            idproveedor: $("#idproveedor").val(),
            idpresupuesto: $("#idpresupuesto").val(),
        };

        let filas = [];

        $("#tablaP tbody tr").each(function () {
            const fila = {
                id_pedido: $(this).find("input[name='npedido']").val(),
                id_unidad: $(this).find("input[name='id_unidad']").val(),
                id_item: $(this).find("input[name='id_item']").val(),
                rubro: $(this).find("input[name='rubro']").val(),
                iva: ivac,
                descripcion: $(this).find("input[name='descrip']").val(),
                precioUnit: $(this).find("input[name='precioref']").val(),
                cantidad: $(this).find("input[name='cantidad']").val(),
                piva: $(this).find("input[name='piva']").val(),
                exenta: $(this).find("input[name='exenta']").val(),
                gravada: $(this).find("input[name='gravada']").val(),
            };

            filas.push(fila);
        });

        const datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
        };

        $.ajax({
            url: '<?php echo base_url("patrimonio/comprobante_gasto/store"); ?>',
            type: 'POST',
            data: {
                datos: datosCompletos
            },
            success: function (response) {
                if (response === "success") {
                    mostrarAlertaExito();
                } else {
                    alert('Error al guardar los datos: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                console.log(datosCompletos);
                alert("Error en la solicitud AJAX: " + status + " - " + error);
            }
        });
    });
</script>
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

        $('#modalBienes').on('show.bs.modal', function () {
            console.log('Rubro Seleccionado al abrir el modal:', rubroSeleccionado);

            if (rubroSeleccionado) {
                $('#TablaBienesModal tbody tr').each(function () {
                    var rubroBien = $(this).find('td').eq(3).text()
                        .trim(); // Obtiene el rubro de la 4ta columna (índice 3)

                    if (rubroBien !== rubroSeleccionado) {
                        $(this).hide(); // Oculta la fila si el rubro no coincide
                    } else {
                        $(this).show(); // Muestra la fila si el rubro coincide
                    }
                });
            } else {
                alert('Seleccione un presupuesto primero');
            }
        });



    });
</script>
<script>
    $(document).ready(function () {
        $('#TablaBienesModal').DataTable({
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
<script>
    var currentRow = null;


    // Función para abrir el modal de las cuentas contables
    function openModal_4(currentRowParam) {

        var modalContainer = document.getElementById('modalBienes');

        currentRow = currentRowParam; // Almacenar la fila actual

    }


    // Función para seleccionar la cuenta contable
    function selectBien(IDbienservicio, rubro, descripcion, precioref) {
        // Verificar si currentRow está definido y no es null
        if (currentRow) {
            // Utilizar currentRow para actualizar los campos
            currentRow.find('.IDbienservicio').val(IDbienservicio);
            currentRow.find('.rubro').val(rubro);
            currentRow.find('.descripcion').val(descripcion);
            currentRow.find('.precioref').val(precioref);

        } else {
            console.error("currentRow no está definido o es null. No se pueden actualizar los campos.");
        }
    }
    var currentRow = null;

    // Función para abrir el modal de las cuentas contables
    function openModal_4(currentRowParam) {

        var modalContainer = document.getElementById('modalBienes');

        currentRow = currentRowParam; // Almacenar la fila actual

    }
/*     let rubroSeleccionado = ''; // Variable global para almacenar el rubro seleccionado

    function selectPresupuesto(idpresupuesto, rubro) {


        // Actualiza el texto en el contenedor #rubroTexto con la relación
        $('#idpresupuesto').text(idpresupuesto);
        $('#rubroTexto').text(rubro); // Este es el campo donde se debe mostrar la relación

        // Almacena el rubro seleccionado
        rubroSeleccionado = rubro;
    } */



    function selectProveedor(id, ruc, razon_social) {
        document.getElementById('idproveedor').value = id;
        document.getElementById('ruc').value = ruc;
        document.getElementById('razon_social').value = razon_social;

    }

    // Abrir modal en fila dinamica
    const openModalBtn_4 = document.getElementById("openModalBtn_4");
    // Actualiza la función de clic para pasar la fila actual al abrir el modal
    document.getElementById("tablaP").addEventListener("click", function (event) {

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

    function filtrarBienesPorRubro(relacion) {
        // Recorrer todas las filas del modal y filtrar por el rubro
        $('#TablaBienesModal tbody tr').each(function () {
            var row = $(this);
            var rubro = row.data('rubro'); // Obtener el rubro desde el atributo data-rubro

            // Si el rubro está en la relación, mostramos la fila; de lo contrario, la ocultamos
            if (relacion.includes(rubro)) {
                row.show(); // Mostrar la fila
            } else {
                row.hide(); // Ocultar la fila
            }
        });
    }




    // Evento para desmarcar el checkbox
    $(document).on("click", ".desmarcarCheckbox", function () {
        var row = $(this).closest('tr');
        row.find('.iva-checkbox').prop('checked', false)
            .change(); // Usar change() para activar el manejador de eventos
    });

    $('#id_unidad').on('change', function () {
        var selectedValue = $(this).val();
        $('.actividad').val(selectedValue);
        //$('#rubro').val(selectedValue);
    });

    $('#tablaP').on('input', '.precioref, .cantidad', function () {
        var $row = $(this).closest('tr');
        var precio = $row.find('.precioref').val();
        var cantidad = $row.find('.cantidad').val();
        var piva = $row.find('.piva').val();
        var exenta = precio * cantidad;
        $row.find('.exenta').val(exenta.toFixed(0));
    });
</script>
<!-- Script de Validación Dinámica -->
<script>
let rubroSeleccionado = '';
const mesActual = <?= date('n') ?>;

function selectPresupuesto(idpresupuesto, rubro, saldoTabla) {
    // Validación inicial desde datos pre-cargados
    if (saldoTabla <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Bloqueado',
            html: `<b>${rubro}</b><br>Saldo insuficiente en registros`,
            confirmButtonText: 'Entendido'
        });
        return;
    }

    // Validación en tiempo real via AJAX
    $.ajax({
        url: '<?= base_url('comprobante_gasto/verificar_saldo') ?>',
        method: 'POST',
        data: { id_presupuesto: idpresupuesto },
        dataType: 'json',
        beforeSend: function() {
            $('#loading-saldo').show();
        },
        complete: function() {
            $('#loading-saldo').hide();
        },
        success: function(response) {
            if (response.status === 'success') {
                if (parseFloat(response.saldo) > 0) {
                    asignarPresupuesto(idpresupuesto, rubro, response.saldo);
                } else {
                    bloquearSeleccion(rubro, 'Saldo actualizado a $' + response.saldo);
                }
            } else {
                manejarErrorPresupuesto(response.message, rubro);
            }
        },
        error: function(xhr) {
            manejarErrorPresupuesto('Error de conexión', rubro);
        }
    });
}

function asignarPresupuesto(id, rubro, saldo) {
    $('#rubroTexto').html(`
        ${rubro}<br>
        <small class="text-success">
            Saldo confirmado: $${saldo}
        </small>
    `);
    $('#idPresupuestoSeleccionado').val(id);
    rubroSeleccionado = rubro;
}

function bloquearSeleccion(rubro, motivo) {
    Swal.fire({
        icon: 'warning',
        title: 'Cambio detectado',
        html: `<b>${rubro}</b><br>${motivo}`,
        confirmButtonText: 'Actualizar lista'
    }).then(() => {
        location.reload(); // Recarga para actualizar datos
    });
}

function manejarErrorPresupuesto(mensaje, rubro) {
    Swal.fire({
        icon: 'error',
        title: 'Error técnico',
        html: `<b>${rubro}</b><br>${mensaje}`,
        confirmButtonText: 'Reportar'
    });
}
</script>
<script>
    $(document).ready(function () {
        var indice = 1;

        // Agregar fila
        $(document).on("click", ".agregarFila", function (e) {
            e.preventDefault();
            indice++;

            // Clonar la fila base
            var nuevaFila = $("#filaB").clone();
            nuevaFila.find(".eliminarFila").removeAttr('hidden');
            nuevaFila.find("[id]").removeAttr('id');
            nuevaFila.find("select, input").addClass("filaClonada");
            nuevaFila.find("select, input").not('.index, .npedido, .actividad').val("");
            nuevaFila.find(".index").val(indice);
            nuevaFila.find(".piva").prop('readonly', true);
            nuevaFila.find(".iva-checkbox").prop('checked', false);
            nuevaFila.show();

            // Agregar la nueva fila al cuerpo de la tabla
            $("#tablaP tbody").append(nuevaFila);
        });




        // Eliminar fila
        $("#tablaP").on("click", ".eliminarFila", function (e) {
            e.preventDefault();
            $(this).closest("tr").remove();
        });

        // Manejar el cambio en la casilla de verificación y los campos
        $(document).on("change", ".iva-checkbox, .precioref, .cantidad, .piva", function () {
            var row = $(this).closest('tr');
            actualizarValores(row);
        });

        // Función para actualizar los valores de exenta y gravada
        function actualizarValores(row) {
            var precio = parseFloat(row.find('.precioref').val()) || 0;
            var cantidad = parseFloat(row.find('.cantidad').val()) || 0;
            var piva = parseFloat(row.find('.piva').val()) || 0;

            if (row.find('.iva-checkbox').is(':checked')) {
                // Si el IVA está marcado
                var gravada = precio * cantidad * (1 + piva / 100);
                row.find('.gravada').val(gravada.toFixed(0)); // Asignar valor a gravada
                row.find('.exenta').val(0); // Exenta debe ser 0
                row.find('.piva').prop('readonly', false); // Habilitar el campo de IVA
            } else {
                // Si el IVA no está marcado
                var exenta = precio * cantidad;
                row.find('.exenta').val(exenta.toFixed(0)); // Asignar valor a exenta
                row.find('.gravada').val(0); // Gravada debe ser 0
                row.find('.piva').val(''); // Limpiar el valor del IVA
                row.find('.piva').prop('readonly', true); // Deshabilitar el campo de IVA
            }
        }

        // Inicializar el estado de las filas al cargar la página
        $("#tablaP tbody tr").each(function () {
            var row = $(this);
            actualizarValores(row);
        });

    });
</script>
<script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>

</html>