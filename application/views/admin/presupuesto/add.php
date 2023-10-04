<main id="main" class="main">

    <div class="pagetitle">
        <h1> Presupuesto
            <small>Nuevo</small>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
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
                                    <label for="Anio">Año:</label>
                                    <input type="text" class="form-control" id="Anio" name="Anio">
                                </div>
                                <div class="form-group">
                                    <label for="Descripcion">Descripcion:</label>
                                    <input type="text" class="form-control" id="Descripcion" name="Descripcion">
                                </div>
                                <div class="form-group">
                                    <label for="TotalPresupuestado">Total Presupuetado:</label>
                                    <input type="text" class="form-control" id="TotalPresupuestado"
                                        name="TotalPresupuestado">
                                </div>
                                <div class="form-group">
                                    <label for="origen_de_financiamiento_id_of">origen de financiamiento:</label>
                                    <select name="origen_de_financiamiento_id_of" id="origen_de_financiamiento_id_of" class="form-control">
                                        <?php foreach ($origen as $origen): ?>
                                            <option value="<?php echo $origen->id_of?>">
                                                <?php echo $origen->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuente_de_financiamiento_id_ff">Fuente de financiamiento:</label>
                                    <select name="fuente_de_financiamiento_id_ff" id="fuente_de_financiamiento_id_ff" class="form-control">
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
                                    <label for="pre_ene">Enero:</label>
                                    <input type="text" class="form-control" id="pre_ene" name="pre_ene">
                                </div>
                                <div class="form-group">
                                    <label for="pre_feb">Febrero:</label>
                                    <input type="text" class="form-control" id="pre_feb" name="pre_feb">
                                </div>
                                <div class="form-group">
                                    <label for="pre_mar">Marzo:</label>
                                    <input type="text" class="form-control" id="pre_mar" name="pre_mar">
                                </div>
                                <div class="form-group">
                                    <label for="pre_abr">Abril:</label>
                                    <input type="text" class="form-control" id="pre_abr" name="pre_abr">
                                </div>
                                <div class="form-group">
                                    <label for="pre_may">Mayo:</label>
                                    <input type="text" class="form-control" id="pre_may" name="pre_may">
                                </div>
                                <div class="form-group">
                                    <label for="pre_jun">Junio:</label>
                                    <input type="text" class="form-control" id="pre_jun" name="pre_jun">
                                </div>
                                <div class="form-group">
                                    <label for="pre_jul">Julio:</label>
                                    <input type="text" class="form-control" id="pre_jul" name="pre_jul">
                                </div>
                                <div class="form-group">
                                    <label for="pre_ago">Agosto:</label>
                                    <input type="text" class="form-control" id="pre_ago" name="pre_ago">
                                </div>
                                <div class="form-group">
                                    <label for="pre_sep">Septiembre:</label>
                                    <input type="text" class="form-control" id="pre_sep" name="pre_sep">
                                </div>
                                <div class="form-group">
                                    <label for="pre_oct">Octubre:</label>
                                    <input type="text" class="form-control" id="pre_oct" name="pre_oct">
                                </div>
                                <div class="form-group">
                                    <label for="pre_nov">Noviembre:</label>
                                    <input type="text" class="form-control" id="pre_nov" name="pre_nov">
                                </div>
                                <div class="form-group">
                                    <label for="pre_dic">Diciembre:</label>
                                    <input type="text" class="form-control" id="pre_dic" name="pre_dic">
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