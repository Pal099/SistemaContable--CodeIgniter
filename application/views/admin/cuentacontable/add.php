<!DOCTYPE html>
<html lang="es">

<head>

    <link href="<?php echo base_url(); ?>assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Script para el sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('assets/sweetalert-helper/sweetAlertHelper.js'); ?>"></script>
</head>

<main id="main" class="main">

    <div class="pagetitle">
        <h1> PLAN DE CUENTAS
            <small></small>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>mantenimiento/CuentaContable">Plan de
                        Cuentas</a></li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata("error")): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>

                                </div>
                            <?php endif; ?>

                            <!-- Formulario principal para cuentas contables -->
                            <form action="<?php echo base_url(); ?>mantenimiento/CuentaContable/store" method="POST">

                                <!-- Campo para seleccionar la cuenta padre -->
                                <div class="form-group">
                                    <label for="padre_id">Padre Inmediato:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="padre_id" name="padre_id" readonly>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalCuentasCont2">
                                            Seleccionar
                                        </button>
                                    </div>
                                    <?php echo form_error("padre_id", "<span class='help-block'>", "</span>"); ?>
                                </div>

                                <!-- Modal para seleccionar la cuenta padre -->
                                <div class="modal fade" id="modalCuentasCont2" tabindex="-1"
                                    aria-labelledby="ModalCuentasContables" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Seleccionar Cuenta Padre</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-hover" id="TablaCuentaCont">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Código</th>
                                                            <th>Nombre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($cuentasPadres)): ?>
                                                            <?php foreach ($cuentasPadres as $padre): ?>
                                                                <tr onclick="selectCuentaPadre('<?= $padre->Codigo_CC ?>', '<?= $padre->Descripcion_CC ?>', '<?= $padre->IDCuentaContable ?>',)"
                                                                    data-bs-dismiss="modal">
                                                                    <td><?= $padre->IDCuentaContable ?></td>
                                                                    <td><?= $padre->Codigo_CC ?></td>
                                                                    <td><?= $padre->Descripcion_CC ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="3">No hay cuentas disponibles.</td>
                                                            </tr>
                                                        <?php endif; ?>

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo para seleccionar el tipo -->
                                <div class="form-group">
                                    <label for="tipo">Tipo:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tipo" name="tipo" readonly>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalTipos">
                                            Seleccionar
                                        </button>
                                    </div>
                                    <?php echo form_error("tipo", "<span class='help-block'>", "</span>"); ?>
                                </div>


                                <!-- Modal para seleccionar el tipo -->
                                <div class="modal fade mi-modal" id="modalTipos" tabindex="-1"
                                    aria-labelledby="ModalTipos" aria-hidden="true">
                                    <div
                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-presupuesto-large">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Seleccionar Tipo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-hover table-sm" id="TablaTipos">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Tipo</th>
                                                            <th class="columna-hiden">Código</th>
                                                            <th class="columna-hiden">Padre ID</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Aquí se llenarán los tipos mediante AJAX -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    // Inicializar DataTables una vez
                                    $(document).ready(function () {
                                        $('#TablaTipos').DataTable({
                                            paging: true,
                                            pageLength: 10,
                                            lengthChange: true,
                                            searching: true,
                                            info: true,
                                            language: {
                                                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                                            },
                                        });
                                    });

                                    // Seleccionar cuenta padre y cargar los tipos relacionados
                                    function selectCuentaPadre(codigoPadre) {
                                        document.getElementById('padre_id').value = codigoPadre;

                                        console.log("Código Padre Seleccionado:", codigoPadre); // Verificar el valor antes de enviarlo

                                        $.ajax({
                                            url: '<?php echo base_url("mantenimiento/CuentaContable/obtenerTiposPorCodigoPadre"); ?>',
                                            type: 'POST',
                                            data: { codigoPadre: codigoPadre },
                                            dataType: 'json',
                                            success: function (response) {
                                                console.log("Respuesta del Servidor:", response); // Verificar la respuesta del servidor

                                                const tablaTipos = $('#TablaTipos').DataTable();
                                                tablaTipos.clear(); // Limpiar las filas actuales

                                                if (response.length > 0) {
                                                    const rows = response.map((tipo, index) => {
                                                        return [
                                                            index + 1,
                                                            tipo.descripcion,
                                                            tipo.tipo,
                                                            tipo.codigo, // Asegúrate de que este campo exista en la respuesta del servidor
                                                            tipo.id_padre// Asegúrate de que este campo exista en la respuesta del servidor
                                                        ];
                                                    });
                                                    tablaTipos.rows.add(rows).draw(); // Agregar nuevas filas y redibujar la tabla

                                                    // Evento de clic para seleccionar un tipo
                                                    $('#TablaTipos tbody').off('click').on('click', 'tr', function () {

                                                        const descripcionSeleccionada = $(this).find('td:nth-child(2)').text();
                                                        const tipoSeleccionado = $(this).find('td:nth-child(3)').text();

                                                        const codigoSeleccionado = $(this).find('td:nth-child(4)').text();
                                                        const idPadreSeleccionado = $(this).find('td:nth-child(5)').text();

                                                        $('#tipo').val(`${descripcionSeleccionada} - ${tipoSeleccionado}`); // Asigna la descripción al input
                                                        $('#codigo_nuevo').val(codigoSeleccionado); // Actualizar campo "codigo_nuevo"
                                                        $('#id_padre').val(idPadreSeleccionado); // Actualizar campo "id_padre" con el valor de padre_id
                                                        $('#modalTipos').modal('hide'); // Cierra el modal
                                                    });

                                                } else {
                                                    tablaTipos.rows.add([['', 'No hay tipos disponibles', '', '']]).draw(); // Agregar fila de "No hay tipos disponibles"
                                                }
                                            },
                                            error: function () {
                                                alert('Error al cargar los tipos. Intente nuevamente.');
                                            }
                                        });
                                    }

                                </script>


                                <div class="form-group">
                                    <label for="codigo_nuevo">Código Nuevo:</label>
                                    <input type="text" class="form-control" id="codigo_nuevo" name="codigo_nuevo" />
                                </div>

                                <div class="form-group">
                                    <label for="descri_nueva">Descripcion Nueva Cuenta:</label>
                                    <input type="text" class="form-control" id="descri_nueva" name="descri_nueva" />
                                </div>

                                <div class="form-group">
                                    <label for="id_padre">id_padre:</label>
                                    <input type="text" class="form-control" id="id_padre" name="id_padre" />
                                </div>

                                <input type="hidden" id="hiddenNombreTipo" name="nombreTipo">
                                <input type="hidden" id="hiddenidcuentacontable" name="IDCuentaContable">



                                <!-- Imputable -->
                                <div class="form-group">
                                    <label for="imputable">Asentable:</label>
                                    <input type="checkbox" id="imputable" name="imputable" value="1">
                                    <label for="imputable">Sí</label>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-flat"><span
                                            class="fa fa-save"></span> Guardar</button>
                                    <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable"
                                        class="btn btn-danger"><span class="fa fa-remove"></span> Cancelar</a>
                                </div>
                            </form>

                            <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
                            <!--                          
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>