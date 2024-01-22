<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/mantenimiento/presupuesto">Listado Presupuesto</a></li>
                <li class="breadcrumb-item">Editar presupuesto</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar presupuesto</h1>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                                <input class="form-check-input" type="checkbox" role="switch" id="camposOpcionalesSwitch">
                                <label class="form-check-label" for="camposOpcionalesSwitch">Editar el presupuesto por mes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_editar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/update" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <input type="hidden" value="<?php echo $presupuesto->ID_Presupuesto; ?>" name="ID_Presupuesto">
                                                    <div class="form-group col-md-4">
                                                        <label for="Año">Año:</label>
                                                        <input type="number" class="form-control" id="Año" name="Año" value="<?php echo $presupuesto->Año ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="Idcuentacontable">Cuenta Contable:</label>
                                                        <select name="Idcuentacontable" id="Idcuentacontable" class="form-control" required>
                                                            <?php foreach ($cuentacontable as $cc) : ?>
                                                                <option value="<?php echo $cc->IDCuentaContable ?>">
                                                                    <?php echo $cc->Descripcion_CC; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                    <label for="TotalPresupuestado">Total Presupuestado:</label>
                                                    <div class="input-group input-group-sm">
                                                        <?php if (isset($presupuesto->TotalPresupuestado)): ?>
                                                            <?php $totalPresupuestado_value = number_format($presupuesto->TotalPresupuestado, 0, ',', '.'); ?>
                                                            <input type="text"
                                                                class="form-control small border-3 bg-transparent"
                                                                id="TotalPresupuestado"
                                                                name="TotalPresupuestado"
                                                                value="<?php echo $totalPresupuestado_value; ?>"
                                                                oninput="formatNumber('TotalPresupuestado', this)">
                                                        <?php else: ?>
                                                            <input type="number"
                                                                class="form-control small border-3 bg-transparent"
                                                                id="TotalPresupuestado"
                                                                name="TotalPresupuestado"
                                                                oninput="formatNumber('TotalPresupuestado', this)">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>


                                                    <div class="form-group col-md-4">
                                                        <label for="origen_de_financiamiento_id_of">Origen de Financiamiento:</label>
                                                        <select name="origen_de_financiamiento_id_of" id="origen_de_financiamiento_id_of" class="form-control" required>
                                                            <?php foreach ($origen as $o) : ?>
                                                                <option value="<?php echo $o->id_of ?>">
                                                                    <?php echo $o->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="fuente_de_financiamiento_id_ff">Fuente de Financiamiento:</label>
                                                        <select name="fuente_de_financiamiento_id_ff" id="fuente_de_financiamiento_id_ff" class="form-control" required>
                                                            <?php foreach ($registros_financieros as $fuente) : ?>
                                                                <option value="<?php echo $fuente->id_ff ?>">
                                                                    <?php echo $fuente->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="programa_id_pro">Programa:</label>
                                                        <select name="programa_id_pro" id="programa_id_pro" class="form-control" required>
                                                            <?php foreach ($programa as $prog) : ?>
                                                                <option value="<?php echo $prog->id_pro ?>">
                                                                    <?php echo $prog->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="TotalModificado">Total Modificado:</label>
                                                        <input type="number" class="form-control" id="TotalModificado" name="TotalModificado" value="<?php echo $presupuesto->TotalModificado ?>">
                                                    </div>
                                                    <!-- Campos de los meses del presupuesto -->
                                                    <div class="collapse mt-4" id="camposMesesCollapse">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_ene">Presupuesto Enero:</label>
                                                                    <input type="number" class="form-control" id="pre_ene" name="pre_ene" value="<?php echo $presupuesto->pre_ene ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_jul">Presupuesto Julio:</label>
                                                                    <input type="number" class="form-control" id="pre_jul" name="pre_jul" value="<?php echo $presupuesto->pre_jul ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_feb">Presupuesto Febrero:</label>
                                                                    <input type="number" class="form-control" id="pre_feb" name="pre_feb" value="<?php echo $presupuesto->pre_feb ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_ago">Presupuesto Agosto:</label>
                                                                    <input type="number" class="form-control" id="pre_ago" name="pre_ago" value="<?php echo $presupuesto->pre_ago ?>">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_mar">Presupuesto Marzo:</label>
                                                                    <input type="number" class="form-control" id="pre_mar" name="pre_mar" value="<?php echo $presupuesto->pre_mar ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_sep">Presupuesto Septiembre:</label>
                                                                    <input type="number" class="form-control" id="pre_sep" name="pre_sep" value="<?php echo $presupuesto->pre_sep ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_abr">Presupuesto Abril:</label>
                                                                    <input type="number" class="form-control" id="pre_abr" name="pre_abr" value="<?php echo $presupuesto->pre_abr ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_oct">Presupuesto Octubre:</label>
                                                                    <input type="number" class="form-control" id="pre_oct" name="pre_oct" value="<?php echo $presupuesto->pre_oct ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_may">Presupuesto Mayo:</label>
                                                                    <input type="number" class="form-control" id="pre_may" name="pre_may" value="<?php echo $presupuesto->pre_may ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_nov">Presupuesto Noviembre:</label>
                                                                    <input type="number" class="form-control" id="pre_nov" name="pre_nov" value="<?php echo $presupuesto->pre_nov ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="pre_jun">Presupuesto Junio:</label>
                                                                    <input type="number" class="form-control" id="pre_jun" name="pre_jun" value="<?php echo $presupuesto->pre_jun ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="pre_dic">Presupuesto Diciembre:</label>
                                                                    <input type="number" class="form-control" id="pre_dic" name="pre_dic" value="<?php echo $presupuesto->pre_dic ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-3 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span class="fa fa-save"></span>Guardar</button>
                                    <button class="btn btn-danger ml-3" onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/presupuesto'">
                                        <i class="fa fa-remove"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <!-- Script para mostrar los campos de los meses -->
        <script>
            document.getElementById('camposOpcionalesSwitch').addEventListener('change', function() {
                var camposMesesCollapse = new bootstrap.Collapse(document.getElementById('camposMesesCollapse'));
                camposMesesCollapse.toggle();
            });
        </script>

        <!-- Script de DataTable de jquery -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>


        <script>
    function formatNumber(id, input) {
        var value = input.value.replace(/\D/g, '');
        input.value = Intl.NumberFormat('es-ES').format(value);
    }
</script>
    </main>
</body>

</html>