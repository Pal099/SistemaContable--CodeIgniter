<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - Sistema de Gestión</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>assets/img/favicon.png" rel="icon">
    <link href="<?php echo base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- ECharts -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.0/dist/echarts.min.js"></script>
</head>

<body>
    <!-- Contenido Principal -->
    <main id="main" class="main" >
        <div class="pagetitle">
            <h1>Informe Gerencial</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <!-- Columnas Izquierdas -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Tarjeta de Obligados del mes -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Obligados en <?php echo isset($monthInSpanish) ? $monthInSpanish : date('F'); ?></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-clipboard2-data-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo isset($total_obligados_mes) ? $total_obligados_mes : '0'; ?></h6>
                                            <?php if(isset($total_obligados_anterior) && $total_obligados_anterior > 0): ?>
                                            <span class="text-<?php echo $total_obligados_mes > $total_obligados_anterior ? 'success' : 'danger'; ?> small pt-1 fw-bold">
                                                <?php echo round((($total_obligados_mes / $total_obligados_anterior) * 100) - 100, 1); ?>%
                                            </span>
                                            <span class="text-muted small pt-2 ps-1">vs mes anterior</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Pagados del mes -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pagados en <?php echo isset($monthInSpanish) ? $monthInSpanish : date('F'); ?></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?php echo isset($total_pagados_mes) ? $total_pagados_mes : '0'; ?></h6>
                                            <span class="text-success small pt-1 fw-bold">
                                                <?php 
                                                $obligados = isset($total_obligados_mes) ? $total_obligados_mes : 1;
                                                $pagados = isset($total_pagados_mes) ? $total_pagados_mes : 0;
                                                echo $obligados > 0 ? round(($pagados / $obligados) * 100, 1) : 0; 
                                                ?>%
                                            </span>
                                            <span class="text-muted small pt-2 ps-1">de efectividad</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Presupuesto Total -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Presupuesto Total</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-wallet2"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>$<?php echo isset($presupuesto_total) ? number_format($presupuesto_total, 2) : '0.00'; ?></h6>
                                            <span class="text-info small pt-1 fw-bold">
                                                <?php echo isset($presupuesto_ejecutado) && isset($presupuesto_total) && $presupuesto_total > 0 ? round(($presupuesto_ejecutado / $presupuesto_total) * 100, 1) : 0; ?>%
                                            </span>
                                            <span class="text-muted small pt-2 ps-1">ejecutado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta de Gastos del mes -->
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Gastos del Mes</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>$<?php echo isset($gastos_mes) ? number_format($gastos_mes, 2) : '0.00'; ?></h6>
                                            <span class="text-muted small">
                                                <?php echo isset($total_comprobantes) ? $total_comprobantes : '0'; ?> comprobantes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de tendencias -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tendencia de Obligaciones vs Pagos <span>/Últimos 6 meses</span></h5>
                                    <div id="reportsChart"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de actividad reciente -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Últimas Obligaciones <span>| Este mes</span></h5>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Proveedor</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($ultimas_obligaciones)): ?>
                                                <?php foreach($ultimas_obligaciones as $obligacion): ?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y', strtotime($obligacion->FechaEmision)); ?></td>
                                                        <td><?php echo $obligacion->razon_social; ?></td>
                                                        <td>$<?php echo number_format($obligacion->MontoTotal, 2); ?></td>
                                                        <td>
                                                            <span class="badge bg-<?php echo $obligacion->estado == 4 ? 'success' : ($obligacion->estado == 3 ? 'warning' : 'secondary'); ?>">
                                                                <?php 
                                                                switch($obligacion->estado) {
                                                                    case 4: echo 'Pagado'; break;
                                                                    case 3: echo 'Pendiente'; break;
                                                                    default: echo 'Obligado'; break;
                                                                }
                                                                ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No hay obligaciones recientes</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha -->
                <div class="col-lg-4">
                    <!-- Gráfico circular de estado de pagos -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Estado de Obligaciones <span>| <?php echo isset($monthInSpanish) ? $monthInSpanish : date('F'); ?></span></h5>
                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                            <div class="text-center mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <h6 class="text-success"><?php echo isset($total_pagados_mes) ? $total_pagados_mes : '0'; ?></h6>
                                        <small>Pagados</small>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-warning"><?php echo isset($total_pendientes) ? $total_pendientes : '0'; ?></h6>
                                        <small>Pendientes</small>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-secondary"><?php echo isset($total_obligados_mes) ? $total_obligados_mes : '0'; ?></h6>
                                        <small>Obligados</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Proveedores -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Top Proveedores <span>| Este mes</span></h5>
                            <div class="news">
                                <?php if(isset($top_proveedores)): ?>
                                    <?php foreach($top_proveedores as $proveedor): ?>
                                        <div class="post-item clearfix border-bottom pb-3 mb-3">
                                            <h4><?php echo substr($proveedor->razon_social, 0, 25) . (strlen($proveedor->razon_social) > 25 ? '...' : ''); ?></h4>
                                            <p class="mb-0">
                                                <span class="fw-bold text-primary">$<?php echo number_format($proveedor->total_monto, 2); ?></span>
                                                <br><small class="text-muted"><?php echo $proveedor->cantidad_obligaciones; ?> obligaciones</small>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-center text-muted">No hay datos de proveedores</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de Presupuesto -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ejecución Presupuestaria</h5>
                            <div class="news">
                                <div class="post-item clearfix border-bottom pb-3 mb-3">
                                    <h4><i class="bi bi-pie-chart text-primary"></i> Presupuestado</h4>
                                    <p class="mb-0">
                                        <span class="fw-bold">$<?php echo isset($presupuesto_total) ? number_format($presupuesto_total, 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                                <div class="post-item clearfix border-bottom pb-3 mb-3">
                                    <h4><i class="bi bi-graph-up text-success"></i> Ejecutado</h4>
                                    <p class="mb-0">
                                        <span class="fw-bold text-success">$<?php echo isset($presupuesto_ejecutado) ? number_format($presupuesto_ejecutado, 2) : '0.00'; ?></span>
                                    </p>
                                </div>
                                <div class="post-item clearfix">
                                    <h4><i class="bi bi-wallet text-info"></i> Disponible</h4>
                                    <p class="mb-0">
                                        <?php $disponible = (isset($presupuesto_total) ? $presupuesto_total : 0) - (isset($presupuesto_ejecutado) ? $presupuesto_ejecutado : 0); ?>
                                        <span class="fw-bold text-info">$<?php echo number_format($disponible, 2); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Sistema de Gestión</span></strong>. Todos los derechos reservados
        </div>
        <div class="credits">
            Desarrollado por <a href="#">Tu Empresa</a> - <?php echo date('Y'); ?>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/simple-datatables/simple-datatables.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

    <!-- Scripts personalizados del dashboard -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Gráfico de tendencias
        if(document.querySelector("#reportsChart")) {
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Obligados',
                    data: <?php echo isset($datos_grafico['obligados']) ? json_encode($datos_grafico['obligados']) : '[0,0,0,0,0,0]'; ?>,
                }, {
                    name: 'Pagados',
                    data: <?php echo isset($datos_grafico['pagados']) ? json_encode($datos_grafico['pagados']) : '[0,0,0,0,0,0]'; ?>,
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: { show: false }
                },
                markers: { size: 4 },
                colors: ['#4154f1', '#2eca6a'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: <?php echo isset($datos_grafico['meses']) ? json_encode($datos_grafico['meses']) : '["Ene","Feb","Mar","Abr","May","Jun"]'; ?>
                },
                tooltip: {
                    x: { format: 'MMM' },
                }
            }).render();
        }

        // Gráfico circular
        if(document.querySelector("#trafficChart")) {
            echarts.init(document.querySelector("#trafficChart")).setOption({
                tooltip: { 
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                legend: { 
                    top: '5%', 
                    left: 'center' 
                },
                series: [{
                    name: 'Estado de Obligaciones',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    center: ['50%', '60%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: { 
                        show: false, 
                        position: 'center' 
                    },
                    emphasis: { 
                        label: { 
                            show: true, 
                            fontSize: '18', 
                            fontWeight: 'bold' 
                        } 
                    },
                    labelLine: { show: false },
                    data: [
                        { 
                            value: <?php echo isset($total_pagados_mes) ? $total_pagados_mes : 0; ?>, 
                            name: 'Pagados',
                            itemStyle: { color: '#2eca6a' }
                        },
                        { 
                            value: <?php echo isset($total_pendientes) ? $total_pendientes : 0; ?>, 
                            name: 'Pendientes',
                            itemStyle: { color: '#ffbb2c' }
                        },
                        { 
                            value: <?php echo isset($total_obligados_sin_pagar) ? $total_obligados_sin_pagar : 0; ?>, 
                            name: 'Obligados',
                            itemStyle: { color: '#4154f1' }
                        }
                    ]
                }]
            });
        }
    });
    </script>

</body>
</html>