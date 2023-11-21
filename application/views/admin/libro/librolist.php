<main id="main" class="main">
    <div class="pagetitle">
        <h1>Libro Mayor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
                <li class="breadcrumb-item active">Libro Mayor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <!-- Formulario para Filtros -->
                <form class="row g-3 mb-4">
                    <!-- Agrega esto en tu formulario de búsqueda en librolist.php -->
<div class="row mb-3">
    <label for="busquedaCuentaContable" class="col-sm-2 col-form-label">Buscar Cuenta:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="busquedaCuentaContable" name="busquedaCuentaContable" placeholder="Ingrese código o descripción">
    </div>
</div>

                    <div class="col-md-4">
                        <label for="fechaInicio" class="form-label">Fecha de Operación Desde:</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                    </div>
                    <div class="col-md-4">
                        <label for="fechaFin" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                    </div>
                    <div class="col-md-4">
                        <!-- Otros filtros como Programa, Origen de Financiamiento, etc. -->
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
                
                <!-- Tabla de Resultados -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>N° Asiento</th>
                                <th>N° OP</th>
                                <th>Fecha</th>
                                <th>Comprobante</th>
                                <th>Descripción del gasto</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Saldo</th>
                                <!-- Agregar más columnas según sea necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se cargarían los datos del Libro Mayor -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
