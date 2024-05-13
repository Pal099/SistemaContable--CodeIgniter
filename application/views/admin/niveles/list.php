<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
</head>
<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item active">Niveles</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Listado de Niveles</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary"
                                onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/niveles/add'">
                                <i class="bi bi-plus-circle"></i> Agregar Nivel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <section class="seccion_tabla">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <div class="table-responsive">
                                                <table id="TablaNiveles" class="table table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Nombre del Nivel</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($niveles)):?>
                                                        <?php foreach($niveles as $nivel):?>
                                                        <tr>
                                                            <td><?php echo $nivel->id_nivel;?></td>
                                                            <td><?php echo $nivel->nombre_nivel;?></td>
                                                            <td>
                                                                <a href="<?php echo base_url();?>mantenimiento/niveles/edit/<?php echo $nivel->id_nivel;?>" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span> Editar</a>
                                                                <a href="<?php echo base_url();?>mantenimiento/niveles/delete/<?php echo $nivel->id_nivel;?>" class="btn btn-danger btn-sm"><span class="fa fa-remove"></span> Eliminar</a>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                        <?php endif;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <!-- Script de la tabla de niveles -->
    <script>
    $(document).ready(function() {
        var table1 = $('#TablaNiveles').DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"t>>' +
                '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10', '25', '50', 'Mostrar Todo']
            ],
            buttons: [{
                    extend: 'pageLength',
                    className: 'btn bg-primary border border-0'
                },
                {
                    extend: 'copy',
                    className: 'btn bg-primary border border-0',
                    text: '<i class="bi bi-copy"></i> Copiar',
                },
                {
                    extend: 'print',
                    className: 'btn bg-primary border border-0',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                },
                {
                    extend: 'excel',
                    text: '<i class="bi bi-file-excel"></i> Excel',
                    className: 'btn btn-success',
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-filetype-pdf"></i> PDF',
                    className: 'btn btn-danger',
                }
            ],
            searching: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
        });
    });
    </script>
    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>
</html>
