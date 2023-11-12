<main id="main" class="main">

    <div class="pagetitle">
        <h1> Presupuesto
            <small>Nuevo</small>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>mantenimiento/presupuesto">Presupuesto</a>
                </li>
                <li class="breadcrumb-item active">Nuevo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata("error")): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <p><i class="icon fa fa-ban"></i>
                                        <?php echo $this->session->flashdata("error"); ?>
                                    </p>

                                </div>
                            <?php endif; ?>
                    <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/store" method="POST">
                                <div class="form-group">
                                    <label for="Año">Año:</label>
                                    <input type="text" class="form-control" id="Año" name="Año">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción:</label>
                                    <select name="descripcion" id="descripcion" class="form-control">
                                        <?php foreach ($descripciones as $descripcion): ?>
                                            <option value="<?php echo $descripcion->IDCuentaContable?>">
                                                <?php echo $descripcion->DescripcionCuentaContable; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="TotalPresupuestado">Total Presupuestado:</label>
                                    <input type="text" class="form-control" id="TotalPresupuestado"
                                        name="TotalPresupuestado">
                                </div>
                                <div class="form-group">
                                    <label for="origen_de_financiamiento">origen de financiamiento:</label>
                                    <select name="origen_de_financiamiento" id="origen_de_financiamiento" class="form-control">
                                        <?php foreach ($origen as $origen): ?>
                                            <option value="<?php echo $origen->id_of?>">
                                                <?php echo $origen->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuente_de_financiamiento">Fuente de financiamiento:</label>
                                    <select name="fuente_de_financiamiento" id="fuente_de_financiamiento" class="form-control">
                                        <?php foreach ($registros_financieros as $fuente): ?>
                                            <option value="<?php echo $fuente->id_ff?>">
                                                <?php echo $fuente->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="programa_id_pro">Programa:</label>
                                    <select name="programa_id_pro" id="programa_id_pro" class="form-control">
                                        <?php foreach ($programa as $prog): ?>
                                            <option value="<?php echo $prog->id_pro?>">
                                                <?php echo $prog->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="TotalModificado">Total Modificado:</label>
                                    <input type="text" class="form-control" id="TotalModificado" name="TotalModificado">
                                </div>
                                <div class="form-group">
                                <label for="mes">Mes:</label>
                                <select name="mes" id="mes" class="form-control">
                                            <?php
                                            // Obtén el mes actual en formato numérico
                                            $mesActual = date('n'); // 'n' devuelve el mes sin ceros iniciales

                                            // Definir un arreglo de nombres de meses
                                            $nombresMeses = array(
                                                'Enero', 'Febrero', 'Marzo', 'Abril',
                                                'Mayo', 'Junio', 'Julio', 'Agosto',
                                                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                                            );

                                            // Obtén el nombre del mes actual
                                            $mesActualNombre = $nombresMeses[$mesActual - 1];

                                            // Genera una opción para el mes actual
                                            echo "<option value='$mesActualNombre'>$mesActualNombre</option>";
                                            ?>
                                </select>



                                <div class="form-group">
                                    <label for="monto_mes">Monto para el Mes:</label>
                                    <input type="text" class="form-control" id="monto_mes" name="monto_mes">
                                </div>
                                
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-flat"><span
                                        class="fa fa-save"></span>Guardar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo base_url(); ?>mantenimiento/presupuesto" class="btn btn-danger"><span
                                        class="fa fa-remove"></span>Cancelar</a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        </div>
        </div>
    </section>
</main>




