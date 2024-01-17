<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap5/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Cuadro de Resultados</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 ">
                        <h1>Cuadro de Resultados</h1>
                    </div>
                    <div class="col-md-6 mt-2 ">
                        <div class="d-flex justify-content-md-end">
                            <button type="button" class="btn btn-success" onclick="window.open('<?php echo base_url(); ?>mantenimiento/Balance_Gral/GenerarExcel')">
                                <i class="bi bi-file-pdf"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <section class="seccion_balance_general">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-4">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-hover table-sm align-middle  ">
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
                                                <tbody class="table-group-divider">
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
    </main>
</body>

</html>