<style>
    .form-container {
        display:flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 5px;
    }

    /*.btn-container {
        display: flex;
        gap: 10px;
    }

    .btn-container button {
        padding: 10px 15px;
        font-size: 14px;
    }*/

</style>
<main id="main" class="main">
    <!-- Content Wrapper. Contains page content -->
    <div class="pagetitle">
        <h1>Deposito Detalle</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item active">Listado</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <class class="form-container">

            <form action="<?php echo base_url(); ?>obligaciones/Excel_pago_obli_dep/ObtenerDatosVista" method="POST" class="form-container">
    <div class="form-group">
        <label for="fechaInicio">Fecha de inicio:</label>
        <input type="date" name="fechaInicio" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="fechaFin">Fecha de fin:</label>
        <input type="date" name="fechaFin" class="form-control" required>
    </div>

    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
</form>

<!-- Formulario para Generar Excel -->
<form action="<?php echo base_url(); ?>obligaciones/Excel_pago_obli_dep/GenerarExcel" method="POST" class="form-container">
    <!-- Agregar campos ocultos con las fechas filtradas -->
    <input type="hidden" name="fechaInicio" value="<?= isset($fechaInicio) ? $fechaInicio : ''; ?>">
    <input type="hidden" name="fechaFin" value="<?= isset($fechaFin) ? $fechaFin : ''; ?>">

    <div class="btn-container">
        <button type="submit" class="btn btn-success boton"><span></span>Generar Excel</button>
    </div>
</form>



            </class>
            <div class="col-lg-12">

                <div class="row">
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Código</th>
                                    <th>op</th>
                                    <th>proveedor</th>
                                    <th>Comprobante</th>
                                    <th>debe</th>
                                    <th>haber</th>
                                    <th>Cod Cuenta Contable</th>
                                    <th>Cuenta Contable</th>
                                    <th>Balance</th>
                                    <th>Descripcion</th>
                                    <th>Numero de programa</th>
                                    <th>Programa</th>
                                    <th>Referencia Diario</th>
                                    <th>Origen de financiamiento</th>
                                    <th>Fuente de financiamiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datos as $dato): ?>

                                    <tr>
                                        <td>
                                            <?= $dato->FechaEmision ?>
                                        </td>
                                        <td>
                                            <?= $dato->num_asi ?>
                                        </td>
                                        <td>
                                            <?= $dato->op ?>
                                        </td>
                                        <td>
                                            <?= $dato->razon_social ?>
                                        </td>
                                        <td>
                                            <?= $dato->comprobante ?>
                                        </td>
                                        <td>
                                            <?= $dato->totalDebe ?>
                                        </td>
                                        <td>
                                            <?= $dato->totalHaber ?>
                                        </td>
                                        <td>
                                            <?= $dato->Codigo_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->Descripcion_CC ?>
                                        </td>
                                        <td>
                                            <?= $dato->balance ?>
                                        </td>
                                        <td>?</td>
                                        <td>
                                            <?= $dato->num_programa ?>
                                        </td>
                                        <td>
                                            <?= $dato->nombre ?>
                                        </td>
                                        <td>
                                            <?= $dato->num ?>
                                        </td>
                                        <td>
                                            <?= $dato->of ?>
                                        </td>
                                        <td>
                                            <?= $dato->ff ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</main>
