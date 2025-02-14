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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/mantenimiento/proveedores">Proveedores</a></li>
            </ol>
        </nav>
        <!-- Contenedor de los componentes -->
        <div class="container-fluid bg-white border rounded-3">
            <!-- Encabezado -->
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Listado de Proveedores</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary"
                                onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/proveedores/add'">
                                <i class="bi bi-plus-circle"></i> Agregar Proveedor
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin del Encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_tabla">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <div class="table-responsive">
                                            <table id="TablaProveedores" class="table table-hover table-sm rounded-3">
                                                    <thead>
                                                        <tr>
                                                            <th>Ruc</th>
                                                            <th>Razón Social</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                            <th>Email</th>
                                                            <th>Observación</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(!empty($proveedores)):?>
                                                        <?php foreach($proveedores as $proveedor):?>
                                                        <tr>
                                                            <td><?php echo $proveedor->ruc;?></td>
                                                            <td><?php echo $proveedor->razon_social;?></td>
                                                            <td><?php echo $proveedor->direccion;?></td>
                                                            <td><?php echo $proveedor->telefono;?></td>
                                                            <td><?php echo $proveedor->email;?></td>
                                                            <td><?php echo $proveedor->observacion;?></td>
                                                            <td>
                                                            <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                <button class="btn btn-warning btn-sm"
                                                                onclick="window.location.href='<?php echo base_url() ?>mantenimiento/proveedores/edit/<?php echo $proveedor->id; ?>'">
                                                                <i class="bi bi-pencil-fill"></i>
                                                                </button>
                                                                <button class="btn btn-danger btn-remove btn-sm"
                                                                onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/proveedores/delete/<?php echo $proveedor->id; ?>'">
                                                                <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
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
    <script>
  
</body>

</html>