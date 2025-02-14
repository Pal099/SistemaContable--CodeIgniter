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
                <li class="breadcrumb-item active">Certificado de Disponibilidad de Presupuesto</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Certificado de Disponibilidad de Presupuesto</h1>
                    </div>
                    <div class="col-md-6 mt-4 ">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="col-md-12">
                                <form method="GET"
                                    action="<?php echo base_url(); ?>obligaciones/Certific_disp_presu/busqueda_por_asiento">
                                    <div class="input-group mb-3 ">
                                        <input type="text" class="form-control" name="numero_asiento"
                                            id="numero_asiento" placeholder="Buscar por Número de Asiento">
                                        <button class="btn btn-primary" type="submit" id="button-addon2">
                                            <i class="bi bi-search"></i> Buscar
                                        </button>
                                        <!-- Verificar si se ha enviado el formulario y si hay un número de asiento en la URL -->
                                        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero_asiento'])): 
                                        $numero_asiento = $_GET['numero_asiento']; ?>
                                        <a href="<?php echo base_url('Pdf_cdp/generarPDF_cdp/' . $numero_asiento); ?>"
                                            class="btn btn-danger" target="_blank" title="Generar PDF">
                                            <i class="bi bi-file-earmark-pdf"></i> PDF
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Page Title -->
            <hr> <!-- barra separadora -->
            <section class="section dashboard">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <table id="tabla"
                                                class="table table-hover table-bordered table-sm rounded-3 mt-4">
                                                <thead class="align-middle">
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
                                                    <tr class="align-items-center">

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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Script para las tabla de CDP -->
                <script>
                $(document).ready(function() {
                    $('#tabla').DataTable({
                        paging: true,
                        pageLength: 10,
                        lengthChange: true,
                        searching: true,
                        info: true,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                        },
                        columnDefs: [{
                                orderable: true,
                                targets: 0
                            }, // Habilitar la ordenación solo en la primera columna
                            {
                                orderable: false,
                                targets: '_all'
                            } // Deshabilitar la ordenación en todas las demás
                        ]
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