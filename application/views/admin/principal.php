<!-- =============================================== -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Informe Gerencial</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Monto total</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Revenue Card -->
                    <!-- Agregar compra Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Agregar compra</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-plus"></i>
                                    </div>
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#agregarCompraModal">Agregar</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Agregar compra Card -->
                    <!-- Promociones Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Promociones</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <!-- Agrega aquí el contenido de las promociones -->
                                </div>
                            </div>
                        </div>
                    </div><!-- End Promociones Card -->
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Mi carrito</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <!-- Agrega aquí el contenido de tu carrito -->
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->
                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">
                            <!-- Agrega aquí el contenido de los informes -->
                        </div>
                    </div><!-- End Reports -->
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <!-- Agrega aquí el contenido de las ventas recientes -->
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div><!-- End Left side columns -->
            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Agrega aquí el contenido de las columnas del lado derecho -->
            </div><!-- End Right side columns -->
            <div class="copyright">
                <strong>Total de ventas por mes.</strong>
            </div>
            <div class="credits">
                <b>Gráfico</b>
            </div>
        </div>
    </section>
</main>

<!-- Agregar Compra Modal -->
<div class="modal fade" id="agregarCompraModal" tabindex="-1" role="dialog" aria-labelledby="agregarCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCompraModalLabel">Agregar Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
            </div>
        </div>
    </div>
</div>
