<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_presupuesto.css" rel="stylesheet">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Presupuesto</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/mantenimiento/proveedores">Proveedores</a></li>
                <li class="breadcrumb-item">Agregar proveedor</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar proveedor</h1>
                    </div>
                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_proveedores">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>mantenimiento/proveedores/store" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <?php if ($this->session->flashdata("error")): ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <div class="form-group col-md-6">
                                                        <label for="ruc">RUC:</label>
                                                        <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo set_value('ruc'); ?>" required>
                                                        <?php echo form_error('ruc', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="razon_social">Razón Social:</label>
                                                        <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo set_value('razon_social'); ?>" required>
                                                        <?php echo form_error('razon_social', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="direccion">Dirección:</label>
                                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo set_value('direccion'); ?>" required>
                                                        <?php echo form_error('direccion', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="telefono">Teléfono:</label>
                                                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo set_value('telefono'); ?>" required>
                                                        <?php echo form_error('telefono', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="email">Email:</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
                                                        <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="observacion">Observación:</label>
                                                        <input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo set_value('observacion'); ?>" required>
                                                        <?php echo form_error('observacion', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-3 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span class="fa fa-save"></span> Guardar</button>
                                    <button class="btn btn-danger ml-3" onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/proveedores'">
                                        <i class="fa fa-remove"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
