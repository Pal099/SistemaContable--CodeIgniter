<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Niveles
                <small>Nuevo</small>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/niveles">Niveles</a></li>
                    <li class="breadcrumb-item active">Nuevo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if($this->session->flashdata("error")):?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                    </div>
                                <?php endif;?>
                                <form action="<?php echo base_url();?>mantenimiento/niveles/store" method="POST">
                                    <div class="form-group <?php echo form_error('nombre_nivel') == true ? 'has-error':''?>">
                                        <label for="nombre_nivel">Nombre del nivel:</label>
                                        <input type="text" class="form-control" id="nombre_nivel" name="nombre_nivel">
                                        <?php echo form_error("nombre_nivel","<span class='help-block'>","</span>");?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                                        <a href="<?php echo base_url(); ?>mantenimiento/niveles" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Script para mostrar SweetAlert2 -->
    <script>
        // Check if there is a success message in the URL and show the SweetAlert
        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Nivel guardado con éxito',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url(); ?>mantenimiento/niveles";
                }
            });
        <?php endif; ?>
    </script>
</body>

</html>
