<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- jsPDF y Autotable para las datatable -->
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.umd.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.plugin.autotable.js"></script>
    <!-- script para obtener el logo -->
    <script>
    var logoDataURL = '<?php echo site_url("dataTablePDF/ImageController/getimagedataurl"); ?>';
    </script>
    <script src="<?php echo base_url(); ?>/assets/js/obtener_logo.js"></script>

    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- Estilos de DataTable button -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/Buttons/css/buttons.bootstrap5.min.css">
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Balance General</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="mt-4">
                        <h1>Balance General</h1>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_balance_general">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-body mt-4">
                                            <table class="table table-hover table-sm align-middle mt-4"
                                                id="TablaBalanceGeneral">
                                                <thead>
                                                    <tr>
                                                        <th>Número de Cuenta</th>
                                                        <th>Descripción de la Cuenta</th>
                                                        <th>Total Debe</th>
                                                        <th>Total Haber</th>
                                                        <th>Total Deudor</th>
                                                        <th>Total Acreedor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cuentas as $cuenta) : ?>
                                                    <tr>
                                                        <td><?= $cuenta->Codigo_CC ?></td>
                                                        <td><?= $cuenta->Descripcion_CC ?></td>
                                                        <td><?= isset($cuenta->TotalDebe) ? number_format($cuenta->TotalDebe, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuenta->TotalHaber) ? number_format($cuenta->TotalHaber, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuenta->TotalDeudor) ? number_format($cuenta->TotalDeudor, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuenta->TotalAcreedor) ? number_format($cuenta->TotalAcreedor, 0, ',', '.') : 0 ?>
                                                        </td>
                                                    </tr>
                                                    <?php if (isset($cuenta->cuentasHijas)) : ?>
                                                    <?php foreach ($cuenta->cuentasHijas as $cuentaHija) : ?>
                                                    <tr>
                                                        <td><?= $cuentaHija->Codigo_CC ?></td>
                                                        <td><?= $cuentaHija->Descripcion_CC ?></td>
                                                        <td><?= isset($cuentaHija->TotalDebe) ? number_format($cuentaHija->TotalDebe, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuentaHija->TotalHaber) ? number_format($cuentaHija->TotalHaber, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuentaHija->TotalDeudor) ? number_format($cuentaHija->TotalDeudor, 0, ',', '.') : 0 ?>
                                                        </td>
                                                        <td><?= isset($cuentaHija->TotalAcreedor) ? number_format($cuentaHija->TotalAcreedor, 0, ',', '.') : 0 ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Script para las tabla de balance general -->
        <script>
        $(document).ready(function() {
            var table1 = $('#TablaBalanceGeneral').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"t>>' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'Todo']
                ],
                buttons: [{
                        extend: 'pageLength',
                        className: 'btn bg-primary border border-0',
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
                        text: '<i class="bi bi-filetype-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        action: function(e, dt, node, config) {
                            generarPDF();
                        }
                    },
                ],
                searching: true,
                info: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                },
            });
        });
        </script>

        <!-- Script del pdf -->
        <script>
        async function generarPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            try {
                const logoDataURL = await getImageDataURL(); //Funcion para obtener la imagen
                doc.addImage(logoDataURL, 'PNG', 30, 14, 25,
                    0); // Orden de coordenadas: izquierda, arriba, ancho, altura

                // Varaibles para poder sacar la fecha
                var fechaActual = new Date();
                var dd = fechaActual.getDate();
                var mm = fechaActual.getMonth() + 1;
                var yyyy = fechaActual.getFullYear();

                // Validación para los 2 dígitos en la fecha
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                // Concatenamos la fecha para el nombre del archivo
                var nombreArchivo = 'Balance_General_' + dd + '-' + mm + '-' + yyyy + '.pdf';

                // Acá agregamos la fecha en la esquina superior derecha del documento
                doc.setFontSize(9);
                doc.setTextColor(0, 0, 0); // Color del texto (negro)
                doc.text('Fecha: ' + dd + '/' + mm + '/' + yyyy, doc.internal.pageSize.width - 15, 19, null, null,
                    'right');
                doc.text('Hora: ' + fechaActual.toLocaleTimeString(), doc.internal.pageSize.width - 15, 24, null,
                    null, 'right');

                //Titulo
                doc.setFont("helvetica", "bold"); //Fuente
                doc.setFontSize(15); //Tamaño
                var text = 'Universidad Nacional del Este';
                //Calculo para colocar el texto en el medio 
                var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal
                    .scaleFactor;
                var marginLeft = (doc.internal.pageSize.width - textWidth) / 2;
                doc.text(text, marginLeft, 20);

                //Datos de la Universidad
                doc.setFont("helvetica", "normal");
                doc.setFontSize(10);
                var lines = [
                    'Campus Km 8 Acaray',
                    'Calle Universidad Nacional del Este y Rca. del Paraguay',
                    'Barrio San Juan Ciudad del Este Alto Parana'
                ];

                // Cordenadas de los textos junto con los calculos
                var startY = 25; //Donde empieza
                var lineHeight = 5; //Espacio entre lineas
                lines.forEach(function(line) {
                    var textWidth = doc.getStringUnitWidth(line) * doc.internal.getFontSize() / doc.internal
                        .scaleFactor;
                    var marginLeft = (doc.internal.pageSize.width - textWidth) / 2;

                    doc.text(line, marginLeft, startY);
                    startY += lineHeight;
                });

                var tableData = [];
                <?php foreach ($cuentas as $cuenta) : ?>
                tableData.push(['<?= $cuenta->Codigo_CC ?>', '<?= $cuenta->Descripcion_CC ?>',
                    '<?= isset($cuenta->TotalDebe) ? number_format($cuenta->TotalDebe, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuenta->TotalHaber) ? number_format($cuenta->TotalHaber, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuenta->TotalDeudor) ? number_format($cuenta->TotalDeudor, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuenta->TotalAcreedor) ? number_format($cuenta->TotalAcreedor, 0, ',', '.') : 0 ?>'
                ]);
                <?php if (isset($cuenta->cuentasHijas)) : ?>
                <?php foreach ($cuenta->cuentasHijas as $cuentaHija) : ?>
                tableData.push(['<?= $cuentaHija->Codigo_CC ?>', '<?= $cuentaHija->Descripcion_CC ?>',
                    '<?= isset($cuentaHija->TotalDebe) ? number_format($cuentaHija->TotalDebe, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuentaHija->TotalHaber) ? number_format($cuentaHija->TotalHaber, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuentaHija->TotalDeudor) ? number_format($cuentaHija->TotalDeudor, 0, ',', '.') : 0 ?>',
                    '<?= isset($cuentaHija->TotalAcreedor) ? number_format($cuentaHija->TotalAcreedor, 0, ',', '.') : 0 ?>'
                ]);
                <?php endforeach; ?>
                <?php endif; ?>
                <?php endforeach; ?>

                /* Acá comienza la configuracion de la tabla */
                var headerStyles = {
                    fillColor: '#020971',
                    textColor: '#ffffff', // Color del texto del encabezado 
                    fontStyle: 'bold' // negrita
                };
                doc.autoTable({
                    head: [
                        ['Número de Cuenta', 'Descripción de la Cuenta', 'Total Debe', 'Total Haber',
                            'Total Deudor', 'Total Acreedor'
                        ]
                    ],
                    body: tableData,
                    startY: 40, //donde comienza la tabla
                    headStyles: headerStyles // Estilos del header
                });

                // se guarda el archivo segun el nombre deseado del documento
                doc.save(nombreArchivo);
            } catch (error) {
                console.error('Error al cargar la imagen:', error);
            }
        }
        </script>
        <!-- Script de DataTable de jquery -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
        <!-- Script de DataTable button -->
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.bootstrap5.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/Buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/DataTables/jszip/dist/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    </main>
</body>

</html>