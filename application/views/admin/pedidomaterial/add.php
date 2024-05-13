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
                <li class="breadcrumb-item">Pedido de Mariales</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/presupuesto">Listado
                        Presupuesto</a></li>
                <li class="breadcrumb-item">Agregar Pedido de Mariales</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar Pedido de Mariales</h1>
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
                                                            <label for="codigo"></label>
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
        function agregarFilaTabla(periodo, actividad, rubro, precioUnit, cantidad, ivaCheck, ivaSelect) {
            var exenta = ivaCheck ? "" : precioUnit;
            var gravada = ivaCheck ? precioUnit : "";

            var fila = `<tr>
                <td>${itemIndex}</td>
                <td>${periodo}</td>
                <td>${actividad}</td>
                <td>${rubro}</td>
                <td contenteditable="true">${precioUnit}</td>
                <td contenteditable="true">${cantidad}</td>
                <td>${ivaCheck ? '<input type="checkbox" checked disabled>' : ''}</td>
                <td>${ivaCheck ? ivaSelect : ''}</td>
                <td>${exenta}</td>
                <td>${gravada}</td>
            </tr>`;

            $("#tbodyItems").append(fila);
            itemIndex++;
        }

        // Función para actualizar la tabla al hacer cambios en el formulario
        function actualizarTabla() {
            var periodo = $("#periodo").val();
            var actividad = $("#id_unidad").val();
            var rubro = $("#rubro").val();
            var precioUnit = $("#preciounit").val();
            var cantidad = $("#cantidad").val();
            var ivaCheck = $("#checkIVA").prop("checked");
            var ivaSelect = $("#selectIVA").val();

            // Agregar fila a la tabla
            agregarFilaTabla(periodo, actividad, rubro, precioUnit, cantidad, ivaCheck, ivaSelect);
        }

        // Escuchar eventos de cambio en los campos del formulario
        $("#periodo, #id_unidad, #rubro, #preciounit, #cantidad, #checkIVA, #selectIVA").on("change", function() {
            actualizarTabla();
        });

        // También puedes agregar un botón para actualizar la tabla manualmente
        $("#actualizarTablaBoton").on("click", function() {
            actualizarTabla();
        });

        // Función para seleccionar un bien desde el modal
        function selectBien(IDbienservicio, rubro, descripcion, precioref) {
    var fila = `
        <tr>
            <td>${IDbienservicio}</td>
            <td>${rubro}</td>
            <td>${descripcion}</td>
            <td>${precioref}</td>
        </tr>`;
    $("#tbodyItems").append(fila);
}

// Agregar evento click para seleccionar bien desde el modal
$(document).on('click', '.list-item', function() {
    var IDbienservicio = $(this).find('td:eq(0)').text();
    var rubro = $(this).find('td:eq(2)').text();
    var descripcion = $(this).find('td:eq(3)').text();
    var precioref = $(this).find('td:eq(6)').text();
    selectBien(IDbienservicio, rubro, descripcion, precioref);
    $('#modalBienes').modal('hide'); // Ocultar el modal después de seleccionar un bien
});

        // Evento click para mostrar el modal de Bienes/Servicios
        $('#buscarBien').on('click', function() {
            var modalBienes = new bootstrap.Modal(document.getElementById('modalBienes'));
            modalBienes.show();
        });
    });
</script>

    </body>
</html>