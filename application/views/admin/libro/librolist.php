<!-- librolist.php en application/views/admin/libro/ -->
<head>
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
</head>
<main id="main" class="main">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
            <li class="breadcrumb-item">Movimientos</li>
            <li class="breadcrumb-item">Libro Mayor</li>
        </ol>
    </nav>
    <!-- Content Wrapper.  Contains page content -->
    <div class="container-fluid bg-white border rounded-3">
        <div class="pagetitle">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <div class="col-md-6 mt-4">
                    <h1>Libro Mayor</h1>
                </div>
            </div>
        </div><!-- End Page Title -->
        <hr> <!-- barra separadora -->
        <div class="container-fluid">
            <!-- Campos principales -->
            <div class="seccion_tabla">
                <div class="container-fluid mt-2">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card border">
                                <div class="card-body">
                                    <form class="row g-3 mb-4 mt-2"
                                        action="<?php echo base_url();?>mantenimiento/LibroMayor/mostrarLibroMayor" method="post">
                                        <table class="table table-hover table-bordered table-sm rounded-3 mt-4"
                                                    id="miTabla">

                                                    <thead class="align-middle">
                                                        <tr>
                                                            <th class="columna-ancha">Diario:</th>

                                                            <th class="columna-ancha">Prog</th>
                                                            <th class="columna-fuente">F.F.</th>
                                                            <th class="columna-origen">O.F.</th>
                                                            <th class="columna-ctncontable">Cuenta Contable</th>
                                                            <th class="columna-ancha">Generar Mayor</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="align-items-center">
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <select class="form-control border-0 bg-transparent" id="id_form" name="id_form" required>
                                                                        <option value="1">Obligación</option>
                                                                        <option value="2">Pago</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent "
                                                                        id="id_pro" name="id_pro">
                                                                        <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro; ?>">
                                                                            <?php echo $prog->codigo . ' - ' . $prog->nombre ; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_ff" name="id_ff" required>
                                                                        <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                        <option value="<?php echo $ff->id_ff; ?>">
                                                                            <?php echo $ff->codigo . ' - ' . $ff->nombre ; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm ">
                                                                    <select class="form-control border-0 bg-transparent"
                                                                        id="id_of" name="id_of" required>
                                                                        <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                        <option value="<?php echo $of->id_of; ?>">
                                                                            <?php echo $of->codigo . ' - ' . $of->nombre ; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <input type="hidden" class="form-control"
                                                                        id="idcuentacontable" name="idcuentacontable">
                                                                    <input style="width: 40%; font-size: small;"
                                                                        type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="codigo_cc" name="codigo_cc" required>
                                                                    <input style="font-size: small;" type="text"
                                                                        class="form-control border-0 bg-transparent"
                                                                        id="descripcion_cc" name="descripcion_cc">
                                                                    <button type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCuentasCont1"
                                                                        class="btn btn-sm btn-outline-primary"
                                                                        id="openModalBtn_3">
                                                                        <i class="bi bi-search"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            <div class="col-md-3 ">
                                                                <button type="submit" class="btn btn-primary">Aceptar</button>
                                                            </div>
                                                            </td>

                                      
                                    </form>

                                    <!-- Tabla de Resultados -->
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>N° Asiento</th>
                                                    <th>N° OP</th>
                                                    <th>Comprobante</th>
                                                    <th>Descripción del gasto</th>
                                                    <th>Debe</th>
                                                    <th>Haber</th>
                                                    <th>Saldo</th>
                                                    <th>Cuenta Contable</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($entradas)): ?>
                                                <?php foreach ($entradas as $entrada): ?>
                                                <tr>
                                                    <td><?php echo $entrada['FechaEmision']; ?></td>
                                                    <td><?php echo $entrada['numero']; ?></td>
                                                    <td><?php echo $entrada['Num_Asi_IDNum_Asi']; ?></td>
                                                    <td><?php echo $entrada['comprobante']; ?></td>
                                                    <td><?php echo $entrada['Descripcion']; ?></td>
                                                    <td><?php echo $entrada['Debe']; ?></td>
                                                    <td><?php echo $entrada['Haber']; ?></td>
                                                    <td><?php // Calcular y mostrar el saldo ?></td>
                                                    <td><?php echo $entrada['Codigo_CC']; ?> -
                                                        <?php echo $entrada['Descripcion_CC']; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No se encontraron registros.
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabla -->
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Modal con Bootstrap Cuentas Contables numero 1-->
      <div class="modal fade mi-modal" id="modalCuentasCont1" tabindex="-1" aria-labelledby="ModalCuentasContables"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered cuentas-contables">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-sm" id="TablaCuentaCont1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código de Cuenta</th>
                                    <th>Descripción de Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cuentacontable as $dato): ?>
                                <tr class="list-item"
                                    onclick="selectCC(<?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')"
                                    data-bs-dismiss="modal">
                                    <td>
                                        <?= $dato->IDCuentaContable ?>
                                    </td>
                                    <td>
                                        <?= $dato->Codigo_CC ?>
                                    </td>
                                    <td>
                                        <?= $dato->Descripcion_CC ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                <script>
        function selectCC(IDCuentaContable, Codigo_CC, Descripcion_CC) {
            // Actualizar los campos de texto en la vista principal con los valores seleccionados
            document.getElementById('idcuentacontable').value = IDCuentaContable;
            document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
            document.getElementById('descripcion_cc').value =
                Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

            }

            $(document).ready(function () {
            // Agregar un controlador de eventos de clic al botón
            $('#openModalBtn_3').on('click', function (event) {
                // Detener la propagación del evento
                event.stopPropagation();
                event.preventDefault();
                // Tu lógica para abrir el modal aquí si es necesario
            });
        }); 
        </script>
        <script>
            $(document).ready(function () {
                var table1 = $('#TablaCuentaCont1').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });

                var table2 = $('#TablaCuentaCont2').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });
            });
        </script>
</main>
