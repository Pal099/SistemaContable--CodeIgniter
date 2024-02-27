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
                                                    <label for="periodo" class="form-label">Periodo Presup:</label>
                                                        <select class="form-select" id="periodo" name="periodo">
                                                        <option value="">Ninguno</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        </select>
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
                                                        <th>FF</th>
                                                        <th>Org.</th>
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
                            onclick="selectBien('<?= $bienes->IDbienservicio ?>', '<?= $bienes->rubro ?>')"
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
<script>
    $(document).ready(function() {
        var itemIndex = 1;
        var rubro = "124";
        var org = "???";

        // Función para agregar una fila a la tabla de items
        function agregarFilaTabla(periodo, actividad, ff, descripcion, precioUnit, cantidad, ivaCheck, ivaSelect) {
            var exenta = ivaCheck ? "" : precioUnit;
            var gravada = ivaCheck ? precioUnit : "";

            var fila = `<tr>
                <td>${itemIndex}</td>
                <td>${periodo}</td>
                <td>${actividad}</td>
                <td>${rubro}</td>
                <td>${ff}</td>
                <td>${org}</td>
                <td>${descripcion}</td>
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
            var ff = $("#id_ff").val();
            var descripcion = $("#concepto").val();
            var precioUnit = $("#precioUnitario").val();
            var cantidad = $("#cantidad").val();
            var ivaCheck = $("#checkIVA").prop("checked");
            var ivaSelect = $("#selectIVA").val();

            // Agregar fila a la tabla
            agregarFilaTabla(periodo, actividad, ff, descripcion, precioUnit, cantidad, ivaCheck, ivaSelect);
        }

        // Escuchar eventos de cambio en los campos del formulario
        $("#periodo, #id_unidad, #id_ff, #concepto, #precioUnitario, #cantidad, #checkIVA, #selectIVA").on("change", function() {
            actualizarTabla();
        });

        // También puedes agregar un botón para actualizar la tabla manualmente
        $("#actualizarTablaBoton").on("click", function() {
            actualizarTabla();
        });
    });
</script>
<script>
function buscarRubros() {
    var codigo = document.getElementById('codigo').value;
    
    // Aquí puedes realizar una llamada AJAX para obtener los rubros asociados al código
    // y luego llenar la tabla dentro del modal con los resultados.

    // Ejemplo de cómo podrías llenar la tabla con datos estáticos:
    var rubrosTabla = document.getElementById('rubrosTabla');
   

    // Mostrar el modal de Bienes/Servicios
    var modalBienes = new bootstrap.Modal(document.getElementById('modalBienes'));
    modalBienes.show();
}
</script>
    <!-- Script para seleccionar la cuenta contable -->
    <script>
    function selectCC(IDCuentaContable) {
        // Actualizar el valor del select con los valores seleccionados
        var selectElement = document.getElementById('Idcuentacontable');
        selectElement.value = IDCuentaContable;
    }
    </script>
    <!-- Script para mostrar los campos de los meses -->
    <script>
    document.getElementById('camposOpcionalesSwitch').addEventListener('change', function() {
        var camposMesesCollapse = new bootstrap.Collapse(document.getElementById('camposMesesCollapse'));
        camposMesesCollapse.toggle();
    });
    </script>

        <script>
        function selectProveedor(razonSocial) {
            document.getElementById('idproveedor').value = razonSocial;

        }
        </script>
                <script>
        function selectBien(razonSocial) {
            document.getElementById('idproveedor').value = razonSocial;

        }
        </script>
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

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>