<!-- librolist.php en application/views/admin/libro/ -->

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
                <form class="row g-3 mb-4" action="<?php echo base_url();?>LibroMayor/mostrarLibroMayor" method="post">
                    <div class="col-md-4">
                        <label for="fechaInicio" class="form-label">Fecha de Operación Desde:</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio">
                    </div>
                    <div class="col-md-4">
                        <label for="fechaFin" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="fechaFin" name="fecha_fin">
                    </div>
                    <div class="col-md-4">
                        <label for="busquedaCuentaContable" class="form-label">Buscar Cuenta:</label>
                        <input type="text" class="form-control" id="busquedaCuentaContable" name="busquedaCuentaContable" placeholder="Ingrese código o descripción">
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
                                <th>Fecha</th>
                                <th>N° Asiento</th>
                                <th>N° OP</th>
                                <th>Comprobante</th>
                                <th>Descripción del gasto</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Saldo</th>
                                <th>Cuenta Contable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($entradas)): ?>
                                <?php foreach ($entradas as $entrada): ?>
                                    <tr>
                                        <td><?php echo $entrada['FechaEmision']; ?></td>
                                        <td><?php echo $entrada['numero']; ?></td>
                                        <td><?php echo $entrada['Num_Asi_IDNum_Asi']; ?></td>
                                        <td><?php echo $entrada['comprobante']; ?></td>
                                        <td><?php echo $entrada['Descripcion']; ?></td>
                                        <td><?php echo $entrada['Debe']; ?></td>
                                        <td><?php echo $entrada['Haber']; ?></td>
                                        <td><?php // Calcular y mostrar el saldo ?></td>
                                        <td><?php echo $entrada['Codigo_CC']; ?> - <?php echo $entrada['Descripcion_CC']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron registros.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
