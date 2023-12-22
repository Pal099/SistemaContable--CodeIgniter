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
                <form class="row g-3 mb-4" action="<?php echo base_url();?>LibroMayor/" method="post">
                    <div class="col-md-3">
                        <label for="fechaInicio" class="form-label">Fecha de Operación Desde:</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="fechaFin" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="fechaFin" name="fecha_fin">
                    </div>
                    <div class="col-md-3">
                      <label for="busquedaCuentaContable" class="form-label">Buscar Cuenta:</label>
                          <input type="text" class="form-control mb-2" id="busquedaCuentaContable" placeholder="Ingrese código o descripción">
                        </div>
                        <div id="resultadosBusqueda" class="col-md-12 mt-2"></div>

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
                    
                    <div class="col-3">
                        <br>
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
<script>
    $(document).ready(function() {
        $('#busquedaCuentaContable').on('input', function() {
            var descripcion = $(this).val();
            if (descripcion !== '') {
                $.ajax({
                    url: '<?php echo base_url();?>LibroMayor/buscarCuentaContable',
                    type: 'POST',
                    data: { descripcion_cc: descripcion },
                    success: function(data) {
                        var cuentas = JSON.parse(data);
                        var selectHtml = '<select id="selectorCuentaContable">';
                        $.each(cuentas, function(i, cuenta) {
                            selectHtml += '<option value="' + cuenta.IDCuentaContable + '">' + cuenta.Descripcion_CC + '</option>';
                        });
                        selectHtml += '</select>';
                        $('#resultadosBusqueda').html(selectHtml);

                        // Listener para el selector de cuentas
                        $('#selectorCuentaContable').on('change', function() {
                            var idCuentaContable = $(this).val();
                            $.ajax({
                                url: '<?php echo base_url();?>LibroMayor/filtrarEntradasPorCuentaContable',
                                type: 'POST',
                                data: { idCuentaContable: idCuentaContable },
                                success: function(data) {
                                    var entradas = JSON.parse(data);
                                    var tbodyHtml = '';
                                    $.each(entradas, function(i, entrada) {
                                        tbodyHtml += '<tr>' +
                                            '<td>' + entrada.FechaEmision + '</td>' +
                                            '<td>' + entrada.numero + '</td>' +
                                            '<td>' + entrada.Num_Asi_IDNum_Asi + '</td>' +
                                            '<td>' + entrada.comprobante + '</td>' +
                                            '<td>' + entrada.Descripcion + '</td>' +
                                            '<td>' + entrada.Debe + '</td>' +
                                            '<td>' + entrada.Haber + '</td>' +
                                            '<td>' + (entrada.Debe - entrada.Haber) + '</td>' + // Calculo del saldo
                                            '<td>' + entrada.Codigo_CC + ' - ' + entrada.Descripcion_CC + '</td>' +
                                            '</tr>';
                                    });
                                    $('#tablaResultados tbody').html(tbodyHtml);
                                }
                            });
                        });
                    }
                });
            } else {
                $('#resultadosBusqueda').html(''); // Limpia los resultados si el campo de búsqueda está vacío
                $('#tablaResultados tbody').html(''); // Limpia la tabla
            }
        });
    });
</script>