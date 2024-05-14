<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_presupuesto.css" rel="stylesheet">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Pedido de Materiales</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/presupuesto">Listado
                        Presupuesto</a></li>
                <li class="breadcrumb-item">Agregar Pedido de Materiales</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar Pedido de Materiales</h1>
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
                        <form action="<?php echo base_url(); ?>patrimonio/pedido_material/store" method="POST">
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
                                                    <?php
                                                            $conexion = new mysqli('localhost', 'root', '', 'contanuevo');

                                                            if ($conexion->connect_error) {
                                                                die("Error de conexión: " . $conexion->connect_error);
                                                            }
                                                            
                                                            // Consulta para obtener el máximo idcomprobante
                                                            $sql = "SELECT MAX(IDPedidoMaterial) AS maxPedido FROM pedido_material";
                                                            $resultado = $conexion->query($sql);
                                                            
                                                            // Verificar si la consulta fue exitosa
                                                            if ($resultado) {
                                                                $fila = $resultado->fetch_assoc();
                                                                $maxPedido = $fila['maxPedido'];
                                                            } else {
                                                                die("Error en la consulta: " . $conexion->error);
                                                            }
                                                            
                                                            // Calcular el siguiente número de comprobante
                                                            $nextPedido = $maxPedido + 1;
                                                            
                                                            // Cerrar la conexión a la base de datos
                                                            $conexion->close();
                                                            ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="IDPedidoMaterial">Nro. de Pedido:</label>
                                                        <input type="number" class="form-control" id="IDPedidoMaterial" name="IDPedidoMaterial" value="<?php echo $nextPedido; ?>" required readonly>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group input-group">
                                                            <label for="codigo">Bien/Servicio:</label>
                                                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Bien/Servicio" required>
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalBienes"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar </i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            placeholder="Ej. YYYY/MM/DD" required>
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

                            <div class="container-fluid mt-3 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit"
                                        class="btn btn-success btn-primary"><span
                                            class="fa fa-save"></span>Guardar</button>
                                    <button class="btn btn-danger ml-3"
                                        onclick="window.location.href='<?php echo base_url(); ?>patrimonio/pedido_material'">
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
                                onclick="selectBien('<?= $bienes->IDbienservicio ?>', '<?= $bienes->rubro ?>',
                                    '<?= $bienes->descripcion ?>', '<?= $bienes->precioref ?>')" 
                                    data-bs-dismiss="modal">
                                    <td class="columna-hidden">
                                        <?= $bienes->IDbienservicio ?>
                                    </td>
                                    <td>
                                        <?= $index +1 ?>
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
        var itemIndex = 1; // Mueve la definición de itemIndex aquí

        // Función para agregar una fila a la tabla de items
        function agregarFilaTabla(periodo, actividad, rubro, descripcion, precioUnit, cantidad, ivaCheck, ivaSelect) {
            var exenta = ivaCheck ? "" : precioUnit;
            var gravada = ivaCheck ? precioUnit : "";
            var porcentajeIVA = ivaCheck ? ivaSelect : "";
            var cantidad = 0;
            var ivaSelect= 10;

            var fila = `<tr>
                <td>${itemIndex}</td>
                <td>${$("#IDPedidoMaterial").val()}</td>
                <td>${$("#id_unidad option:selected").text()}</td>
                <td>${rubro}</td>
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
            var actividad = $("#id_unidad").val();
            var periodo = $("#fecha").val();
            var rubro = $("#rubro").val();
            var precioUnit = $("#precioref").val();
            var cantidad = $("#cantidad").val();
            var ivaCheck = $("#checkIVA").prop("checked");
            var ivaSelect = $("#selectIVA").val();

            // Agregar fila a la tabla
            agregarFilaTabla(periodo, $("#actividad").val(), $("#id_unidad option:selected").text(), rubro, precioUnit, cantidad, ivaCheck, ivaSelect);
        }

        // Evento click para agregar una fila a la tabla
        $("#actualizarTablaBoton").on("click", function() {
            actualizarTabla();
        });

        // Mostrar el número de pedido en el campo correspondiente
        $("#IDPedidoMaterial").on("change", function() {
            var numPedido = $(this).val();
            $("#idpedido").val(numPedido);
        });


        // Evento click para mostrar el modal de Bienes/Servicios
        $('#buscarBien').on('click', function() {
            var modalBienes = new bootstrap.Modal(document.getElementById('modalBienes'));
            modalBienes.show();
        });

        // Función para seleccionar un bien desde el modal y autocompletar los datos del formulario y de la tabla
        function selectBien(IDbienservicio, rubro, descripcion, precioref) {
            // Actualizar los campos del formulario con los datos del bien seleccionado
            $("#codigo").val(descripcion);
            $("#rubro").val(rubro);
            $("#preciounit").val(precioref);

            // Actualizar los campos de la última fila de la tabla de items con los datos del bien seleccionado
            var lastRow = $("#tbodyItems tr:last");
            lastRow.find("td:nth-child(4)").text(rubro);
            lastRow.find("td:nth-child(5)").text(descripcion);
            lastRow.find("td:nth-child(6)").text(precioref);

            // Obtener el número de pedido y actualizar el campo correspondiente
            var numPedido = $("#IDPedidoMaterial").val();
            $("#idpedido").val(numPedido);

        }

        // Agregar evento click para seleccionar bien desde el modal
        $(document).on('click', '.list-item', function() {
            var IDbienservicio = $(this).find('td:eq(0)').text();
            var rubro = $(this).find('td:eq(2)').text();
            var descripcion = $(this).find('td:eq(4)').text();
            var precioref = $(this).find('td:eq(7)').text();
            selectBien(IDbienservicio, rubro, descripcion, precioref);
            $('#modalBienes').modal('hide'); // Ocultar el modal después de seleccionar un bien
        });

        // Agregar evento click para el botón "Seleccionar Bien" en la tabla de items
        $(document).on('click', '.seleccionarBienBtn', function() {
            var row = $(this).closest('tr');
            var rubro = row.find('td:eq(3)').text();
            var descripcion = row.find('td:eq(4)').text();
            var precioref = row.find('td:eq(5)').text();
            selectBien(null, rubro, descripcion, precioref);
        });

        // Habilitar o deshabilitar el campo de porcentaje de IVA al hacer clic en el checkbox de IVA
        $(document).on('change', 'input[type="checkbox"]', function() {
            var isChecked = $(this).prop('checked');
            var row = $(this).closest('tr');
            var porcentajeIVAInput = row.find('input[type="number"]');
            porcentajeIVAInput.prop('disabled', !isChecked);
        });

        // Actualizar automáticamente los campos de Exenta y Gravada al cambiar el estado del checkbox de IVA
        $(document).on('change', 'input[type="checkbox"]', function() {
            var isChecked = $(this).prop('checked');
            var row = $(this).closest('tr');
            var exentaCell = row.find('td:nth-child(10)');
            var gravadaCell = row.find('td:nth-child(11)');
            var precioUnitCell = row.find('td:nth-child(6)');
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

</html>
