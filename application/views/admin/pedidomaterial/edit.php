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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/pedido_material">Pedido de
                        Materiales</a></li>
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

                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';"
                            action="<?php echo base_url('patrimonio/Pedido_Material/update'); ?>" method="POST">
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
                                                            <?php foreach ($unidad as $uni): ?>
                                                                <option value="<?php echo $uni->id_unidad; ?>" <?php echo ($uni->id_unidad == $pedidos->id_unidad) ? 'selected' : ''; ?>>
                                                                    <?php echo $uni->unidad . ' - ' . $uni->id_unidad; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="IDPedidoMaterialp">Nro. de Pedido:</label>
                                                        <input type="number" class="form-control" id="IDPedidoMaterialp"
                                                            name="IDPedidoMaterialp"
                                                            value="<?php echo $pedidos->idpedido; ?>" readonly>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="fecha">Fecha</label>
                                                        <input type="date" class="form-control" id="fecha" name="fecha"
                                                            value="<?php echo $pedidos->fecha; ?>"
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
                                                                        <?php if (!empty($pedido) && is_array($pedido)): ?>
                                                                            <?php foreach ($pedido as $index => $pedidos): ?>
                                                                                <tr id="filaB" class="filaB">
                                                                                    <td class="columna-hidden">
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="hidden"
                                                                                                value="<?php echo $pedidos->IDPedidoMaterial; ?>"
                                                                                                id="IDPedidoMaterial"
                                                                                                name="IDPedidoMaterial[]">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent index"
                                                                                                id="item" name="item"
                                                                                                value="<?php echo $index + 1; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="number"
                                                                                                class="form-control border-0 bg-transparent npedido"
                                                                                                id="npedido" name="npedido[]"
                                                                                                value="<?php echo $pedidos->idpedido; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent actividad"
                                                                                                id="actividad"
                                                                                                name="actividad[]"
                                                                                                value="<?php echo $pedidos->id_unidad; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td hidden>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="number"
                                                                                                class="form-control border-0 bg-transparent IDbienservicio"
                                                                                                id="idbien" name="idbien[]"
                                                                                                value="<?php echo $pedidos->id_bien; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <?php if (isset($bienes[$pedidos->id_bien])): ?>
                                                                                                <input type="number"
                                                                                                    class="form-control border-0 bg-transparent rubro"
                                                                                                    id="rubro" name="rubro[]"
                                                                                                    value="<?php echo $bienes[$pedidos->id_bien]->rubro; ?>"
                                                                                                    readonly>
                                                                                            <?php else: ?>
                                                                                                <input type="text"
                                                                                                    class="form-control border-0 bg-transparent rubro"
                                                                                                    id="rubro" name="rubro"
                                                                                                    value="">
                                                                                            <?php endif; ?>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent descripcion"
                                                                                                id="descrip" name="descrip[]"
                                                                                                value="<?php echo $pedidos->concepto; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent precioref"
                                                                                                id="precioref"
                                                                                                name="precioref[]"
                                                                                                value="<?php echo $pedidos->preciounit; ?>">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="number"
                                                                                                class="form-control border-0 bg-transparent cantidad"
                                                                                                id="cantidad" name="cantidad[]"
                                                                                                value="<?php echo $pedidos->cantidad; ?>"
                                                                                                required>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-check">
                                                                                        <input type="hidden" name="iva[<?php echo $index; ?>]" value="0">
                                                                                        <input type="checkbox" class="form-check-input iva-checkbox" id="iva<?php echo $index; ?>" name="iva[<?php echo $index; ?>]" value="1"
                                                                                        <?php if ($pedidos->iva == 1) echo 'checked'; ?>>
                    
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="number"
                                                                                                class="form-control border-0 bg-transparent piva"
                                                                                                id="piva" name="piva[]"
                                                                                                value="<?php echo $pedidos->porcentaje_iva; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent exenta"
                                                                                                id="exenta" name="exenta[]"
                                                                                                value="<?php echo $pedidos->exenta; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <input type="text"
                                                                                                class="form-control border-0 bg-transparent gravada"
                                                                                                id="gravada" name="gravada[]"
                                                                                                value="<?php echo $pedidos->gravada; ?>"
                                                                                                readonly>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="input-group input-group-sm align-items-center">
                                                                                            <button type="button"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#modalBienes"
                                                                                                class="btn btn-primary openModalBtn_4">
                                                                                                <i class="bi bi-search"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                                            <button type="button"
                                                                                                class="btn btn-outline-primary border-0 agregarFila">
                                                                                                <i
                                                                                                    class="bi bi-plus-square"></i>
                                                                                            </button>
                                                                                            <button type="button"
                                                                                                class="btn btn-outline-danger border-0 eliminarFila"
                                                                                                hidden>
                                                                                                <i class="bi bi-trash3"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                            <tr>
                                                                                <td colspan="13">No data available</td>
                                                                            </tr>
                                                                        <?php endif; ?>
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
                                        onclick="window.location.href='<?php echo base_url(); ?>patrimonios/pedido_material'">
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
                                    '<?= $bienes->descripcion ?>', '<?= $bienes->precioref ?>')"
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

       // Manejar el cambio en la casilla de verificación y el campo piva
       $(document).on("change", ".iva-checkbox, .piva", function () {
            var row = $(this).closest('tr');

            // Verificar si la casilla iva-checkbox está marcada
            if (row.find('.iva-checkbox').is(':checked')) {
                // Habilitar el campo piva
                row.find('.piva').prop('readonly', false);

                // Calcular gravada cuando cambian los campos relevantes
                row.on('input', '.precioref, .cantidad, .piva', function () {
                    var precio = parseFloat(row.find('.precioref').val()) || 0;
                    var cantidad = parseFloat(row.find('.cantidad').val()) || 0;
                    var piva = parseFloat(row.find('.piva').val()) || 0;
                    var gravada = precio * cantidad * (1 + piva / 100);
                    row.find('.gravada').val(gravada.toFixed(0));
                });

                // Calcular gravada inicialmente al cargar la página
                var precio = parseFloat(row.find('.precioref').val()) || 0;
                var cantidad = parseFloat(row.find('.cantidad').val()) || 0;
                var piva = parseFloat(row.find('.piva').val()) || 0;
                var gravada = precio * cantidad * (1 + piva / 100);
                row.find('.gravada').val(gravada.toFixed(0));

            } else {
                // Deshabilitar el campo piva y reiniciar los valores de gravada y piva
                row.find('.piva').prop('readonly', true);
                row.find('.gravada').val(0);
                row.find('.piva').val('');
            }
        });

    $('#tablaP').on('input', '.precioref, .cantidad', function () {
        var $row = $(this).closest('tr');
        var precio = $row.find('.precioref').val();
        var cantidad = $row.find('.cantidad').val();
        var piva = $row.find('.piva').val();
        var exenta = precio * cantidad;
        $row.find('.exenta').val(exenta);
    });

    // Evento para desmarcar el checkbox
    $(document).on("click", ".desmarcarCheckbox", function () {
        var row = $(this).closest('tr');
        row.find('.iva-checkbox').prop('checked', false).change(); // Usar change() para activar el manejador de eventos
    });

