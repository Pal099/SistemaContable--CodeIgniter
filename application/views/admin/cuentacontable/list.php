<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- Estilos de DataTable button -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/Buttons/css/buttons.bootstrap5.min.css">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Cuentas Contables</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="mt-4">
                        <h1>Cuentas Contables</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary"
                                onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/CuentaContable/add'">
                                <i class="bi bi-plus-circle"></i> Agregar Cuenta Contable
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_cuentas_contables">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <div id="tablaContainer">
                                                <table class="table table-hover table-sm align-middle mt-4"
                                                    id="CuentasContables">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Código</th>
                                                            <th>Descripción</th>
                                                            <th>Tipo</th>
                                                            <th>Código Padre</th> <!-- Nueva columna -->
                                                            <th>Imputable</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($cuentascontables)): ?>
                                                            <?php foreach ($cuentascontables as $cuentacontable): ?>
                                                                <tr>
                                                                    <td><?php echo $cuentacontable->IDCuentaContable; ?></td>
                                                                    <td><?php echo $cuentacontable->Codigo_CC; ?></td>
                                                                    <td><?php echo $cuentacontable->Descripcion_CC; ?></td>
                                                                    <td><?php echo $cuentacontable->tipo; ?></td>
                                                                    <td><?php echo $cuentacontable->padre_id ? $cuentacontable->padre_id : 'N/A'; ?>
                                                                    </td> <!-- Mostrar el código padre -->
                                                                    <td><?php echo $cuentacontable->imputable == 1 ? 'Sí' : 'No'; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div
                                                                            class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#modalCuentasContables"
                                                                                value="<?php echo $cuentacontable->IDCuentaContable; ?>">
                                                                                <span class="fa fa-search"></span>
                                                                            </button>
                                                                            <button class="btn btn-warning btn-sm"
                                                                                onclick="window.location.href='<?php echo base_url() ?>mantenimiento/CuentaContable/edit/<?php echo $cuentacontable->IDCuentaContable; ?>'">
                                                                                <i class="bi bi-pencil-fill"></i>
                                                                            </button>
                                                                            <button class="btn btn-danger btn-remove btn-sm"
                                                                                onclick="confirmDelete(<?php echo $cuentacontable->IDCuentaContable; ?>)">
                                                                                Eliminar
                                                                            </button>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                                <!-- Spinner de Bootstrap -->
                                                <div class="spinner-border text-primary" id="spinner" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>


                                                <script>
                                                    function confirmDelete(idCuentaContable) {
                                                        // Mostrar una confirmación al usuario
                                                        const userConfirmed = confirm("¿Está seguro de que desea eliminar esta cuenta contable?");

                                                        if (userConfirmed) {
                                                            // Redirigir a la URL de eliminación
                                                            window.location.href = `mantenimiento/CuentaContable/delete/${idCuentaContable}`;
                                                        }
                                                        // Si el usuario cancela, no hacer nada
                                                    }

                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Script para las tabla de balance general -->
        <script>
            $(document).ready(function () {
                // Muestra el spinner
                $('#spinner').show();
                var table1 = $('#CuentasContables').DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                        '<"row"<"col-sm-12"t>>' +
                        '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10', '25', '50', 'Mostrar Todo']
                    ],
                    buttons: [{
                        extend: 'pageLength',
                        className: 'btn bg-primary border border-0',
                    },
                    {
                        extend: 'copy',
                        className: 'btn bg-primary border border-0',
                        text: '<i class="bi bi-copy"></i> Copiar',
                    },
                    {
                        extend: 'print',
                        className: 'btn bg-primary border border-0',
                        text: '<i class="bi bi-printer"></i> Imprimir',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-excel"></i> Excel', // Se agrega el icono
                        className: 'btn btn-success',
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-filetype-pdf"></i> PDF', // Icono de pdf tambien
                        className: 'btn btn-danger',
                    }
                    ],
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    },
                    initComplete: function (settings, json) {
                        // Oculta el spinner una vez que la tabla se haya cargado completamente
                        $('#spinner').hide();
                    }
                });
            });
        </script>
        <!-- Script de DataTable de jquery -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
        <!-- Script de DataTable button -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.bootstrap5.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/jszip/dist/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    </main>
</body>

</html>