<!-- librolist.php en application/views/admin/libro/ -->

<head>
    <link href="<?php echo base_url(); ?>assets/css/style_mayor.css" rel="stylesheet" type="text/css">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- jsPDF y Autotable para las datatable -->
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.umd.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.plugin.autotable.js"></script>
    <!-- script para obtener el logo -->
    <script>
    var logoDataURL = '<?php echo site_url("dataTablePDF/ImageController/getimagedataurl"); ?>';
    </script>
    <script src="<?php echo base_url(); ?>/assets/js/obtener_logo.js"></script>
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
                                    <form class="row g-3 mb-2 mt-2"
                                        action="<?php echo base_url();?>mantenimiento/LibroMayor/mostrarLibroMayor"
                                        method="post">
                                        <h4 class="mt-4">Filtros de búsqueda</h4>
                                        <hr><!-- Separador -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm rounded-3 mt-1" id="miTabla">
                                                <thead class="align-middle">
                                                    <tr>
                                                        <th class="columna-ancha">Desde Fecha:</th>
                                                        <th class="columna-ancha">Hasta Fecha:</th>
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
                                                            <div class="form-group">
                                                                <label for="fecha_inicio">Fecha:</label>
                                                                <input type="date" class="form-control"
                                                                    id="fecha_inicio" name="fecha_inicio">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="fecha_fin">Fecha:</label>
                                                                <input type="date" class="form-control" id="fecha_fin"
                                                                    name="fecha_fin">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <select class="form-control border-0 bg-transparent"
                                                                    id="id_form" name="id_form" required>
                                                                    <option value="-1">Sin Filtro</option>
                                                                    <option value="1">Obligación</option>
                                                                    <option value="2">Pago</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm ">
                                                                <select class="form-control border-0 bg-transparent "
                                                                    id="id_pro" name="id_pro">
                                                                    <option value="-1">Sin Filtro</option>
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
                                                                    <option value="-1">Sin Filtro</option>
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
                                                                    <option value="-1">Sin Filtro</option>
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
                                                                <input style="width: 40%; font-size: small;" type="text"
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
                                                                <button type="submit"
                                                                    class="btn btn-primary">Aceptar</button>
                                                            </div>
                                                        </td>
                                            </table>
                                        </div>
                                    </form>
                                    <!-- Tabla de Resultados -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="TablaPresupuesto">
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
                                                    <td><?php echo $entrada['Saldo']; ?></td>
                                                    <td>
                                                        <?php echo $entrada['Codigo_CC']; ?> -
                                                        <?php echo $entrada['Descripcion_CC']; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
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
    $(document).ready(function() {
        // Agregar un controlador de eventos de clic al botón
        $('#openModalBtn_3').on('click', function(event) {
            // Detener la propagación del evento
            event.stopPropagation();
            event.preventDefault();
            // Tu lógica para abrir el modal aquí si es necesario
        });
    });
    </script>
    <!-- Script de la tabla de presupuesto -->
    <script>
    $(document).ready(function() {
        var table1 = $('#TablaPresupuesto').DataTable({
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
                    action: function(e, dt, node, config) {
                        generarPDF();
                    }
                }
            ],
            searching: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                emptyTable: "No se encontraron registros.",
            },
            fnDrawCallback: function() {
                if ($('#TablaPresupuesto td').hasClass('dataTables_empty')) {
                    // Oculta los controles de paginación si la tabla está vacía
                    $('.dataTables_paginate').hide();
                    $('.dataTables_info').hide();
                    $('.dt-buttons').hide();
                    $('div.dataTables_filter').hide();
                } else {
                    // Muestra los controles de paginación si la tabla tiene datos
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                    $('.dt-buttons').show();
                    $('div.dataTables_filter').show();
                }
            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
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

            //Variable para la cantidad de paginas del footer
            var totalPagesExp = "{total_pages_count_string}";

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
            var nombreArchivo = 'Libro_Mayor_' + dd + '-' + mm + '-' + yyyy + '.pdf';

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

            // **--------Acá se procesa los datos de la tabla para poder agregar al documento--------**

            var entradas = <?php echo json_encode($entradas); ?>;
            // El array donde iran los datos
            var tableData = [];

            function agregarDatosMayor(entrada) {
                var row = [];
                row.push(entrada.FechaEmision);
                row.push(entrada.numero);
                row.push(entrada.Num_Asi_IDNum_Asi);
                var CuentaContable = entrada.Codigo_CC + "-" + entrada.Descripcion_CC;
                row.push(CuentaContable);
                row.push(entrada.Descripcion);
                row.push(entrada.comprobante);
                var debe = Number(entrada.Debe);
                var haber = Number(entrada.Haber);
                var saldo = entrada.Saldo;
                row.push(debe.toLocaleString('es-PY', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                row.push(haber.toLocaleString('es-PY', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                row.push(saldo.toLocaleString('es-PY', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                tableData.push(row);
            }

            entradas.forEach(agregarDatosMayor);

            // **--------Acá termina de procesar los datos--------**

            // Configuración de la tabla
            var headerStyles = {
                halign: 'center',
                fillColor: '#020971',
                textColor: '#ffffff',
                fontStyle: 'bold'
            };
            var bodyStyles = {
                cellPadding: 1,
                fontSize: 8, //tamaño de las letras de la tabla
            };

            var options = {
                head: [
                    ['Fecha', 'N° Asiento', 'N° OP', 'Cuenta Contable', 'Descripción', 'Comprobante',
                        'Debe', 'Haber', 'Saldo'
                    ]
                ],
                body: tableData,
                startY: 40,
                headStyles: headerStyles,
                bodyStyles: bodyStyles,
                columnStyles: {
                    0: {
                        halign: 'center'
                    }, //Fecha
                    1: {
                        halign: 'center'
                    }, //N° Asiento
                    2: {
                        halign: 'center'
                    }, //N° OP
                    6: {
                        halign: 'right'
                    }, // Columna "Debe"
                    7: {
                        halign: 'right'
                    }, // Columna "Haber"
                    8: {
                        halign: 'right'
                    } // Columna "Saldo"
                },
                //Este es el código del footer
                didDrawPage: function(data) {
                    // Número de página, centrado
                    var str = "Página " + doc.internal.getNumberOfPages()
                    // Total de páginas número plugin sólo en nuevas páginas
                    if (typeof doc.putTotalPages === 'function') {
                        str = str + " de " + totalPagesExp;
                    }
                    doc.setFontSize(10);
                    var pageSize = doc.internal.pageSize;
                    var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    doc.text(str, data.settings.margin.left, pageHeight - 10);
                },
                margin: {
                    top: 10
                }
            };

            // Crear la tabla
            doc.autoTable(options);

            // Total de páginas, este es el plugin para calcular la totalidad de paginas
            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }

            // Se guarda el archivo segun el nombre deseado del documento
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