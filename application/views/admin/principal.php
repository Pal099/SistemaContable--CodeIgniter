<!-- Contenido Principal -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Informe Gerencial</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Columnas Izquierdas -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Tarjeta de cuántos obligados hay en el mes -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Obligados en <?php echo $monthInSpanish; ?></h5>
                                <!-- Nombre del mes en español -->
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard2-data-fill"></i>
                                    </div>
                                    <p class="card-text"><?php echo $total_obligados_mes; ?></p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Tarjeta de obligación en el mes -->

                    <!-- Tarjeta de cuántos Pagados hay en el mes -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Pagados en <?php echo $monthInSpanish; ?></h5>
                                <!-- Nombre del mes en español -->
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard2-data-fill"></i>
                                    </div>
                                    <p class="card-text"><?php echo $total_pagados_mes; ?></p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Tarjeta de pagados en el mes -->
                </div>
            </div><!-- Fin de las columnas izquierdas -->
        </div>
    </section>
</main>