</script>

<script>
    $(document).ready(function () {
        let index = <?php echo count($pedido); ?>; // Contador para nuevas filas

        // Función para agregar una nueva fila
        $('.agregarFila').on('click', function () {
            let newRow = `
            <tr class="filaB">
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="text" class="form-control border-0 bg-transparent index"
                            id="item" name="item" value="${index + 1}" readonly>
                    </div>
                </td>
                <td class="columna-hidden">
                    <div class="input-group input-group-sm align-items-center">
                        <input type="number" class="form-control border-0 bg-transparent IDPedidoMaterial"
                            id="IDPedidoMaterial" name="IDPedidoMaterial[]" value="0" readonly>
                    </div>
                 </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="number" class="form-control border-0 bg-transparent npedido"
                            id="npedido" name="npedido[]" value="<?php echo $pedidos->idpedido; ?>" readonly>
                    </div>     
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="text" class="form-control border-0 bg-transparent actividad"
                            id="actividad" name="actividad[]" value="<?php echo $pedidos->id_unidad; ?>" readonly>
                    </div>
                </td>
                <td hidden>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="number" class="form-control border-0 bg-transparent IDbienservicio"
                            id="idbien" name="idbien[]" value=""readonly>
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="text" class="form-control border-0 bg-transparent rubro"
                            id="rubro" name="rubro[]" value="" readonly>
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="text" class="form-control border-0 bg-transparent descripcion"
                            id="descrip" name="descrip[]" value="" readonly>
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="text" class="form-control border-0 bg-transparent precioref"
                            id="precioref" name="precioref[]" value="">
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                        <input type="number" class="form-control border-0 bg-transparent cantidad"
                            id="cantidad" name="cantidad[]" value="" required>
                    </div>        
                </td>
                <td>
                    <div class="form-check">
                        <input type="hidden" name="iva[${index}]" value="0">
                        <input type="checkbox" class="form-check-input iva-checkbox" id="iva${index}" name="iva[${index}]" value="1">
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                    <input type="number" class="form-control border-0 bg-transparent piva"
                        id="piva" name="piva[]" value="" readonly>
                        </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                    <input type="text" class="form-control border-0 bg-transparent exenta"
                        id="exenta" name="exenta[]" value="" readonly>
                        </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                    <input type="text" class="form-control border-0 bg-transparent gravada"
                        id="gravada" name="gravada[]" value="" readonly>
                        </div>
                </td>
                <td>
                    <div class="input-group input-group-sm align-items-center">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalBienes"
                        class="btn btn-primary openModalBtn_4">
                        <i class="bi bi-search"></i>
                    </button>
                    </div>
                </td>
                <td>
                    <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                        <button type="button" class="btn btn-outline-primary border-0 agregarFila">
                            <i class="bi bi-plus-square"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger border-0 eliminarFila">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
            $('#tablaP tbody').append(newRow);
            index++;
        });

        // Función para eliminar una fila
        $(document).on('click', '.eliminarFila', function () {
            $(this).closest('tr').remove();
            index--;
            updateRowNumbers();
        });

        // Función para actualizar los números de las filas
        function updateRowNumbers() {
            $('#tablaP tbody tr').each(function (i) {
                $(this).find('td:first').text(i + 1);
            });
        }
    });

    $('#id_unidad').on('change', function () {
        var selectedValue = $(this).val();
        $('.actividad').val(selectedValue);
        //$('#rubro').val(selectedValue);
    });
</script>







</html>