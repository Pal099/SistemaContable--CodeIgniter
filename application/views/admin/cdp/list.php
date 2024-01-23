<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- jsPDF y Autotable para las datatable -->
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.umd.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.plugin.autotable.js"></script>
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
                <li class="breadcrumb-item">Presupuesto</li>
                <li class="breadcrumb-item">Certificado de Disponibilidad de Presupuesto</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="mt-4">
                        <h1>Certificado de Disponibilidad de Presupuesto</h1>
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
                                            <?php
                                            // Verificar si se ha enviado el formulario y si hay un número de asiento en la URL
                                            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero_asiento'])) {
                                                $numero_asiento = $_GET['numero_asiento'];
                                                echo '<a href="' . base_url('Pdf_cdp/generarPDF_cdp/' . $numero_asiento) . '">Generar PDF</a>';
                                            }
                                            ?>
                                            <table id="TablaCDP" class="table table-hover table-sm rounded-3">
                                                <thead>
                                                    <tr>
                                                        <th>Origen de Financiamiento</th>
                                                        <th>Fuente de Financiamiento</th>
                                                        <th>Programa</th>
                                                        <th>Código de Cuenta</th>
                                                        <th>Descripción de Cuenta</th>
                                                        <th>Numero de asiento</th>
                                                        <th>Presupuesto Vigente</th>
                                                        <th>CDP Anteriores</th>
                                                        <th>CDP Actual</th>
                                                        <th>Saldo Disponible</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($datos_vista as $dato): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $dato['nombre_origen'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['nombre_fuente'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['nombre_programa'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['Codigo_CC'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['Descripcion_CC'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['numero_asiento'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['pre_ene'] + $dato['pre_feb'] + $dato['pre_mar'] + $dato['pre_abr'] + $dato['pre_may'] + $dato['pre_jun'] + $dato['pre_jul'] + $dato['pre_ago'] + $dato['pre_sep'] + $dato['pre_oct'] + $dato['pre_nov'] + $dato['pre_dic'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['total_debe_cuenta'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['debe_num_asi_deta'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $dato['pre_ene'] + $dato['pre_feb'] + $dato['pre_mar'] + $dato['pre_abr'] + $dato['pre_may'] + $dato['pre_jun'] + $dato['pre_jul'] + $dato['pre_ago'] + $dato['pre_sep'] + $dato['pre_oct'] + $dato['pre_nov'] + $dato['pre_dic'] - $dato['total_debe_cuenta'] ?>
                                                        </td>
                                                    </tr>
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
            var table1 = $('#TablaCDP').DataTable({
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
                        text: '<i class="bi bi-filetype-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        action: function(e, dt, node, config) {
                            generarPDF();
                        }
                    },
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

    </main>
</body>

</html>