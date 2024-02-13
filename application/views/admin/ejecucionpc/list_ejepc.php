<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_ejecu_pre.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Presupuesto</li>
                <li class="breadcrumb-item active">Ejecución Presupuestaria</li>
            </ol>
        </nav>
        <!-- Contenedor de los componentes -->
        <div class="container-fluid bg-white border rounded-3">
            <!-- Encabezado -->
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Ejecución Presupuestaria</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <!-- Acá pueden ir los botones -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin del Encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_tabla">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <p class="titulo-body fw-semibold">Listado de las Ejecuciones Presupuestarias</p>
                                            <hr>
                                            <div class="table-responsive">
                                                <table id="TablaEjecucionPre" class="table table-sm rounded-3">
                                                    <thead>
                                                        <tr>
                                                            <th>O.F</th>
                                                            <th>F.F</th>
                                                            <th>PROG.</th>
                                                            <th>Cuenta</th>
                                                            <th>Presupuesto Inicial</th>
                                                            <th>Aumento/Disminución Presupuestaria</th>
                                                            <th>Presupuesto Vigente</th>
                                                            <th>Obligado</th>
                                                            <th>Saldo Presupuestario</th>
                                                            <th>Pagado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($ejecucionpresupuestaria as $ep): ?>
                                                        <?php if ($ep->Obligado > 0 || $ep->Pagado > 0): ?>
                                                        <tr>
                                                            <td><?php echo $ep->origen_de_financiamiento_id_of; ?></td>
                                                            <td><?php echo $ep->fuente_de_financiamiento_id_ff; ?></td>
                                                            <td><?php echo $ep->programa_id_pro; ?></td>
                                                            <td><?php echo $ep->Idcuentacontable; ?></td>
                                                            <td><?php echo number_format($ep->TotalPresupuestado, 0, '.', '.'); ?>
                                                            </td>
                                                            <td><?php echo number_format($ep->TotalModificado, 0, '.', '.'); ?>
                                                            </td>
                                                            <td><?php echo number_format($ep->Vigente, 0, '.', '.'); ?>
                                                            </td>
                                                            <td><?php echo number_format($ep->Obligado, 0, '.', '.'); ?>
                                                            </td>
                                                            <td><?php echo number_format($ep->SaldoPresupuestario, 0, '.', '.'); ?>
                                                            </td>
                                                            <td><?php echo number_format($ep->Pagado, 0, '.', '.'); ?>
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php endforeach; ?>
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
        </div>
    </main>


    <!-- Script de la tabla de Ejecucion Presupuestaria -->
    <script>
    $(document).ready(function() {
        var table1 = $('#TablaEjecucionPre').DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"t>>' +
                '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Mostrar Todo']
            ],
            buttons: [{
                    extend: 'pageLength',
                    className: 'btn bg-primary border border-0'
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
                emptyTable: "No se encontraron registros.",
            },
            ordering: false,
            fnDrawCallback: function() {
                if ($('#TablaEjecucionPre td').hasClass('dataTables_empty')) {
                    // Oculta los controles de paginación si la tabla está vacía
                    $('.dataTables_paginate').hide();
                    $('.dataTables_info').hide();
                    $('.dt-buttons').hide();
                    $('div.dataTables_filter').hide();
                } else {
                    // Muestra los controles de paginación si la tabla tiene datos
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                    $('.dt-buttons').show();
                    $('div.dataTables_filter').show();
                }
            }
        });
    });
    </script>

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>