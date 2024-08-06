<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_presupuesto.css" rel="stylesheet">

</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Comprobante Gastos</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/presupuesto">Listado
                        Presupuesto</a></li>
                <li class="breadcrumb-item">Agregar Comprobante Gastos</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar Comprobante de Gasto</h1>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>patrimonio/comprobante_gasto/store" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                
                                                    <div class="form-group col-md-4">
                                                        <label for="id_unidad">Actividad:</label>
                                                        <select name="id_unidad"
                                                            id="id_unidad" class="form-control"
                                                            required>
                                                            <?php foreach ($unidad as $uni) : ?>
                                                            <option value="<?php echo $uni->id_unidad ?>">
                                                                <?php echo $uni->unidad . ' - ' . $uni->id_unidad ; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="tipo">Tipo:</label>
                                                        <select class="form-select" id="periodo" name="periodo">
                                                            <option value="">Factura Credito</option>
                                                            <option value="x">Factura X</o ption>
                                                            <option value="y">Factura Y</option>
                                                            <option value="z">Factura Z</option>

                                                            </select>
                                                    </div>
                                                    <?php
                                                            $conexion = new mysqli('localhost', 'root', '', 'contanuevo');

                                                            if ($conexion->connect_error) {
                                                                die("Error de conexión: " . $conexion->connect_error);
                                                            }
                                                            
                                                            // Consulta para obtener el máximo idcomprobante
                                                            $sql = "SELECT MAX(IDComprobanteGasto) AS maxComprobante FROM comprobante_gasto";
                                                            $resultado = $conexion->query($sql);
                                                            
                                                            // Verificar si la consulta fue exitosa
                                                            if ($resultado) {
                                                                $fila = $resultado->fetch_assoc();
                                                                $maxComprobante = $fila['maxComprobante'];
                                                            } else {
                                                                die("Error en la consulta: " . $conexion->error);
                                                            }
                                                            
                                                            // Calcular el siguiente número de comprobante
                                                            $nextComprobante = $maxComprobante + 1;
                                                            
                                                            // Cerrar la conexión a la base de datos
                                                            $conexion->close();
                                                            ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="IDComprobanteGasto">Nro. de Comprobante:</label>
                                                        <input type="number" class="form-control" id="IDComprobanteGasto" name="IDComprobanteGasto" value="<?php echo $nextComprobante; ?>" required readonly>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select name="idproveedor" id="idproveedor"
                                                                class="form-control" required>
                                                                <option selected disabled>Seleccione un Proveedor...</option>
                                                                <?php foreach ($proveedores as $prov) : ?>
                                                                <option value="<?php echo $prov->id ?>">
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
                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            placeholder="Ej. YYYY/MM/DD" required>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="id_ff">Fuente de financiamiento: </label>
                                                        <select class="form-control" id="id_ff"
                                                            name="id_ff" required>
                                                            <?php foreach ($fuentes as $fuente) : ?>
                                                            <option value="<?php echo $fuente->id_ff ?>">
                                                                <?php echo $fuente->codigo . ' - ' . $fuente->nombre ; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group input-group">
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalPresupuestos"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar Presupuesto</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="concepto">Observacion:</label>
                                                        <input type="text" class="form-control" id="concepto"
                                                            name="concepto" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group col-md-12">
                                                            <label for="codigo"></label>
                                                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Bien/Servicio"required>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                        <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalBienes"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar</i>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-12 text-md-end">
                                                        <button type="button" id="actualizarTablaBoton" 
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus"> Agregar Item </i>
                                                        </button>
                                                        </div>
                                                        
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
                                            <table class="table table-bordered" id="tablaItems">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Periodo</th>
                                                        <th>Actividad</th>
                                                        <th>Rubro</th>
                                                        <th>Prog.</th>
                                                        <th>FF</th>
                                                        <th>OF</th>
                                                        <th>Descripción</th>
                                                        <th>Precio Unit</th>
                                                        <th>Cantidad</th>
                                                        <th>IVA</th>
                                                        <th>Porcentaje IVA (%)</th>
                                                        
                                                        <th>Exenta</th>
                                                        <th>Gravada</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyItems"></tbody>
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
                            <button id="actualizarTablaBoton" type="button">Agregar Item</button>
                            <div class="container-fluid mt-3 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit"
                                        class="btn btn-success btn-primary"><span
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
    <div class="modal fade" id="modalPresupuestos" tabindex="-1" aria-labelledby="modalPresupuestosLabel" aria-hidden="true">
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
                                data-origen-de-financiamiento-id-of="<?= $dato['origen_de_financiamiento_id_of']?>"
                                data-bs-dismiss="modal"></tr>
                            <tr class="list-item" 
                                onclick="selectPresupuesto('<?= $dato['rubro'] ?>','<?= $dato['programa_id_pro'] ?>', '<?= $dato['fuente_de_financiamiento_id_ff'] ?>', '<?= $dato['origen_de_financiamiento_id_of']?>')" 
                                data-bs-dismiss="modal">
                                <td><?= $dato['Año']?></td>
                                <td><?= $dato['programa_id_pro']?></td>
                                <td><?= $dato['codigo']?></td>
                                <td><?= $dato['rubro']?></td>
                                <td><?= $dato['fuente_de_financiamiento_id_ff'] ?></td>
                                <td><?= $dato['origen_de_financiamiento_id_of']?></td>
                                <td><?= $dato['programa_id_pro'] ?></td>
                                <td><?= $dato['TotalPresupuestado'] ?></td>
                                <td><?= $dato['saldo_actual'] /*Saldo actual sale del ultimo mes que se cargó*/?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade mi-modal" id="modalProveedores" tabindex="-1"
    aria-labelledby="modalListProveedores" aria-hidden="true">
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
                                <th class="columna-hidden">ID</th>
                                    <th>#</th>
                                    <th>Ruc</th>
                                    <th>Razón Social</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proveedores as $index => $proveedor): ?>
                                    <tr class="list-item"
                                    onclick="selectProveedor('<?= $proveedor->id ?>', '<?= $proveedor->razon_social ?>')"
                                    data-bs-dismiss="modal">
                                    <td class="columna-hidden">
                                        <?= $proveedor->id ?>
                                    </td>
                                    <td>
                                        <?= $index +1 ?>
                                    </td>
                                    <td>
                                        <?= $proveedor->ruc ?>
                                    </td>
                                    <td>
                                        <?= $proveedor->razon_social ?>
                                    </td>
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
                    <table id="TablaBienes"class="table table-hover table-sm">
                        <thead>
                            <tr>
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
                                <tr class="list-item" 
                                onclick="selectBien( '<?= $bienes->rubro ?>',
                                    '<?= $bienes->descripcion ?>', '<?= $bienes->precioref ?>')" 
                                    data-bs-dismiss="modal">
                                    <td>
                                        <?= $bienes->IDbienservicio ?>
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
                                        <?= $bienes->precioref ?>
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
$(document).ready(function() {

function selectPresupuesto(programa_id_pro, fuente_de_financiamiento_id_ff, origen_de_financiamiento_id_of) {
    $("#programa_id_pro").val(programa_id_pro);
    $("#fuente_de_financiamiento_id_ff").val(fuente_de_financiamiento_id_ff);
    $("#origen_de_financiamiento_id_of").val(origen_de_financiamiento_id_of);

    // Actualizar la última fila de la tabla solo con los campos de presupuesto
    var lastRow = $("#tbodyItems tr:last");
    lastRow.find("td:nth-child(5)").text(programa_id_pro); // Columna 'Prog.'
    lastRow.find("td:nth-child(6)").text(fuente_de_financiamiento_id_ff); // Columna 'FF'
    lastRow.find("td:nth-child(7)").text(origen_de_financiamiento_id_of); // Columna 'OF'
}

function selectBien(rubro, descripcion, precioref) {
    $("#rubro").val(rubro);
    $("#descripcion").val(descripcion); 
    $("#preciounit").val(precioref);

    // Actualizar la última fila de la tabla solo con los campos de bien
    var lastRow = $("#tbodyItems tr:last");
    lastRow.find("td:nth-child(4)").text(rubro); // Columna 'Rubro'
    lastRow.find("td:nth-child(8)").text(descripcion); // Columna 'Descripción'
    lastRow.find("td:nth-child(9)").text(precioref); // Columna 'Precio Unit'
}

function agregarFilaTabla(periodo, actividad, fecha, rubro, programa_id_pro, fuente_de_financiamiento_id_ff, origen_de_financiamiento_id_of, descripcion, precioUnit, cantidad, ivaCheck, ivaSelect) {
    var exenta = ivaCheck ? "" : precioUnit;
    var gravada = ivaCheck ? precioUnit : "";
    var porcentajeIVA = ivaCheck ? ivaSelect : "";

    var fila = `<tr>
        <td>${itemIndex}</td>
        <td>${periodo}</td>
        <td>${actividad}</td>
        <td>${rubro}</td>
        <td>${programa_id_pro}</td>
        <td>${fuente_de_financiamiento_id_ff}</td>
        <td>${origen_de_financiamiento_id_of}</td>
        <td>${descripcion}</td>
        <td contenteditable="true">${precioUnit}</td>
        <td contenteditable="true">${cantidad}</td>
        <td><input type="checkbox" class="form-check-input" ${ivaCheck ? 'checked' : ''}></td>
        <td><input type="number" class="form-control" min="5" max="10" value="${porcentajeIVA}" ${ivaCheck ? '' : 'disabled'}></td>
        <td>${exenta}</td>
        <td>${gravada}</td>
        <td><button type="button" class="btn btn-primary seleccionarBienBtn">Seleccionar Bien</button></td>
    </tr>`;

    $("#tbodyItems").append(fila);
    itemIndex++;
}

function actualizarTabla() {
    var periodo = $("#fecha").val();
    var actividad = $("#id_unidad").val();
    var rubro = $("#rubro").val();
    var programa_id_pro = $("#prog").val();
    var fuente_de_financiamiento_id_ff = $("#ff").val();
    var origen_de_financiamiento_id_of = $("#of").val();
    var descripcion = $("#descripcion").val();
    var precioUnit = $("#precioref").val();
    var cantidad = $("#cantidad").val();
    var ivaCheck = $("#checkIVA").prop("checked");
    var ivaSelect = $("#selectIVA").val();

    agregarFilaTabla(periodo, actividad, $("#fecha option:selected").text(), rubro, programa_id_pro, fuente_de_financiamiento_id_ff, origen_de_financiamiento_id_of, descripcion, precioUnit, cantidad, ivaCheck, ivaSelect);
}

var itemIndex = 1;

// Botón para actualizar la tabla
$("#actualizarTablaBoton").on("click", function() {
    actualizarTabla();
});

// Cambio del número de pedido
$("#IDPedidoMaterial").on("change", function() {
    var numPedido = $(this).val();
    $("#idpedido").val(numPedido);
});

// Mostrar modal de bienes
$('#buscarBien').on('click', function() {
    var modalBienes = new bootstrap.Modal(document.getElementById('modalBienes'));
    modalBienes.show();
});

// Selección de bien de la lista del modal
$('#modalBienes').on('click', '.list-item', function() {
    var rubro = $(this).find('td:eq(2)').text();
    var descripcion = $(this).find('td:eq(3)').text();
    var precioref = $(this).find('td:eq(6)').text();
    selectBien(rubro, descripcion, precioref);
    $('#modalBienes').modal('hide');
});

// Selección de presupuesto de la lista del modal
$('#modalPresupuestos').on('click', '.list-item', function() {
    var programa_id_pro = $(this).find('td:eq(2)').text();
    var fuente_de_financiamiento_id_ff = $(this).find('td:eq(4)').text();
    var origen_de_financiamiento_id_of = $(this).find('td:eq(5)').text();
    selectPresupuesto(programa_id_pro, fuente_de_financiamiento_id_ff, origen_de_financiamiento_id_of);
    $('#modalPresupuestos').modal('hide');
});

// Habilitar/deshabilitar campo de porcentaje de IVA
$(document).on('change', 'input[type="checkbox"]', function() {
    var isChecked = $(this).prop('checked');
    var row = $(this).closest('tr');
    var porcentajeIVAInput = row.find('input[type="number"]');
    porcentajeIVAInput.prop('disabled', !isChecked);

    var exentaCell = row.find('td:nth-child(13)');
    var gravadaCell = row.find('td:nth-child(14)');
    var precioUnitCell = row.find('td:nth-child(9)');
    var precioUnit = parseFloat(precioUnitCell.text());

    if (isChecked) {
        exentaCell.text('');
        gravadaCell.text(precioUnit);
    } else {
        exentaCell.text(precioUnit);
        gravadaCell.text('');
    }
});
});

</script>

<script>
$(document).ready(function() {
    // Inicializar DataTable solo si no está ya inicializado
    if (!$.fn.dataTable.isDataTable('#TablaProveedores')) {
        $('#TablaProveedores').DataTable({
            paging: true,
            pageLength: 10,
            lengthChange: true,
            searching: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    }

    // Inicializar DataTable cuando se muestra el modal de bienes, solo si no está ya inicializado
    $('#modalBienes').on('shown.bs.modal', function () {
        if (!$.fn.dataTable.isDataTable('#TablaBienes')) {
            $('#TablaBienes').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                info: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        }
    });

    // Inicializar DataTable cuando se muestra el modal de presupuestos, solo si no está ya inicializado
    $('#modalPresupuestos').on('shown.bs.modal', function () {
        if (!$.fn.dataTable.isDataTable('#TablaPresupuestos')) {
            $('#TablaPresupuestos').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                info: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });
        }
    });
});
</script>
</body>

</html>