<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Estilos de DataTable de jQuery -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
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
      <form action="<?php echo base_url('patrimonio/comprobante_gasto/filtrar'); ?>" method="post" class="form-inline">
        <div class="row g-3 align-items-center">
          <div class="col-md-3">
            <label for="actividad" class="form-label">Actividad:</label>
            <select class="form-select" id="actividad" name="actividad">
            <option value="">Ninguno</option>
              <?php foreach ($unidad as $uni) : ?>
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
              <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/add'">
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
                        <table id="TablaComprobanteGasto" class="table table-hover table-sm rounded-3">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Actividad</th>
                              <th>Fecha</th>
                              <th>Proveedor</th>
                              <th>concepto</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                            <?php foreach ($comprobantes as $comp) : ?>
                              <td><?php echo $comp->IDComprobanteGasto; ?></td>
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
                                  <button type="button" class="btn btn-primary btn-view-comprobante btn-sm" data-bs-toggle="modal" data-bs-target="#modalComprobantes" value="<?php echo $comp->IDComprobanteGasto; ?>">
                                    <span class="fa fa-search"></span>
                                  </button>
                                  <!-- <button class="btn btn-warning btn-sm" onclick="window.location.href='<?php echo base_url() ?>patrimonio/comprobante_gasto/edit/<?php echo $comp->IDComprobanteGasto;?>'">
                                    <i class="bi bi-pencil-fill"></i>
                                  </button> -->
                                  <button class="btn btn-danger btn-remove btn-sm" onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto/delete/<?php echo$comp->IDComprobanteGasto; ?>'">
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
  <div class="modal fade mi-modal" id="modalComprobantes" tabindex="-1" aria-labelledby="modalVerComprobante" aria-hidden="true">
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
    $(document).ready(function() {
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
    $('.btn-view-comprobante').on('click', function() {

      var comprobanteId = $(this).val();
      console.log("Comprobante ID:", comprobanteId);

      $.ajax({
        type: 'GET',
        url: 'comprobante_gasto/getComprobanteDetalle/' + comprobanteId,
        success: function(response) {
          // Se maneja las respuesta acá luego se llama a la funcion de mostrarDetalles si todo es correcto
          var comprobanteDetalle = JSON.parse(response);
          mostrarDetalles(comprobanteDetalle);
        },
        error: function(xhr, status, error) {
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