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
                <li class="breadcrumb-item">Cuadro de Resultados</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="mt-4">
                        <h1>Cuadro de Resultados</h1>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_balance_general">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <table class="table table-hover table-sm align-middle mt-4" id="TablaBalanceGeneral">
                                                <thead>
                                                    <tr>
                                                        <th>Número de Cuenta</th>
                                                        <th>Descripción de la Cuenta</th>
                                                        <th>Total Debe</th>
                                                        <th>Total Haber</th>
                                                        <th>Total Deudor</th>
                                                        <th>Total Acreedor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cuentas as $cuenta) : ?>
                                                        <tr>
                                                            <td><?= $cuenta->Codigo_CC ?></td>
                                                            <td><?= $cuenta->Descripcion_CC ?></td>
                                                            <td><?= isset($cuenta->TotalDebe) ? number_format($cuenta->TotalDebe, 0, ',', '.') : 0 ?></td>
                                                            <td><?= isset($cuenta->TotalHaber) ? number_format($cuenta->TotalHaber, 0, ',', '.') : 0 ?></td>
                                                            <td><?= isset($cuenta->TotalDeudor) ? number_format($cuenta->TotalDeudor, 0, ',', '.') : 0 ?></td>
                                                            <td><?= isset($cuenta->TotalAcreedor) ? number_format($cuenta->TotalAcreedor, 0, ',', '.') : 0 ?></td>
                                                        </tr>
                                                        <?php if (isset($cuenta->cuentasHijas)) : ?>
                                                            <?php foreach ($cuenta->cuentasHijas as $cuentaHija) : ?>
                                                                <tr>
                                                                    <td><?= $cuentaHija->Codigo_CC ?></td>
                                                                    <td><?= $cuentaHija->Descripcion_CC ?></td>
                                                                    <td><?= isset($cuentaHija->TotalDebe) ? number_format($cuentaHija->TotalDebe, 0, ',', '.') : 0 ?></td>
                                                                    <td><?= isset($cuentaHija->TotalHaber) ? number_format($cuentaHija->TotalHaber, 0, ',', '.') : 0 ?></td>
                                                                    <td><?= isset($cuentaHija->TotalDeudor) ? number_format($cuentaHija->TotalDeudor, 0, ',', '.') : 0 ?></td>
                                                                    <td><?= isset($cuentaHija->TotalAcreedor) ? number_format($cuentaHija->TotalAcreedor, 0, ',', '.') : 0 ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
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
            $(document).ready(function() {
                var table1 = $('#TablaBalanceGeneral').DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                        '<"row"<"col-sm-12"t>>' +
                        '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10', '25', '50', 'Todo']
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