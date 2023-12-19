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

   
    <form class="row" action="<?php echo base_url();?>LibroMayor/mostrarLibroMayor" method="post">
                    <!-- Columna para búsqueda de cuenta y código -->
                    <div class="col-md-4">
                        <label for="busquedaCuentaContable" class="form-label">Buscar Cuenta:</label>
                        <input type="text" class="form-control mb-2" id="busquedaCuentaContable" name="busquedaCuentaContable" placeholder="Ingrese código o descripción">
                        <!-- Suponiendo que tienes un campo en tu base de datos llamado 'codigo' -->
                        <input type="text" class="form-control" id="codigoCuenta" name="codigoCuenta" placeholder="Código de cuenta" readonly>
                    </div>

                    <!-- Columna para fechas y selects -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Fecha Desde y Hasta -->
                            <div class="col-md-6">
                                <label for="fechaInicio" class="form-label">Fecha de Operación Desde:</label>
                                <input type="date" class="form-control mb-2" id="fechaInicio" name="fecha_inicio">
                                <label for="fechaFin" class="form-label">Hasta:</label>
                                <input type="date" class="form-control mb-2" id="fechaFin" name="fecha_fin">
                            </div>
                            <!-- Selects -->
                            <div class="col-md-6">
                                <label for="verDiario" class="form-label">Ver Diario:</label>
                                <select class="form-select mb-2" id="verDiario" name="verDiario">
                                    <option value="todos">Todos</option>
                                    <option value="libroDiarioBorrador">Libro diario borrador</option>
                                    <option value="ordenPago">Orden de pago</option>
                                </select>
                                <label for="programa" class="form-label">Programa:</label>
                                <select class="form-select mb-2" id="programa" name="programa">
                                    <option value="todos">Todos</option>
                                    <!-- Añadir más opciones de programas aquí -->
                                </select>
                                <label for="origenFinanciamiento" class="form-label">Origen de Financiamiento:</label>
                                <select class="form-select mb-2" id="origenFinanciamiento" name="origenFinanciamiento">
                                    <option value="todos">Todos</option>
                                    <!-- Añadir más opciones de origen de financiamiento aquí -->
                                </select>
                                <label for="fuenteFinanciamiento" class="form-label">Fuente de Financiamiento:</label>
                                <select class="form-select mb-2" id="fuenteFinanciamiento" name="fuenteFinanciamiento">
                                    <option value="todos">Todos</option>
                                    <!-- Añadir más opciones de fuente de financiamiento aquí -->
                                </select>
                            </div>
                        </div>
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
<!-- Inicio del Script de Búsqueda -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclusión de jQuery -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#busquedaCuentaContable").on("keyup", function() {
            var descripcion = $(this).val();
            if(descripcion !== '') {
                $.ajax({
                    url: "<?php echo base_url();?>LibroMayor/buscarCuenta", // Asegúrate de que esta URL corresponda al método en tu controlador
                    type: "POST",
                    data: {descripcion_cc: descripcion},
                    success: function(data) {
                        var cuentas = JSON.parse(data);
                        // Aquí va la lógica para actualizar la interfaz de usuario con los resultados
                        // Esto podría ser rellenar una lista desplegable con las cuentas o
                        // mostrar sugerencias de autocompletado debajo del campo de entrada
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al obtener datos: ", textStatus, errorThrown);
                        // Manejar errores de la petición aquí
                    }
                });
            } else {
                // Lógica para limpiar los resultados de búsqueda previos si el campo está vacío
            }
        });
    });
</script>
<!-- Fin del Script de Búsqueda -->