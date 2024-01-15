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
        <li class="breadcrumb-item active">Listado Presupuesto</li>
      </ol>
    </nav>
    <!-- Contenedor de los componentes -->
    <div class="container-fluid bg-white border rounded-3">
      <!-- Encabezado -->
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 mt-4">
            <h1>Listado de Presupuesto</h1>
          </div>
          <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/presupuesto/add'">
                <i class="bi bi-plus-circle"></i> Agregar Presupuesto
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
                        <table id="TablaPresupuesto" class="table table-hover table-sm rounded-3">
                          <thead>
                            <tr>
                              <th>Año</th>
                              <th>Descripcion</th>
                              <th>Total presupuestado</th>
                              <th>Origen de financiamiento</th>
                              <th>Fuente de financiamiento</th>
                              <th>Programa</th>
                              <th>Total modificado</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <?php if (!empty($presupuestos) || !empty($cuentacontable) || !empty($programa) || !empty($registros_financieros) || !empty($origen)) : ?>
                            <?php foreach ($presupuestos as $presupuesto) : ?>
                              <td><?php echo $presupuesto->Año; ?></td>
                              <td><?php echo $presupuesto->Idcuentacontable; ?></td>
                              <td><?php echo number_format($presupuesto->TotalPresupuestado, 0, ',', '.'); ?></td>
                              <td><?php echo $presupuesto->origen_de_financiamiento; ?></td>
                              <td><?php echo $presupuesto->fuente_de_financiamiento; ?></td>
                              <td><?php echo $presupuesto->programa; ?></td>
                              <td><?php echo number_format($presupuesto->TotalModificado, 0, ',', '.'); ?></td>
                              <td>
                                <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                  <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm" data-bs-toggle="modal" data-bs-target="#modalPresupuesto" value="<?php echo $presupuesto->ID_Presupuesto; ?>">
                                    <span class="fa fa-search"></span>
                                  </button>
                                  <button class="btn btn-warning btn-sm" onclick="window.location.href='<?php echo base_url() ?>mantenimiento/presupuesto/edit/<?php echo $presupuesto->ID_Presupuesto; ?>'">
                                    <i class="bi bi-pencil-fill"></i>
                                  </button>
                                  <button class="btn btn-danger btn-remove btn-sm" onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/presupuesto/delete/<?php echo $presupuesto->ID_Presupuesto; ?>'">
                                    <i class="bi bi-trash"></i>
                                  </button>
                                </div>
                              </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php endif; ?>
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
  <div class="modal fade mi-modal" id="modalPresupuesto" tabindex="-1" aria-labelledby="ModalVerPresupuesto" aria-hidden="true">
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
    $('.btn-view-presupuesto').on('click', function() {
      // Obtiene el ID del presupuesto desde el valor del botón
      var presupuestoId = $(this).val();
      console.log("Presupuesto ID:", presupuestoId);

      // Se Realiza una solicitud AJAX para obtener los detalles del presupuesto
      $.ajax({
        type: 'GET',
        url: 'presupuesto/getPresupuestoDetalle/' + presupuestoId,
        success: function(response) {
          // Se maneja las respuesta acá luego se llama a la funcion de mostrarDetalles si todo es correcto
          var presupuestoDetalle = JSON.parse(response);
          mostrarDetalles(presupuestoDetalle);
        },
        error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
        }
      });
    });

    // Función para mostrar los detalles del presupuesto
    function mostrarDetalles(presupuestoDetalle) {


      // Formato de numeros en guaranies
      var formatoGuaranies = new Intl.NumberFormat('es-PY', {
        style: 'currency',
        currency: 'PYG'
      });

      // Formato de la fila para la tabla
      $('#Año').text(presupuestoDetalle.Año);
      $('#TotalP').text(formatoGuaranies.format(presupuestoDetalle.TotalPresupuestado));
      $('#TotalM').text(formatoGuaranies.format(presupuestoDetalle.TotalModificado));
      $('#Enero').text(formatoGuaranies.format(presupuestoDetalle.pre_ene)); 
      $('#Febrero').text(formatoGuaranies.format(presupuestoDetalle.pre_feb)); 
      $('#Marzo').text(formatoGuaranies.format(presupuestoDetalle.pre_mar)); 
      $('#Abril').text(formatoGuaranies.format(presupuestoDetalle.pre_abr)); 
      $('#Mayo').text(formatoGuaranies.format(presupuestoDetalle.pre_may)); 
      $('#Junio').text(formatoGuaranies.format(presupuestoDetalle.pre_jun)); 
      $('#Julio').text(formatoGuaranies.format(presupuestoDetalle.pre_jul)); 
      $('#Agosto').text(formatoGuaranies.format(presupuestoDetalle.pre_ago)); 
      $('#Septiembre').text(formatoGuaranies.format(presupuestoDetalle.pre_sep)); 
      $('#Octubre').text(formatoGuaranies.format(presupuestoDetalle.pre_oct)); 
      $('#Noviembre').text(formatoGuaranies.format(presupuestoDetalle.pre_nov)); 
      $('#Diciembre').text(formatoGuaranies.format(presupuestoDetalle.pre_dic)); 
    }
  </script>

  <!-- Script de DataTable de jquery -->
  <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>