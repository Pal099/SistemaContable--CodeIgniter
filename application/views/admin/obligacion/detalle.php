<main id="main" class="main">
    <!-- Contenido de la Nueva Vista -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <h2>Solicitud de Transferencia de Recursos</h2>

                <form action="<?php echo base_url(); ?>obligaciones/Excel_pago_obli_dep/resumenPorMeses" method="POST"
                    class="form-container">
                    <div class="form-group">
                        <label for="mes">Seleccione el mes:</label>
                        <select name="mes" class="form-control" required>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn btn-primary">Filtrar por Mes</button>
                    </div>
                </form>

                <!-- Tabla para Mostrar Suma de Debe y Haber por Mes -->
                <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Cuenta Contable</th>
                <th>Total Debe</th>
                <th>Total Haber</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumenPorMeses as $resumen): ?>
                <tr>
                    <td><?= $resumen->mes ?></td>
                    <td><?= $resumen->IDCuentaContable ?></td>
                    <td><?= $resumen->totalDebe ?></td>
                    <td><?= $resumen->totalHaber ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>
        </div>
    </section>
</main>