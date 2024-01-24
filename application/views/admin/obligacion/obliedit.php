<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet">
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
                        <form action="<?php echo base_url(); ?>obligaciones/Diario_obligaciones/update" method="POST">
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
                                                            value="<?php echo $proveedor->razon_social ?>" required>
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
                                                            <div class="col-md-4 mb-2">
                                                                <label for="pagado">Pagado:</label>
                                                                <input type="text" class="form-control w-100"
                                                                    id="pagado" name="pagado"
                                                                    value="<?php echo $asiento[0]['datosFijos']['MontoPagado']; ?>">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="op">N° Op</label>
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
                                                        <tr class="align-items-center">
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_pro" name="id_pro">
                                                                        <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>">
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
                                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>">
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
                                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                        <option value="<?php echo $of->id_of; ?>">
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
                                                                        id="idcuentacontable" name="idcuentacontable">
                                                                    <input style="width: 40%; font-size: small;"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="codigo_cc" name="codigo_cc" required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="descripcion_cc" name="descripcion_cc">
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
                                                                        id="comprobante" name="comprobante">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="detalles" name="detalles" required>
                                                                </div>
                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="MontoPago" name="MontoPago" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <?php if (isset($Debe)): ?>
                                                                    <?php $debe_value = number_format($Debe, 2, ',', '.'); ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="Debe" name="Debe"
                                                                        value="<?php echo $Debe_value; ?>">
                                                                    <?php else: ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent"
                                                                        id="Debe" name="Debe"
                                                                        oninput="formatNumber('Debe')">
                                                                    <?php endif; ?>
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
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_pro_2" name="id_pro_2" required>
                                                                        <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>">
                                                                            <?php echo $prog->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_ff_2" name="id_ff_2" required>
                                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>">
                                                                            <?php echo $ff->codigo; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_of_2" name="id_of_2" required>
                                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                        <option value="<?php echo $of->id_of; ?>">
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
                                                                        name="idcuentacontable_2">
                                                                    <input style="font-size: small; width: 40%"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent codigo_cc_2"
                                                                        id="codigo_cc_2" name="codigo_cc_2" required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent descripcion_cc_2"
                                                                        id="descripcion_cc_2" name="descripcion_cc_2">
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
                                                                        id="comprobante_2" name="comprobante_2">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="detalles_2" name="detalles_2">
                                                                </div>
                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="MontoPago_2" name="MontoPago_2" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="Debe_2" name="Debe_2" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <?php if (isset($haber_2)): ?>
                                                                    <?php $haber_2_value = number_format($haber_2, 2, ',', '.'); ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent form formatoNumero"
                                                                        id="Haber_2" name="Haber_2"
                                                                        value="<?php echo $haber_2_value; ?>">
                                                                    <?php else: ?>
                                                                    <input type="text"
                                                                        class="form-control small border-0 bg-transparent formatoNumero"
                                                                        id="Haber_2" name="Haber_2"
                                                                        oninput="formatNumber('Haber_2')">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>

                                                            </td>
                                                            <td class="columna-hidden">
                                                                <div class="input-group input-group-sm  ">
                                                                    <input type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="cheques_che_id_2" name="cheques_che_id_2">
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
                                                <!-- Acá termina la tabla -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botones guardar y cancelar -->
                                <div class="container-fluid mt-3 mb-3">
                                    <div class="col-md-12 d-flex flex-row justify-content-center">
                                        <button style="margin-right: 8px;" type="submit"
                                            class="btn btn-success btn-primary"><span
                                                class="fa fa-save"></span>Guardar</button>
                                        <button type="button" class="btn btn-danger ml-3"
                                            onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/presupuesto'">
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

    <!-- Modal de las cuentas Contables -->
    <div class="modal fade mi-modal" id="modalCuentasCont" tabindex="-1" aria-labelledby="ModalCuentasContables"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cuentas-contables">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="TablaCuentaCont">
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

    <!-- Script para la tabla de cuentas contables -->
    <script>
    $(document).ready(function() {
        var table1 = $('#TablaCuentaCont').DataTable({
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
        // Agregar fila
        $(document).on("click", ".agregarFila", function(e) {
            e.preventDefault();

            // Clonar la fila base
            var nuevaFila = $("#filaBase").clone();

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

    <!-- Script para agregar los enviados a la tabla -->
    <script>
    $(document).ready(function() {
        // Tu array de datos dinámicos
        var camposDinamicos = <?php echo json_encode($asiento[0]['camposDinamicos']); ?>;
        var programa = <?php echo json_encode($programa); ?>; // Asegúrate de tener el array de programas en tu backend

        // Obtén la referencia a la tabla
        var tabla = $('#miTabla tbody');

        // Itera sobre el array y agrega filas a la tabla
        camposDinamicos.forEach(function(campo) {
            // Clona la fila base y la muestra
            var nuevaFila = tabla.find('.filaBase').clone().removeClass('filaBase').show();

            // Asigna los valores del campo a las celdas de la nueva fila
            nuevaFila.find('[name="id_pro"]').val(campo.id_pro);
            // Aquí debes reemplazar '[name="id_pro"]' con el selector adecuado para el campo 'id_pro'

            // Agrega opciones al select de id_pro
            var selectIdPro = nuevaFila.find('[name="id_pro"]');
            programa.forEach(function(prog) {
                var selected = prog.id_pro == campo.id_pro ? 'selected' : '';
                selectIdPro.append('<option value="' + prog.id_pro + '" ' + selected + '>' +
                    prog.codigo + '</option>');
            });

            // Asigna otros valores a otras celdas...
            nuevaFila.find('[name="comprobante"]').val(campo.Comprobante);
            nuevaFila.find('[name="detalles"]').val(campo.detalles);
            // ...

            // Agrega la nueva fila a la tabla
            tabla.append(nuevaFila);
        });
    });
    </script>

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>