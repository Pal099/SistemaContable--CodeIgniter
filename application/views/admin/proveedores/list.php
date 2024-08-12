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
                <li class="breadcrumb-item active">Proveedor</li>
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
                                                <table id="TablaProveedores"
                                                    class="table table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Ruc</th>
                                                            <th>Razón Social</th>
                                                            <th>Dirección</th>
                                                            <th>Teléfono</th>
                                                            <th>Email</th>
                                                            <th>Observación</th>
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

    <!-- script para ver los presupuestos modal -->
    <div class="modal fade mi-modal" id="modalPresupuesto" tabindex="-1" aria-labelledby="ModalVerPresupuesto"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-extra-large">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Presupuesto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="TablaPresupuestoModal">
                            <tbody>
                                <tr>
                                    <th>Cuenta Contable</th>
                                    <td id="CuentaCont"></td>
                                </tr>
                                <tr>
                                    <th>Año</th>
                                    <td id="Año"></td>
                                </tr>
                                <tr>
                                    <th>Total P.</th>
                                    <td id="TotalP"></td>
                                </tr>
                                <tr>
                                    <th>Total M.</th>
                                    <td id="TotalM"></td>
                                </tr>
                                <tr>
                                    <th>Enero</th>
                                    <td id="Enero"></td>
                                </tr>
                                <tr>
                                    <th>Febrero</th>
                                    <td id="Febrero"></td>
                                </tr>
                                <tr>
                                    <th>Marzo</th>
                                    <td id="Marzo"></td>
                                </tr>
                                <tr>
                                    <th>Abril</th>
                                    <td id="Abril"></td>
                                </tr>
                                <tr>
                                    <th>Mayo</th>
                                    <td id="Mayo"></td>
                                </tr>
                                <tr>
                                    <th>Junio</th>
                                    <td id="Junio"></td>
                                </tr>
                                <tr>
                                    <th>Julio</th>
                                    <td id="Julio"></td>
                                </tr>
                                <tr>
                                    <th>Agosto</th>
                                    <td id="Agosto"></td>
                                </tr>
                                <tr>
                                    <th>Septiembre</th>
                                    <td id="Septiembre"></td>
                                </tr>
                                <tr>
                                    <th>Octubre</th>
                                    <td id="Octubre"></td>
                                </tr>
                                <tr>
                                    <th>Noviembre</th>
                                    <td id="Noviembre"></td>
                                </tr>
                                <tr>
                                    <th>Diciembre</th>
                                    <td id="Diciembre"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Script de la tabla de presupuesto -->
    <script>
    $(document).ready(function() {
        var table1 = $('#TablaProveedores').DataTable({
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
                    text: '<i class="bi bi-file-excel"></i> Excel', // Se agrega el icono
                    className: 'btn btn-success',
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-filetype-pdf"></i> PDF', // Icono de pdf tambien
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