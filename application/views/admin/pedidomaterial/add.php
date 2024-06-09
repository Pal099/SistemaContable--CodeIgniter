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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>patrimonio/pedido_material">Pedido de
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
                        <form id="formularioPrincipal" onkeydown="return event.key != 'Enter';">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <?php
                                                    $conexion = new mysqli('localhost', 'root', '', 'contanuevo');

                                                    if ($conexion->connect_error) {
                                                        die("Error de conexión: " . $conexion->connect_error);
                                                    }

                                                    // Consulta para obtener el máximo idcomprobante
                                                    $sql = "SELECT MAX(idpedido) AS maxPedido FROM pedido_material";
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

                                                    <div class="form-group col-md-4">
                                                        <label for="IDPedidoMaterial">Nro. de Pedido:</label>
                                                        <input type="number" class="form-control" id="IDPedidoMaterial"
                                                            name="IDPedidoMaterial" value="<?php echo $nextPedido; ?>"
                                                            >
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
                                                                                        id="idbien" name="idbien"
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
                                                                                        id="descrip" name="descrip"
                                                                                        value="" readonly>
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
                                                                                        id="cantidad" name="cantidad"
                                                                                        value="" required>
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
                                                                                        id="piva" name="piva" value=""
                                                                                        readonly>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="input-group input-group-sm align-items-center  ">
                                                                                    <input type="text"
                                                                                        class="form-control border-0 bg-transparent exenta"
                                                                                        id="exenta" name="exenta"
                                                                                        value="" readonly>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="input-group input-group-sm align-items-center  ">
                                                                                    <input type="text"
                                                                                        class="form-control border-0 bg-transparent gravada"
                                                                                        id="gravada" name="gravada"
                                                                                        value="" readonly>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="input-group input-group-sm align-items-center  ">
                                                                                    <button type="button"
                                                                                        data-bs-toggle="modal"
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

    $("#formularioPrincipal").on("submit", function (event) {


        var datosFormulario = {
            fecha: $("#fecha").val(),
            id_unidad: $("#id_unidad").val(),
            IDPedidoMaterial: $("#IDPedidoMaterial").val(),
        };

        var filas = [];

        $("#tablaP tbody tr").each(function () {
            var fila = {
                pedido: $(this).find("input[name='npedido']").val(),
                actividad: $(this).find("input[name='actividad']").val(),
                idbien: $(this).find("input[name='idbien']").val(),
                rubro: $(this).find("input[name='rubro']").val(),
                descripcion: $(this).find("input[name='descrip']").val(),
                precioUnit: $(this).find("input[name='precioref']").val(),
                cantidad: $(this).find("input[name='cantidad']").val(),
                piva: $(this).find("input[name='piva']").val(),
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

        // Enviamos los datos al controlador mediante AJAX
        $.ajax({
            url: '<?php echo base_url("patrimonio/pedido_material/store"); ?>',
            type: 'POST',
            data: {
                datos: datosCompletos
            },
            // Asumimos que la respuesta es texto plano
            success: function (response) {

                if (response === "success") {
                    window.location.href = '<?php echo base_url("patrimonio/pedido_material"); ?>';
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

    // Evento para manejar cambios en el checkbox
    $(document).on("change", ".iva-checkbox", function () {
        var row = $(this).closest('tr');
        if ($(this).is(':checked')) {
            row.find('.piva, .exenta').prop('readonly', false);
            var valorOrigen = row.find('.precioref').val();
            row.find('.gravada').val(valorOrigen);
        } else {
            row.find('.piva, .exenta').prop('readonly', true);
            row.find('.gravada').val(0);
        }
    });

    // Evento para desmarcar el checkbox
    $(document).on("click", ".desmarcarCheckbox", function () {
        var row = $(this).closest('tr');
        row.find('.iva-checkbox').prop('checked', false).change(); // Usar change() para activar el manejador de eventos
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

            // Quitar el atributo 'hidden' del botón Eliminar en la fila clonada
            nuevaFila.find(".eliminarFila").removeAttr('hidden');

            // Quitar el ID para evitar duplicados en todos los elementos de la fila clonada
            nuevaFila.find("[id]").removeAttr('id');

            // Agregar una clase a todos los elementos de la fila clonada
            nuevaFila.find("select, input").addClass("filaClonada");

            // Limpiar los valores de los campos en la nueva fila
            nuevaFila.find("select, input").not('.index, .npedido, .actividad').val("");

            nuevaFila.find(".index").val(indice);

            nuevaFila.find(".iva-checkbox").prop('checked', false);
            // Mostrar la nueva fila
            nuevaFila.show();

            // Agregar la nueva fila al cuerpo de la tabla
            $("#tablaP tbody").append(nuevaFila);
        });

        // Eliminar fila
        $("#tablaP").on("click", ".eliminarFila", function (e) {
            e.preventDefault();

            $(this).closest("tr").remove();

        });


        $('#id_unidad').on('change', function () {
            var selectedValue = $(this).val();
            $('.actividad').val(selectedValue);
            //$('#rubro').val(selectedValue);
        });

    });
</script>

</html>