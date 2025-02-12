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
    <!-- Contenedor de los componentes -->
    <div class="container-fluid bg-white border rounded-3">
      <!-- Encabezado -->
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 mt-4">
            <h1>Listado de Comprobante de Gastos</h1>
          </div>
          <div class="col-md-6 mt-4 ">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary"
                onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/add'">
                <i class="bi bi-plus"> Agregar Comprobante</i>
              </button>
            </div>
          </div>
        </div>
        <!-- Fin del Encabezado -->
        <hr> <!-- barra separadora -->

        <!-- Campos de Filtro -->
        <form action="<?php echo base_url('patrimonio/comprobante_gasto/filtrar'); ?>" method="post"
          class="form-inline mb-2">
          <div class="container-fluid">
            <div class="d-flex flex-row align-items-start">
              <!-- Icono de filtro -->
              <div class="me-2">
                <i class="bi bi-filter" style="font-size: 1.5rem;"></i>
              </div>

              <!-- Acá comienza los selects -->
              <div class="d-flex flex-row flex-grow-1 gap-3">
                <!-- Select de Actividad -->
                <div class="flex-grow-1">
                  <select class="form-select" id="actividad" name="actividad">
                    <option selected disabled>Actividad</option>
                    <!-- Primera opción como nombre del campo -->
                    <?php foreach ($unidad as $uni): ?>
                      <option value="<?php echo $uni->id_unidad; ?>">
                        <?php echo $uni->unidad; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Select de Periodo -->
                <div class="flex-grow-1">
                  <select class="form-select" id="periodo" name="periodo">
                    <option selected disabled>Periodo</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                  </select>
                </div>

                <!-- Select del Mes -->
                <div class="flex-grow-1">
                  <select class="form-select" id="mes" name="mes">
                    <option selected disabled>Mes</option>
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

                <!-- Campo de búsqueda por Número de Comprobante -->
                <div class="flex-grow-1">
                  <input type="text" class="form-control" id="id_pedido" name="id_pedido"
                    placeholder="Número de Comprobante">
                </div>
              </div>

              <!-- Botones -->
              <div class="d-flex flex-row gap-2 ms-3">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </div>
          </div>
        </form>

        <!-- Tabla -->
        <section class="seccion_tabla">
          <div class="container-fluid">
            <div class="row">
              <div class="container-fluid mt-2">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <div class="card border">
                      <div class="card-body mt-4">


                        <div class="table-responsive mt-4">
                          <table id="TablaComprobanteGasto" class="table table-hover table-sm rounded-3">
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
                                  <button type="button" class="btn btn-primary btn-view-comprobante btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalComprobantes"
                                    value="<?php echo $comp->IDComprobanteGasto; ?>">
                                    <span class="fa fa-search"></span>
                                  </button>
                                  <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
                                    onclick="window.location.href='<?php echo base_url() ?>Pdf_orden/generarPDF_orden/<?php echo $comp->id_pedido; ?>'">
                                    <i class="fas fa-file-pdf"></i> Orden de Servicio
                                  </button>
                                  <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
                                    onclick="window.location.href='<?php echo base_url() ?>Pdf_nota/generarPDF_nota/<?php echo $comp->id_pedido; ?>'">
                                    <i class="fas fa-file-pdf"></i> Nota de Recepción
                                  </button>
                                  <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
                                    onclick="window.location.href='<?php echo base_url() ?>Pdf_ped/generarPDF_ped/<?php echo $comp->id_pedido; ?>'">
                                    <i class="fas fa-file-pdf"></i> Pedido de Material
                                  </button>
                                  <button class="btn btn-warning btn-sm"
                                    onclick="window.location.href='<?php echo base_url() ?>patrimonio/comprobante_gasto/edit/<?php echo $comp->IDComprobanteGasto; ?>'">
                                    <i class="bi bi-pencil-fill"></i>
                                  </button>
                                  <button class="btn btn-danger btn-remove btn-sm"
                                    onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/delete/<?php echo $comp->IDComprobanteGasto; ?>'">
                                    <i class="bi bi-trash"></i>
                                  </button>
                                                                      <!-- Botón de karen -->

                                  <button type="button" class="btn btn-primary btn-view-comprobante btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalComprobantes"
                                    value="<?php echo $comp->IDComprobanteGasto; ?>">
                                    <span class="fa fa-search"></span>
                                  </button>

                                  <button class="btn btn-warning btn-sm btn-pdf"
                                    data-idpedido="<?php echo $comp->id_pedido; ?>">
                                    <i class="bi bi-filetype-pdf"></i>
                                  </button>

                                  <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                    <!-- Botón para PDF de Pedido con el ícono de Font Awesome -->
                                    <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
                                      onclick="window.location.href='<?php echo base_url() ?>Pdf_ped/generarPDF_ped/<?php echo $comp->id_pedido; ?>'">
                                      <i class="fas fa-file-pdf"></i> Pedido
                                    </button>
                                  </div>
                                  <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                    <!-- Botón para PDF de Pedido con el ícono de Font Awesome -->
                                    <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
                                      onclick="window.location.href='<?php echo base_url() ?>Pdf_nota/generarPDF_nota/<?php echo $comp->id_pedido; ?>'">
                                      <i class="fas fa-file-pdf"></i> Nota
                                    </button>
                                  </div>

                                  <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                    <!-- Botón para PDF de Orden con el ícono de Font Awesome -->
                                    <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm"
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
                                </tr>
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
          extend: 'pdf',
          text: '<i class="bi bi-filetype-pdf"></i> PDF', // Icono de pdf tambien
          className: 'btn btn-danger',
        }
        ],
        searching: false,
        info: true,
        language: {
          url: 'http://localhost/practica/assets/json/es-ES.json',
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

  <!-- Script de DataTable de jquery -->
  <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>