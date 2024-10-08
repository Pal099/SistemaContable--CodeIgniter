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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>patrimonio/Comprobante_Gasto">Comprobante
                        Gastos</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/Comprobante_Gasto">Listado
                        Presupuesto</a></li>
                <li class="breadcrumb-item">Editar Comprobante Gastos</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar Comprobante Gastos</h1>
                    </div>
                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';"
                            action="<?php echo base_url('patrimonio/Comprobante_Gasto/update'); ?>" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <div class="form-group col-md-4">
                                                        <label for="id_unidad">Actividad:</label>
                                                        <select name="id_unidad" id="id_unidad" class="form-control"
                                                            required>
                                                            <?php foreach ($uni as $unidad): ?>
                                                                <option value="<?php echo $unidad->id_unidad; ?>" <?php echo ($unidad->id_unidad == $comprobante->id_unidad) ? 'selected' : ''; ?>>
                                                                    <?php echo $unidad->unidad . ' - ' . $unidad->id_unidad; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <!-- Tipo -->
                                                    <div class="form-group col-md-4">
                                                        <label for="tipo">Tipo:</label>
                                                        <select class="form-select" id="periodo" name="periodo">
                                                            <option value="">Factura Credito</option>
                                                            <option value="x">Factura X</option>
                                                            <option value="y">Factura Y</option>
                                                            <option value="z">Factura Z</option>
                                                        </select>
                                                    </div>

                                                    <!-- Número de Comprobante (readonly) -->
                                                    <div class="form-group col-md-4">
                                                        <label for="id_pedido">Nro. de Comprobante:</label>
                                                        <input type="number" class="form-control" id="id_pedido"
                                                            name="id_pedido"
                                                            value="<?php echo $comprobante->id_pedido; ?>" required
                                                            readonly>
                                                    </div>

                                                    <!-- Proveedor -->
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select name="idproveedor" id="idproveedor"
                                                                class="form-control" required>
                                                                <option selected disabled>Seleccione un Proveedor...
                                                                </option>
                                                                <?php foreach ($proveedores as $prov): ?>
                                                                    <option value="<?php echo $prov->id; ?>" <?php echo ($prov->id == $comprobante->idproveedor) ? 'selected' : ''; ?>>
                                                                        <?php echo $prov->razon_social; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalProveedores"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar</i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Fecha -->
                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            value="<?php echo $comprobante->fecha; ?>" required>
                                                    </div>

                                                    <!-- Concepto -->
                                                    <div class="form-group col-md-6">
                                                        <label for="concepto">Concepto:</label>
                                                        <input type="text" class="form-control" id="concepto"
                                                            name="concepto"
                                                            value="<?php echo $comprobante->concepto; ?>" required>
                                                    </div>

                                                    <!-- Presupuesto -->
                                                    <div class="col-md-4">
                                                        <div class="form-group input-group">
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalPresupuestos"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar Presupuesto</i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Tabla de detalles de comprobante -->
                                                    <section class="seccion_tabla">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="container-fluid mt-2">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-md-12">
                                                                            <div class="card border">
                                                                                <div class="card-body mt-4">
                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-bordered"
                                                                                            id="tablaC">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Item</th>
                                                                                                    <th>ID Comprobante Gasto</th>
                                                                                                    <th>Nro de Pedido
                                                                                                    </th>
                                                                                                    <th>Actividad</th>
                                                                                                    <th>Rubro</th>
                                                                                                    <th>Descripción</th>
                                                                                                    <th>Precio Unit</th>
                                                                                                    <th>Cantidad</th>
                                                                                                    <th>IVA</th>
                                                                                                    <th>Porcentaje IVA
                                                                                                        (%)</th>
                                                                                                    <th>Exenta</th>
                                                                                                    <th>Gravada</th>
                                                                                                    <th>Seleccionar Bien
                                                                                                    </th>
                                                                                                    <th>Acciones</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            <?php foreach ($comprobantesPedido as $comprobanteP): ?>
                                                                                                <tr id="filaB"
                                                                                                    class="filaB">
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent index"
                                                                                                                id="id_item"
                                                                                                                name="id_item"
                                                                                                                value="<?php echo $comprobanteP->id_item; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent id"
                                                                                                                id=" IDComprobanteGasto"
                                                                                                                name=" IDComprobanteGasto"
                                                                                                                value="<?php echo $comprobanteP-> IDComprobanteGasto; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control border-0 bg-transparent id_pedido"
                                                                                                                id="id_pedido"
                                                                                                                name="id_pedido"
                                                                                                                value="<?php echo $comprobanteP->id_pedido; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent id_unidad"
                                                                                                                id="id_unidad"
                                                                                                                name="id_unidad"
                                                                                                                value="<?php echo $comprobanteP->id_unidad; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td hidden>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control border-0 bg-transparent IDbienservicio"
                                                                                                                id="id_item"
                                                                                                                name="id_item"
                                                                                                                value="<?php echo $comprobanteP->id_item; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td hidden>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control border-0 bg-transparent IDpresupuesto"
                                                                                                                id="idpresupuesto"
                                                                                                                name="idpresupuesto"
                                                                                                                value="<?php echo $comprobanteP->idpresupuesto; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent rubro"
                                                                                                                id="rubro"
                                                                                                                name="rubro"
                                                                                                                value="<?php echo isset($rubro) ? $rubro : ''; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent descripcion"
                                                                                                                id="descrip"
                                                                                                                name="descrip"
                                                                                                                value="<?php echo $comprobanteP->descripcion; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent preciounit"
                                                                                                                id="preciounit"
                                                                                                                name="preciounit"
                                                                                                                value="<?php echo $comprobanteP->preciounit; ?>">
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control border-0 bg-transparent cantidad"
                                                                                                                id="cantidad"
                                                                                                                name="cantidad"
                                                                                                                value="<?php echo $comprobanteP->cantidad; ?>"
                                                                                                                required>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="form-check">
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                class="form-check-input iva iva-checkbox"
                                                                                                                id="iva"
                                                                                                                name="iva"
                                                                                                                <?php echo ($comprobanteP->porcentaje_iva > 0) ? 'checked' : ''; ?>>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control border-0 bg-transparent porcentaje_iva"
                                                                                                                id="porcentaje_iva"
                                                                                                                name="porcentaje_iva"
                                                                                                                value="<?php echo $comprobanteP->porcentaje_iva; ?>"
                                                                                                                readonly>
                                                                                                            <div
                                                                                                                class="form-group">
                                                                                                            </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent exenta"
                                                                                                                id="exenta"
                                                                                                                name="exenta"
                                                                                                                value="<?php echo $comprobanteP->exenta; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control border-0 bg-transparent gravada"
                                                                                                                id="gravada"
                                                                                                                name="gravada"
                                                                                                                value="<?php echo $comprobanteP->gravada; ?>"
                                                                                                                readonly>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="input-group input-group-sm align-items-center">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                data-bs-toggle="modal"
                                                                                                                data-bs-target="#modalBienes"
                                                                                                                class="btn btn-primary openModalBtn_4">
                                                                                                                <i
                                                                                                                    class="bi bi-search">
                                                                                                                </i>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div
                                                                                                            class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-outline-primary border-0 agregarFila">
                                                                                                                <i
                                                                                                                    class="bi bi-plus-square"></i>
                                                                                                            </button>
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-outline-danger border-0 eliminarFila"
                                                                                                                hidden>
                                                                                                                <i
                                                                                                                    class="bi bi-trash3"></i>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php endforeach; ?>
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
                                                            <button style="margin-right: 8px;" type="submit"
                                                                class="btn btn-success btn-primary"><span
                                                                    class="fa fa-save"></span>Guardar</button>
                                                            <button class="btn btn-danger ml-3"
                                                                onclick="window.location.href='<?php echo base_url(); ?>patrimonio/Comprobante_Gasto'">
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
    <div class="modal fade" id="modalPresupuestos" tabindex="-1" aria-labelledby="modalPresupuestosLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rubros Asociados al Código</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Periodo</th>
                                <th>Programa</th>
                                <th>Cuenta Contable</th>
                                <th>Rubro</th>
                                <th>FF</th>
                                <th>OF</th>
                                <th>Dpto</th>
                                <th>Presupuestado</th>
                                <th>Saldo Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos_vista as $dato): ?>
                                <tr class="list-item presupuesto-item"
                                    data-programa-id-pro="<?= $dato['programa_id_pro'] ?>"
                                    data-fuente-de-financiamiento-id-ff="<?= $dato['fuente_de_financiamiento_id_ff'] ?>"
                                    data-origen-de-financiamiento-id-of="<?= $dato['origen_de_financiamiento_id_of'] ?>"
                                    data-bs-dismiss="modal"></tr>
                                <tr class="list-item" onclick="selectPresupuesto('<?= $dato['ID_Presupuesto'] ?>')"
                                    data-bs-dismiss="modal">
                                    <td><?= $dato['Año'] ?></td>
                                    <td><?= $dato['programa_id_pro'] ?></td>
                                    <td><?= $dato['codigo'] ?></td>
                                    <td><?= $dato['rubro'] ?></td>
                                    <td><?= $dato['fuente_de_financiamiento_id_ff'] ?></td>
                                    <td><?= $dato['origen_de_financiamiento_id_of'] ?></td>
                                    <td><?= $dato['programa_id_pro'] ?></td>
                                    <td><?= $dato['TotalPresupuestado'] ?></td>
                                    <td><?= $dato['saldo_actual'] /*Saldo actual sale del ultimo mes que se cargó*/ ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBienes" tabindex="-1" aria-labelledby="modalBienesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rubros Asociados al Código</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="columna-hidden"></th>
                                <th>#</th>
                                <th>Código</th>
                                <th>Rubro</th>
                                <th>Descripción</th>
                                <th>Catálogo</th>
                                <th>Descripción de Catálogo</th>
                                <th>Precio Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bienes_servicios as $index => $bienes): ?>
                                <tr class="list-item" onclick="selectBien('<?= $bienes->IDbienservicio ?>', '<?= $bienes->rubro ?>',
                                    '<?= $bienes->descripcion ?>', '<?= $bienes->preciounit ?>')"
                                    data-bs-dismiss="modal">
                                    <td class="columna-hidden">
                                        <?= $bienes->IDbienservicio ?>
                                    </td>
                                    <td>
                                        <?= $index + 1 ?>
                                    </td>
                                    <td>
                                        <?= $bienes->codigo ?>
                                    </td>
                                    <td>
                                        <?= $bienes->rubro ?>
                                    </td>
                                    <td>
                                        <?= $bienes->descripcion ?>
                                    </td>
                                    <td>
                                        <?= $bienes->codcatalogo ?>
                                    </td>
                                    <td>
                                        <?= $bienes->descripcioncatalogo ?>
                                    </td>
                                    <td>
                                        <?= $bienes->preciounit ?>
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

        var ivac = $(this).find("input[name='iva']").is(':checked') ? 1 : 0;

        var datosFormulario = {
            fecha: $("#fecha").val(),
            id_unidad: $("#id_unidad").val(),
            IDComprobanteGasto: $("#IDComprobanteGasto").val(),
            concepto: $("#concepto").val(),
            idproveedor: $("#idproveedor").val(),

        };

        var filas = [];

        $("#tablaC tbody tr").each(function () {
            var fila = {
                id_pedido: $(this).find("input[name='id_pedido']").val(),
                IDComprobanteGasto: $(this).find("input[name=' IDComprobanteGasto']").val(),
                id_unidad: $(this).find("input[name='id_unidad']").val(),
                id_item: $(this).find("input[name='id_item']").val(),
                //idpresupuesto: $(this).find("input[name='idpresupuesto']").val(),
                rubro: $(this).find("input[name='rubro']").val(),
                iva: ivac,
                descripcion: $(this).find("input[name='descrip']").val(),
                precioUnit: $(this).find("input[name='preciounit']").val(),
                cantidad: $(this).find("input[name='cantidad']").val(),
                porcentaje_iva: $(this).find("input[name='porcentaje_iva']").val(),
                exenta: $(this).find("input[name='exenta']").val(),
                gravada: $(this).find("input[name='gravada']").val(),
            };

            filas.push(fila);
        });

        // Combinar datos del formulario principal y de las filas dinámicas
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
        };

        // Mostrar los datos antes de enviarlos
        //alert("Datos del formulario: " + JSON.stringify(datosCompletos));
        console.log("Datos del formulario: ", JSON.stringify(datosCompletos));

        // Enviamos los datos al controlador mediante AJAX
        $.ajax({
            url: '<?php echo base_url("patrimonio/comprobante_gasto/update"); ?>',
            type: 'POST',
            data: {
                datos: datosCompletos
            },
            // Asumimos que la respuesta es texto plano
            success: function (response) {

                if (response === "success") {
                    window.location.href = '<?php echo base_url("patrimonio/comprobante_gasto"); ?>';
                } else {
                    alert('Error al guardar los datos: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText); // Agrega esta línea para ver la respuesta del servidor
                console.log(datosCompletos);
                alert("Error en la solicitud AJAX: " + status + " - " + error);
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
    function selectBien(IDbienservicio, rubro, descripcion, preciounit) {
        // Verificar si currentRow está definido y no es null
        if (currentRow) {
            // Utilizar currentRow para actualizar los campos
            currentRow.find('.IDbienservicio').val(IDbienservicio);
            currentRow.find('.rubro').val(rubro);
            currentRow.find('.descripcion').val(descripcion);
            currentRow.find('.preciounit').val(preciounit);

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

    function selectPresupuesto(idpresupuesto) {
        // Verificar si currentRow está definido y no es null
        if (currentRow) {
            // Utilizar currentRow para actualizar los campos
            currentRow.find('.idpresupuesto').val(idpresupuesto);


        } else {
            console.error("currentRow no está definido o es null. No se pueden actualizar los campos.");
        }
    }


    // Abrir modal en fila dinamica
    const openModalBtn_4 = document.getElementById("openModalBtn_4");
    // Actualiza la función de clic para pasar la fila actual al abrir el modal
    document.getElementById("tablaC").addEventListener("click", function (event) {

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



    // Evento para desmarcar el checkbox
    $(document).on("click", ".desmarcarCheckbox", function () {
        var row = $(this).closest('tr');
        row.find('.iva-checkbox').prop('checked', false).change(); // Usar change() para activar el manejador de eventos
    });

    $('#id_unidad').on('change', function () {
        var selectedValue = $(this).val();
        $('.actividad').val(selectedValue);
        //$('#rubro').val(selectedValue);
    });

    $('#tablaC').on('input', '.preciounit, .cantidad', function () {
        var $row = $(this).closest('tr');
        var precio = $row.find('.preciounit').val();
        var cantidad = $row.find('.cantidad').val();
        var porcentaje_iva = $row.find('.porcentaje_iva').val();
        var exenta = precio * cantidad;
        $row.find('.exenta').val(exenta.toFixed(0));
    });

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
        nuevaFila.find("select, input").not('.index, .id_pedido, .actividad').val("");
        nuevaFila.find(".index").val(indice);
        nuevaFila.find(".porcentaje_iva").prop('readonly', true);
        nuevaFila.find(".iva-checkbox").prop('checked', false);
        nuevaFila.show();

        // Agregar la nueva fila al cuerpo de la tabla
        $("#tablaC tbody").append(nuevaFila);
    });

    // Eliminar fila
    $("#tablaC").on("click", ".eliminarFila", function (e) {
        e.preventDefault();
        $(this).closest("tr").remove();
    });

    // Manejar el cambio en la casilla de verificación y los campos
    $(document).on("change", ".iva-checkbox, .preciounit, .cantidad, .porcentaje_iva", function () {
        var row = $(this).closest('tr');
        actualizarValores(row);
    });

    // Función para actualizar los valores de exenta y gravada
    function actualizarValores(row) {
        var precio = parseFloat(row.find('.preciounit').val()) || 0;
        var cantidad = parseFloat(row.find('.cantidad').val()) || 0;
        var porcentaje_iva = parseFloat(row.find('.porcentaje_iva').val()) || 0;

        if (row.find('.iva-checkbox').is(':checked')) {
            // Si el IVA está marcado
            var gravada = precio * cantidad * (1 + porcentaje_iva / 100);
            row.find('.gravada').val(gravada.toFixed(0));  // Asignar valor a gravada
            row.find('.exenta').val(0);  // Exenta debe ser 0
            row.find('.porcentaje_iva').prop('readonly', false);  // Habilitar el campo de IVA
        } else {
            // Si el IVA no está marcado
            var exenta = precio * cantidad;
            row.find('.exenta').val(exenta.toFixed(0));  // Asignar valor a exenta
            row.find('.gravada').val(0);  // Gravada debe ser 0
            row.find('.porcentaje_iva').val('');  // Limpiar el valor del IVA
            row.find('.porcentaje_iva').prop('readonly', true);  // Deshabilitar el campo de IVA
        }
    }

    // Inicializar el estado de las filas al cargar la página
    $("#tablaC tbody tr").each(function () {
        var row = $(this);
        actualizarValores(row);
    });
});


</script>

</html>