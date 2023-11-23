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
                    
                    <!-- Buscar Cuenta -->
                    <div class="col-md-12">
                        <label for="busquedaCuentaContable" class="form-label">Buscar Cuenta:</label>
                        <input type="text" class="form-control mb-2" id="busquedaCuentaContable" name="busquedaCuentaContable" placeholder="Ingrese código o descripción">
                    </div>
                    
                    <!-- Fechas -->
                    <div class="col-md-3">
                        <label for="fechaInicio" class="form-label">Fecha Desde:</label>
                        <input type="date" class="form-control mb-2" id="fechaInicio" name="fecha_inicio" style="width: 160px; padding: 0.375rem 0.75rem;">
                    </div>
                    <div class="col-md-3">
                        <label for="fechaFin" class="form-label">Fecha Hasta:</label>
                        <input type="date" class="form-control mb-2" id="fechaFin" name="fecha_fin" style="width: 160px; padding: 0.375rem 0.75rem;">
                    </div>
                    
                    <!-- Select para Ver Diario (puedes omitir este si no es necesario) -->
                    <div class="col-md-3">
                        <label for="verDiario" class="form-label">Ver Diario:</label>
                        <select class="form-select mb-2" id="verDiario" name="verDiario" style="width: 160px; padding: 0.375rem 0.75rem;">
                            <option value="todos">Todos</option>
                            <option value="libroDiarioBorrador">Libro diario borrador</option>
                            <option value="ordenPago">Orden de pago</option>
                        </select>
                    </div>
                    
                    <!-- Programa -->
                    <div class="col-md-3">
                        <label for="programa" class="form-label">Programa:</label>
                        <select class="form-select mb-2" id="programa" name="programa" style="width: 160px; ">
                            <option value="">Seleccionar</option>
                            <!-- Opciones dinámicas aquí -->
                        </select>
                    </div>
                    
                    <!-- Origen de Financiamiento -->
                    <div class="col-md-3">
                        <label for="origenFinanciamiento" class="form-label">Origen Financiamiento:</label>
                        <select class="form-select mb-2" id="origenFinanciamiento" name="origenFinanciamiento" style="width: 200px; padding: 0.375rem 0.75rem;">
                            <option value="">Seleccionar</option>
                            <!-- Opciones dinámicas aquí -->
                        </select>
                    </div>
                    
                    <!-- Fuente de Financiamiento -->
                    <div class="col-md-3">
                        <label for="fuenteFinanciamiento" class="form-label">Fuente Financiamiento:</label>
                        <select class="form-select mb-2" id="fuenteFinanciamiento" name="fuenteFinanciamiento" style="width: 160px; padding: 0.375rem 0.75rem;">
                            <option value="">Seleccionar</option>
                            <!-- Opciones dinámicas aquí -->
                        </select>
                    </div>

                    <!-- Botón de búsqueda -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
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
