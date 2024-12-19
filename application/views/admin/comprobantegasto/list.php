<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Estilos de DataTable de jQuery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jsPDF y Autotable para las datatable -->
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.umd.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/jsPDF/jspdf.plugin.autotable.js"></script>
    <!-- script para obtener el logo -->
    <script>
        var logoDataURL = '<?php echo site_url("dataTablePDF/ImageController/getimagedataurl"); ?>';
    </script>
    <script src="<?php echo base_url(); ?>/assets/js/obtener_logo.js"></script>
</head>

<body>
    <main id="main" class="content">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item">Comprobante de Gastos</li>
                <li class="breadcrumb-item active">Listado de Comprobante de Gastos</li>
            </ol>
        </nav>
        <div class="container mt-4">
            <form action="<?php echo base_url('patrimonio/comprobante_gasto/filtrar'); ?>" method="post"
                class="form-inline">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label for="actividad" class="form-label">Actividad:</label>
                        <select class="form-select" id="actividad" name="actividad">
                            <option value="">Ninguno</option>
                            <?php foreach ($unidad as $uni): ?>
                                <option value="<?php echo $uni->id_unidad; ?>"><?php echo $uni->unidad; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="periodo" class="form-label">Periodo:</label>
                        <select class="form-select" id="periodo" name="periodo">
                            <option value="">Ninguno</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="mes" class="form-label">Mes:</label>
                        <select class="form-select" id="mes" name="mes">
                            <option value="">Ninguno</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>

                    <!-- Campo de búsqueda por número de pedido -->
                    <div class="col-md-3">
                        <label for="numero_pedido" class="form-label">Número de Pedido:</label>
                        <input type="text" class="form-control" id="id_pedido" name="id_pedido"
                            placeholder="Ingrese número de pedido">
                    </div>

                    <div class="col-md-12 text-md-end">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- Contenedor de los componentes -->
        <div class="container-fluid bg-white border rounded-3">
            <!-- Encabezado -->
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Listado de Comprobante de Gastos</h1>
                    </div>
                    <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary"
                                onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/add'">
                                <i class="bi bi-plus-circle"></i> Agregar Comprobante de Gastos
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
                                                <table id="TablaComprobanteGasto"
                                                    class="table table-hover table-sm rounded-3">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro de pedido</th>
                                                            <th>Actividad</th>
                                                            <th>Fecha</th>
                                                            <th>Proveedor</th>
                                                            <th>concepto</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <?php foreach ($comprobantes as $comp): ?>
                                                        <td><?php echo $comp->id_pedido; ?></td>
                                                        <td><?php echo $comp->id_unidad; ?></td>
                                                        <td><?php echo $comp->fecha; ?></td>
                                                        <td>
                                                            <?php
                                                            $proveedorEncontrado = array_filter($proveedores, function ($proveedor) use ($comp) {
                                                                return $proveedor->id == $comp->idproveedor;
                                                            });

                                                            if (!empty($proveedorEncontrado)) {
                                                                $primerProveedorEncontrado = reset($proveedorEncontrado);
                                                                echo $primerProveedorEncontrado->razon_social;
                                                            } else {
                                                                echo "Proveedor no encontrado";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $comp->concepto; ?></td>

                                                        <td>
                                                            <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                <button type="button"
                                                                    class="btn btn-primary btn-view-comprobante btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalComprobantes"
                                                                    value="<?php echo $comp->IDComprobanteGasto; ?>">
                                                                    <span class="fa fa-search"></span>
                                                                </button>

                                                                <button class="btn btn-warning btn-sm btn-pdf"
                                                                    data-idpedido="<?php echo $comp->id_pedido; ?>">
                                                                    <i class="bi bi-filetype-pdf"></i>
                                                                </button>

                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <!-- Botón para PDF de Pedido con el ícono de Font Awesome -->
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-view-presupuesto btn-sm"
                                                                        onclick="window.location.href='<?php echo base_url() ?>Pdf_ped/generarPDF_ped/<?php echo $comp->id_pedido; ?>'">
                                                                        <i class="fas fa-file-pdf"></i> Pedido
                                                                    </button>
                                                                </div>
                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <!-- Botón para PDF de Pedido con el ícono de Font Awesome -->
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-view-presupuesto btn-sm"
                                                                        onclick="window.location.href='<?php echo base_url() ?>Pdf_nota/generarPDF_nota/<?php echo $comp->id_pedido; ?>'">
                                                                        <i class="fas fa-file-pdf"></i> Nota
                                                                    </button>
                                                                </div>

                                                                <div
                                                                    class="d-grid gap-1 d-md-flex justify-content-md-center">
                                                                    <!-- Botón para PDF de Orden con el ícono de Font Awesome -->
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-view-presupuesto btn-sm"
                                                                        onclick="window.location.href='<?php echo base_url() ?>Pdf_orden/generarPDF_orden/<?php echo $comp->id_pedido; ?>'">
                                                                        <i class="fas fa-file-pdf"></i> Orden
                                                                    </button>
                                                                </div>

                                                                <button class="btn btn-warning btn-sm"
                                                                    onclick="window.location.href='<?php echo base_url() ?>patrimonio/comprobante_gasto/edit/<?php echo $comp->IDComprobanteGasto; ?>'">
                                                                    <i class="bi bi-pencil-fill"></i>
                                                                </button>

                                                                <button class="btn btn-danger btn-remove btn-sm"
                                                                    onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/delete/<?php echo $comp->IDComprobanteGasto; ?>'">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                        </tr>
                                                    <?php endforeach; ?>
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
    <div class="modal fade mi-modal" id="modalComprobantes" tabindex="-1" aria-labelledby="modalVerComprobante"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-extra-large">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Comprobante de Gastos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="TablaComprobanteGastoModal">
                            <tbody>
                                <th>ID</th>
                                <td id="id"></td>
                                </tr>
                                <tr>
                                    <th>Actividad</th>
                                    <td id="actividad"></td>
                                </tr>
                                <tr>
                                    <th>Fecha</th>
                                    <td id="fecha"></td>
                                </tr>
                                <tr>
                                    <th>Proveedor</th>
                                    <td id="proveedor"></td>
                                </tr>
                                <tr>
                                    <th>Monto</th>
                                    <td id="monto"></td>
                                </tr>
                                <tr>
                                    <th>Concepto</th>
                                    <td id="concepto"></td>
                                </tr>
                                <tr>
                                    <th>Aprobado</th>
                                    <td id="aprobado"></td>
                                </tr>
                                <tr>
                                    <th>F.F.</th>
                                    <td id="ff"></td>
                                </tr>
                                <tr>
                                    <th>OBL</th>
                                    <td id="obl"></td>
                                </tr>
                                <tr>
                                    <th>STR</th>
                                    <td id="str"></td>
                                </tr>
                                <tr>
                                    <th>O.P.</th>
                                    <td id="op"></td>
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
        $(document).ready(function () {
            var table1 = $('#TablaComprobanteGasto').DataTable({
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
                    text: '<i class="bi bi-filetype-pdf"></i> PDF',
                    className: 'btn btn-danger',
                    action: function (e, dt, node, config) {
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

    <!-- Script para ver los detalles del presupuesto -->
    <script>
        $('.btn-view-comprobante').on('click', function () {

            var comprobanteId = $(this).val();
            console.log("Comprobante ID:", comprobanteId);

            $.ajax({
                type: 'GET',
                url: 'comprobante_gasto/getComprobanteDetalle/' + comprobanteId,
                success: function (response) {
                    // Se maneja las respuesta acá luego se llama a la funcion de mostrarDetalles si todo es correcto
                    var comprobanteDetalle = JSON.parse(response);
                    mostrarDetalles(comprobanteDetalle);
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
        });

        // Función para mostrar los detalles del presupuesto
        function mostrarDetalles(comprobanteDetalle) {


            // Formato de numeros en guaranies
            var formatoGuaranies = new Intl.NumberFormat('es-PY', {
                style: 'currency',
                currency: 'PYG'
            });

            // Formato de la fila para la tabla
            $('#id').text(comprobanteDetalle.IDComprobanteGasto);
            $('#actividad').text(comprobanteDetalle.actividad);
            $('#fecha').text(comprobanteDetalle.fecha);
            $('#proveedor').text(comprobanteDetalle.idproveedor);
            $('#monto').text(formatoGuaranies.format(comprobanteDetalle.monto));
            $('#aprobado').text(comprobanteDetalle.aprobado);
            $('#concepto').text(comprobanteDetalle.concepto);
            $('#ff').text(comprobanteDetalle.id_ff);
            $('#obl').text(comprobanteDetalle.obl);
            $('#str').text(comprobanteDetalle.str);
            $('#op').text(comprobanteDetalle.op);
        }
    </script>

    <!-- Script del pdf de Comprobante de gasto -->
    <script>
        /* Script del botón que recupera el ID del comprobante de gasto */
        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".btn-pdf");
            buttons.forEach(button => {
                button.addEventListener("click", function () {
                    // Obtener el ID del pedido del atributo data-idpedido
                    var id_pedido = this.getAttribute('data-idpedido');
                    console.log("Id pedido: ", id_pedido);

                    // Hacer una llamada AJAX para obtener los datos desde el backend
                    fetch("<?= base_url('patrimonio/comprobante_gasto/generarReporteComprobante/') ?>" +
                        id_pedido)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta de la solicitud: ' +
                                    response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Visualizar los datos obtenidos
                            console.log("Datos obtenidos: ", data);
                            // Llamar a la función generarPDF si es necesario
                            generarPDF(data);
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });

        async function generarPDF(data) {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            try {
                // Obtener el logo
                const logoDataURL = await getImageDataURL(); // Asume que tienes una función para obtener la imagen
                doc.addImage(logoDataURL, 'PNG', 15, 15, 25, 0); // Posicionar el logo

                // Variable para la cantidad de paginas del footer
                var totalPagesExp = "{total_pages_count_string}";

                // Fecha de generación del documento
                const fechaActual = new Date();
                const dd = String(fechaActual.getDate()).padStart(2, '0');
                const mm = String(fechaActual.getMonth() + 1).padStart(2, '0');
                const yyyy = fechaActual.getFullYear();
                const fecha = `${dd}/${mm}/${yyyy}`;

                // Título
                doc.setFont("helvetica", "bold");
                doc.setFontSize(16);
                doc.text('28-02 UNIVERSIDAD NACIONAL DEL ESTE', 105, 20, null, null, 'center');

                doc.setFont("helvetica", "normal");
                doc.setFontSize(12);
                doc.text('GESTIÓN ADMINISTRATIVA - RECTORADO - UNE', 105, 28, null, null, 'center');

                doc.text('COMPROBANTES DE LA SOLICITUD', 105, 35, null, null, 'center');

                doc.setFontSize(10);
                // Crear el texto dinámico
                var text = `Solicitud N°: ${data[0].id_pedido}`;

                // Medir el ancho del texto
                var textWidth = doc.getTextWidth(text);
                var padding = 6; // Espacio alrededor del texto

                // Coordenadas para el cuadro (ajustar estas coordenadas para centrar mejor el cuadro)
                var xPos = doc.internal.pageSize.width - textWidth - padding * 3;
                var yPos = 47; // Mantener la coordenada Y fija o ajustarla si es necesario

                // Ajustar la posición del texto para que esté en el centro del cuadro
                var textXPos = xPos + padding; // Centrar horizontalmente con padding
                var textYPos = yPos; // Mantener la altura del texto

                // Grosor del borde del cuadro
                doc.setLineWidth(0.3); // Ajustar grosor de los bordes

                // Dibujar el cuadro sin relleno, con bordes más gruesos
                doc.setDrawColor(0); // Color del borde (negro)
                doc.rect(xPos - 8, yPos - 6, textWidth + padding * 2, 10); // Dibujar el cuadro

                // Dibujar el texto centrado dentro del cuadro
                doc.text(text, textXPos - 8, textYPos);

                // Detalles de proveedor y comprobante
                doc.setFontSize(9);

                // Dimensiones del cuadro
                var cuadroX = 14; // Coordenada X (margen izquierdo)
                var cuadroY = 53; // Coordenada Y (margen superior)
                var cuadroAncho = 182; // Ancho del cuadro
                var cuadroAlto = 12; // Alto del cuadro

                // Dibujo del cuadro alrededor de los textos
                doc.setLineWidth(0.3); // Grosor del borde del cuadro
                doc.setDrawColor(0); // Color del borde (negro)
                doc.rect(cuadroX, cuadroY, cuadroAncho, cuadroAlto); // Dibujar el cuadro

                // Escribir los textos dentro del cuadro
                doc.setFontSize(9);
                // Izquierda
                // Formateo de la fecha data[0].fecha tiene el formato 'YYYY-MM-DD'
                const fechaOriginal = data[0].fecha; // Ejemplo: '2024-09-26'

                // Dividir la fecha en componentes
                const [year, month, day] = fechaOriginal.split('-');

                // Formatear la fecha como 'DD/MM/YY'
                const fechaFormateada = `${day}/${month}/${year.slice(2)}`;

                // Insertar la fecha formateada en el PDF
                doc.text(`Fecha Comprobante: ${fechaFormateada}`, 15, 58);
                doc.text(`Nro. Comprobante: 001-001-0001275`, 15, 63);

                // Al lado de fecha de comprobante
                doc.text(`Proveedor: ${data[0].razon_social}`, 71, 58);
                doc.text('Obs.: 242 - Mantenimiento y Reparación de Edificio', 71, 63);

                // Al lado de proveedores
                doc.text(`RUC: ${data[0].ruc}`, 123, 58);
                doc.text(`Monto: 100.000.000`, 155, 63);

                // CC
                doc.text(`C.C: 80077381-0`, 155, 58);

                // Crear la tabla de items
                const tableColumn = [
                    ['Item', 'Tipo', 'Prog./Sub', 'Obj', 'FF', 'Org.', 'Dpto.', 'Bien/Servicio', 'Cantidad',
                        'Precio Unit.', 'Exentas', 'Gravadas', 'IVA'
                    ]
                ];

                //-------------Acá comienza los datos-------------
                const tableRows = [];

                // Rellenar las filas con los datos reales del backend
                data.forEach((item, index) => {
                    tableRows.push([
                        index + 1 + ')',
                        '1',
                        '1',
                        '1',
                        '1',
                        '1',
                        '1',
                        item.descripcion,
                        item.cantidad,
                        item.preciounit,
                        item.exenta,
                        item.gravada,
                        item.porcentaje_iva + '%',
                    ]);
                });

                // Configuración de la tabla
                doc.autoTable({
                    head: tableColumn,
                    body: tableRows,
                    startY: 67, //Posicion de donde inicia la tabla
                    theme: 'plain',
                    headStyles: {
                        fillColor: null,
                        textColor: '#000000',
                        fontStyle: 'normal',
                        fontSize: 9,
                    },
                    bodyStyles: {
                        cellPadding: 2,
                        fontSize: 9,
                    },
                    columnStyles: {
                        1: {
                            halign: 'center'
                        },
                        2: {
                            halign: 'center'
                        },
                        3: {
                            halign: 'center'
                        },
                        4: {
                            halign: 'center'
                        },
                        5: {
                            halign: 'center'
                        },
                        6: {
                            halign: 'center'
                        },
                        7: {
                            cellWidth: 38,
                        },
                        8: {
                            halign: 'center'
                        } //Bien-Servicio
                    },
                    didDrawPage: function (data) {
                        // Pie de página
                        var str = "Página " + doc.internal.getNumberOfPages();
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
                });

                // Totales
                let finalY = doc.previousAutoTable.finalY + 10;

                // Dibujar una línea divisoria del mismo ancho que la tabla
                const startX = 14; // Coordenada X del inicio de la tabla (ajústala si es diferente)
                const endX = 196; // Coordenada X del final de la tabla (ajústala si es diferente)
                doc.setLineWidth(0.3); // Grosor de la línea
                doc.line(startX, finalY - 3, endX, finalY - 3); // Dibuja la línea justo antes de los totales

                // Texto de totales
                doc.setFontSize(10);
                doc.text('Total Comprobante:', 105, finalY + 1, null, null, 'right');
                doc.text('100.000.000.000.000.000', 196, finalY + 1, {
                    align: 'right'
                });

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                // Guardar el PDF
                //doc.save('Comprobante_Solicitud.pdf');

                // Generar un Blob del documento PDF
                const pdfBlob = doc.output('blob');

                // Crear una URL para el Blob y abrirla en una nueva pestaña
                const blobUrl = URL.createObjectURL(pdfBlob);
                window.open(blobUrl);

            } catch (error) {
                console.error('Error al generar el PDF:', error);
            }
        }
    </script>

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>