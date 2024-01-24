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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-container">
            <div class="pagetitle">
                <h1>Certificado de Disponibilidad de Presupuesto</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                        <li class="breadcrumb-item active">Listado de Certificado de Disponibilidad de Presupuesto </li>
                        
                    </ol>
                </nav>
            </div>

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                            <form method="GET" action="<?php echo base_url(); ?>obligaciones/Certific_disp_presu/busqueda_por_asiento">
                                <label for="numero_asiento">Buscar por Número de Asiento:</label>
                                <input type="text" name="numero_asiento" id="numero_asiento" />
                                <button type="submit">Buscar</button>
                            </form>

                            <?php
                            // Verificar si se ha enviado el formulario y si hay un número de asiento en la URL
                            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero_asiento'])) {
                                $numero_asiento = $_GET['numero_asiento'];
                                echo '<a href="' . base_url('Pdf_cdp/generarPDF_cdp/' . $numero_asiento) . '">Generar PDF</a>';
                            }
                            ?>




                                <table id="tabla" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Numero de asiento</th>

                                            <th>Programa</th>
                                            <th>SubPrograma</th>
                                            <th>Código de Cuenta</th>
                                            <th>O.F.</th>
                                            <th>F.F.</th>
                                            <th>Descripción de Cuenta</th>
                                            <th>Presupuesto Vigente</th>
                                            <th>Reserva Presupuestaria</th>

                                            <th>Obligado Actual</th>
                                            <th>Obligado Acumulado Anterior</th>
                                            <th>Saldo Disponible</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        <?php foreach ($datos_vista as $dato): $acumuladoAnterior = 0;
                                                    ?>
                                            <tr>
                                                
                                             <td>
                                                    <?= $dato['numero_asiento'] ?>
                                                </td>
                                                <td>
                                                    <?= $dato['nombre_programa'] ?>
                                                </td>
                                                
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    <?= $dato['codigo'] ?>
                                                </td>
                                                <td>
                                                    <?= $dato['nombre_fuente'] ?>
                                                </td>
                                                <td>
                                                    <?= $dato['nombre_origen'] ?>
                                                </td>

                                                <td>
                                                    <?= $dato['Descripcion_CC'] ?>
                                                </td>
                                                <td>
                                                <?= number_format($dato['Vigente'], 0, '.', ',') ?>
                                                    
                                                </td>
                                                
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                <?= isset($dato['total_debe_cuenta']) ? number_format($dato['total_debe_cuenta'], 0, '.', ',') : 0 ?>
                                                </td>
                                                <td>
                                                    
                                                <?= number_format($dato['acumulado_anterior'], 0, '.', ',') ?>
                                                    
                                                </td>
                                                

                                                <td>
                                                <?= number_format($dato['Vigente'] - (isset($dato['total_debe_cuenta']) ? $dato['total_debe_cuenta'] : 0) - $dato['acumulado_anterior'], 0, '.', ',') ?>

                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
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