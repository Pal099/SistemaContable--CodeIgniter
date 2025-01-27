<!DOCTYPE html>
<html lang="es">

<!-- list_eje.php en application/views/admin/ejecucion/ -->

<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link href="<?php echo base_url(); ?>assets/css/style_mayor.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
    <!-- Incluir scripts necesarios si se usan -->
</head>

<main id="main" class="main">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
            <li class="breadcrumb-item">Movimientos</li>
            <li class="breadcrumb-item">Libro Mayor</li>
        </ol>
    </nav>
    <div class="container-fluid bg-white border rounded-3">
        <div class="pagetitle">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <div class="col-md-6 mt-4">
                    <h1>Ejecución Presupuestaria</h1>
                </div>
            </div>
        </div>
        <hr>

        <div class="container-fluid">
            <div class="seccion_tabla">
                <div class="container-fluid mt-2">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card border">
                                <div class="card-body">
                                    <form method="GET" action="<?php echo base_url('mantenimiento/ejecucionp'); ?>"
                                        class="form-horizontal">
                                        <h4 class="mt-4">Filtros de Búsqueda</h4>
                                        <hr>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm rounded-3 mt-1" id="miTabla">
                                                <thead class="align-middle">
                                                    <tr>
                                                        <th class="columna-ancha">Desde Fecha</th>
                                                        <th class="columna-ancha">Hasta Fecha</th>
                                                        <th class="columna-origen">O.F.</th>
                                                        <th class="columna-fuente">F.F.</th>
                                                        <th class="columna-ancha">Prog</th>
                                                        <th class="columna-ctncontable">Cuenta Contable</th>
                                                        <th class="columna-ancha">Aplicar Filtros</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="align-items-center">
                                                        <!-- Fechas -->
                                                        <td>
                                                            <input type="date" class="form-control" name="fecha_inicio"
                                                                value="<?= $filtros_actuales['fecha_inicio'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control" name="fecha_fin"
                                                                value="<?= $filtros_actuales['fecha_fin'] ?>">
                                                        </td>

                                                        <!-- Origen -->
                                                        <td>
                                                            <select class="form-control border-0 bg-transparent"
                                                                name="origen">
                                                                <option value="">Sin Filtro</option>
                                                                <?php foreach ($origen as $o): ?>
                                                                    <option value="<?= $o->id_of ?>"
                                                                        <?= ($filtros_actuales['origen'] == $o->id_of) ? 'selected' : '' ?>>
                                                                        <?= $o->codigo . ' - ' . $o->nombre ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>

                                                        <!-- Fuente -->
                                                        <td>
                                                            <select class="form-control border-0 bg-transparent"
                                                                name="fuente">
                                                                <option value="">Sin Filtro</option>
                                                                <?php foreach ($fuente as $f): ?>
                                                                    <option value="<?= $f->id_ff ?>"
                                                                        <?= ($filtros_actuales['fuente'] == $f->id_ff) ? 'selected' : '' ?>>
                                                                        <?= $f->codigo . ' - ' . $f->nombre ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>

                                                        <!-- Programa -->
                                                        <td>
                                                            <select class="form-control border-0 bg-transparent"
                                                                name="programa">
                                                                <option value="">Sin Filtro</option>
                                                                <?php foreach ($programa as $p): ?>
                                                                    <option value="<?= $p->id_pro ?>"
                                                                        <?= ($filtros_actuales['programa'] == $p->id_pro) ? 'selected' : '' ?>>
                                                                        <?= $p->codigo . ' - ' . $p->nombre ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>

                                                        <!-- Cuenta Contable -->
                                                        <td>
                                                            <div class="d-grid gap-1 d-md-flex justify-content">
                                                                <input type="hidden" class="form-control"
                                                                    id="idcuentacontable" name="cuenta">
                                                                <input style="width: 90%; font-size: small;" type="text"
                                                                    class="form-control border-0 bg-transparent"
                                                                    id="codigo_cc" name="codigo_cc"
                                                                    value="<?= $filtros_actuales['cuenta'] ?>" readonly>
                                                                <button type="button" data-bs-toggle="modal"
                                                                    data-bs-target="#modalCuentasCont1"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        <!-- Botón -->
                                                        <td>
                                                            <div class="d-grid gap-2">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="bi bi-funnel"></i> Filtrar
                                                                </button>
                                                                <a href="<?= base_url('mantenimiento/EjecucionP') ?>"
                                                                    class="btn btn-secondary">
                                                                    Limpiar
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>

                                    <!-- Modal Cuentas Contables (similar al ejemplo) -->
                                    <div class="modal fade" id="modalCuentasCont1" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Seleccionar Cuenta</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-hover table-sm" id="TablaCuentaCont1">
                                                        <thead>
                                                            <tr>
                                                                <th>Código</th>
                                                                <th>Descripción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($cuentacontable as $c): ?>
                                                                <tr onclick="selectCC('<?= $c->IDCuentaContable ?>','<?= $c->Codigo_CC ?>','<?= $c->Descripcion_CC ?>')"
                                                                    data-bs-dismiss="modal">

                                                                    <td><?= $c->Codigo_CC ?></td>
                                                                    <td><?= $c->Descripcion_CC ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <section class="seccion_tabla">
                                        <div class="table-responsive">
                                            <table id="tablaEjecucion"
                                                class="table table-hover table-bordered table-sm rounded-3 mt-4">
                                                <!-- Dentro de la tabla de resultados -->
                                                <thead>
                                                    <tr>
                                                        <th>Cuenta Contable</th>
                                                        <th>Origen</th>
                                                        <th>Fuente</th>
                                                        <th>Programa</th>
                                                        <th>Presup. Inicial</th>
                                                        <th>Modificaciones</th>
                                                        <th>Vigente</th>
                                                        <th>Obligado</th>
                                                        <th>Pagado</th>
                                                        <th>Saldo Presup.</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($ejecucionpresupuestaria)): ?>
                                                        <?php foreach ($ejecucionpresupuestaria as $item): ?>
                                                            <tr>
                                                                <td><?= $item->codigo_cuenta . ' - ' . $item->nombre_cuenta ?>
                                                                </td>
                                                                <td><?= $item->codigo_origen . ' - ' . $item->nombre_of ?></td>
                                                                <td><?= $item->codigo_fuente . ' - ' . $item->nombre_ff ?></td>
                                                                <td><?= $item->codigo_programa . ' - ' . $item->nombre_pro ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->TotalPresupuestado, 0, ',', '.') ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->TotalModificado, 0, ',', '.') ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->Vigente, 0, ',', '.') ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->Obligado, 0, ',', '.') ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->Pagado, 0, ',', '.') ?>
                                                                </td>
                                                                <td class="text-end">
                                                                    <?= number_format($item->SaldoPresupuestario, 0, ',', '.') ?>
                                                                </td>
                                                                <td><?= $item->fecha ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function selectCC(id, codigo, nombre) {
        document.getElementById('idcuentacontable').value = id;
        document.getElementById('codigo_cc').value = codigo + ' - ' + nombre;
    }

    $(document).ready(function () {
        $('#TablaCuentaCont1').DataTable({
            paging: true,
            pageLength: 10,

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    });
</script>


<!-- Script de Configuración de DataTable -->
<script>
    $(document).ready(function () {
        var table = $('#tablaEjecucion').DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 Filas', '25 Filas', '50 Filas', 'Mostrar Todo']
            ],
            buttons: [{
                extend: 'pageLength',
                className: 'btn bg-primary border border-0'
            },
            {
                extend: 'copy',
                className: 'btn bg-primary border border-0',
                text: '<i class="bi bi-files"></i> Copiar',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-success',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-filetype-pdf"></i> PDF', // Icono de pdf tambien
                className: 'btn btn-danger',
            }],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                emptyTable: "No se encontraron registros con los filtros aplicados",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                search: "Buscar:"
            },
            columnDefs: [
                { targets: [4, 5, 6, 7, 8, 9], className: 'dt-body-right' },
                { targets: '_all', className: 'dt-head-center' }
            ],
            order: [[0, 'asc']],
            responsive: true,
            autoWidth: false
        });
    });

    // Función para generar PDF
    async function generarPDFEjecucion() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        try {
            // Configuración del encabezado
            const logoDataURL = await getImageDataURL();
            doc.addImage(logoDataURL, 'PNG', 10, 5, 25, 10);

            // Títulos y fecha
            doc.setFontSize(12);
            doc.setFont("helvetica", "bold");
            doc.text('Reporte de Ejecución Presupuestaria', 105, 15, { align: 'center' });

            doc.setFontSize(10);
            doc.setFont("helvetica", "normal");
            doc.text(`Fecha del Reporte: ${new Date().toLocaleDateString()}`, 10, 30);

            // Obtener datos de la tabla
            var data = [];
            <?php foreach ($ejecucionpresupuestaria as $item): ?>
                data.push({
                    cuenta: '<?= $item->Idcuentacontable ?>',
                    origen: '<?= $item->nombre_of ?>',
                    fuente: '<?= $item->nombre_ff ?>',
                    programa: '<?= $item->nombre_pro ?>',
                    presup_inicial: <?= $item->TotalPresupuestado ?>,
                    modificaciones: <?= $item->TotalModificado ?>,
                    vigente: <?= $item->Vigente ?>,
                    obligado: <?= $item->Obligado ?>,
                    pagado: <?= $item->Pagado ?>,
                    saldo: <?= $item->SaldoPresupuestario ?>
                });
            <?php endforeach; ?>

            // Configurar columnas del PDF
            const columns = [
                { header: 'Cuenta', dataKey: 'cuenta' },
                { header: 'Origen', dataKey: 'origen' },
                { header: 'Fuente', dataKey: 'fuente' },
                { header: 'Programa', dataKey: 'programa' },
                { header: 'Presup. Inicial', dataKey: 'presup_inicial' },
                { header: 'Modificaciones', dataKey: 'modificaciones' },
                { header: 'Vigente', dataKey: 'vigente' },
                { header: 'Obligado', dataKey: 'obligado' },
                { header: 'Pagado', dataKey: 'pagado' },
                { header: 'Saldo', dataKey: 'saldo' }
            ];

            // Opciones de la tabla
            const options = {
                startY: 40,
                headStyles: {
                    fillColor: [2, 9, 113],
                    textColor: 255,
                    fontStyle: 'bold',
                    halign: 'center'
                },
                bodyStyles: { halign: 'center' },
                columnStyles: {
                    presup_inicial: { halign: 'right' },
                    modificaciones: { halign: 'right' },
                    vigente: { halign: 'right' },
                    obligado: { halign: 'right' },
                    pagado: { halign: 'right' },
                    saldo: { halign: 'right' }
                },
                didDrawPage: function (data) {
                    // Pie de página
                    doc.setFontSize(10);
                    doc.text(`Página ${data.pageNumber}`, 195, 207, { align: 'right' });
                }
            };

            // Generar tabla
            doc.autoTable(columns, data, options);
            doc.save('Reporte_Ejecucion_Presupuestaria.pdf');

        } catch (error) {
            console.error('Error al generar PDF:', error);
        }
    }
</script>

<!-- Script de DataTable de jquery -->
<script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>