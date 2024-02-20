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
        <li class="breadcrumb-item">Recepcion de Bienes</li>
        <li class="breadcrumb-item active">Listado de Recepcion de Bienes</li>
      </ol>
    </nav>
    <!-- Contenedor de los componentes -->
    <div class="container-fluid bg-white border rounded-3">
      <!-- Encabezado -->
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 mt-4">
            <h1>Listado de Recepcion de Bienes</h1>
          </div>
          <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>patrimonio/recepcion_bienes/add'">
                <i class="bi bi-plus-circle"></i> Agregar Recepcion de Bienes
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
                        <table id="TablaRecepcionBienes" class="table table-hover table-sm rounded-3">
                          <thead>
                            <tr>
                              <th>Nro</th>
                              <th>Fecha</th>
                              <th>Plazo</th>
                              <th>Proveedor</th>
                              <th>Monto</th>
                              <th>Observacion</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                            <?php foreach ($bienes as $bien) : ?>
                              <td><?php echo $bien->nro; ?></td>
                              <td><?php echo $bien->fecha; ?></td>
                              <td><?php echo $bien->plazo; ?></td>
                              <td><?php echo $proveedores[$bien->id_proveedor]->razon_social; ?></td>
                              <td><?php echo $bien->monto; ?></td>
                              <td><?php echo $bien->observacion; ?></td>
                              <td>
                                <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                  <button type="button" class="btn btn-primary btn-view-bienes btn-sm" data-bs-toggle="modal" data-bs-target="#modalBienes" value="<?php echo $bien->IDRecepcionBienes; ?>">
                                    <span class="fa fa-search"></span>
                                  </button>
                                  <button class="btn btn-warning btn-sm" onclick="window.location.href='<?php echo base_url() ?>suministro/recepcion_bienes/edit/<?php echo $bien->IDRecepcionBienes;?>'">
                                    <i class="bi bi-pencil-fill"></i>
                                  </button>
                                  <button class="btn btn-danger btn-remove btn-sm" onclick="window.location.href='<?php echo base_url(); ?>suministro/recepcion_bienes/delete/<?php echo$bien->IDRecepcionBienes; ?>'">
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
  <div class="modal fade mi-modal" id="modalBienes" tabindex="-1" aria-labelledby="ModalVerBienes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-extra-large">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalles de la Recepcion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm" id="TablaRecepcionBienesModal">
              <tbody>
                <tr>
                  <th>Nro</th>
                  <td id="nro"></td>
                </tr>
                <tr>
                  <th>Fecha</th>
                  <td id="fecha"></td>
                </tr>
                <tr>
                  <th>Plazo</th>
                  <td id="plazo"></td>
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
                  <th>Observacion</th>
                  <td id="observacion"></td>
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
      var table1 = $('#TablaRecepcionBienes').DataTable({
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
    $('.btn-view-bienes').on('click', function() {
      // Obtiene el ID del presupuesto desde el valor del botón
      var bienId = $(this).val();
      console.log("Recepcion ID:", bienId);

      // Se Realiza una solicitud AJAX para obtener los detalles del presupuesto
      $.ajax({
        type: 'GET',
        url: 'recepcion_bienes/getBienDetalle/' + bienId,
        success: function(response) {
          // Se maneja las respuesta acá luego se llama a la funcion de mostrarDetalles si todo es correcto
          var bienDetalle = JSON.parse(response);
          mostrarDetalles(bienDetalle);
        },
        error: function(xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
        }
      });
    });

    // Función para mostrar los detalles del presupuesto
    function mostrarDetalles(bienDetalle) {


      // Formato de numeros en guaranies
      var formatoGuaranies = new Intl.NumberFormat('es-PY', {
        style: 'currency',
        currency: 'PYG'
      });

      // Formato de la fila para la tabla
      $('#nro').text(bienDetalle.nro);
      $('#fecha').text(bienDetalle.fecha);
      $('#plazo').text(bienDetalle.plazo);
      $('#proveedor').text(bienDetalle.id_proveedor); 
      $('#monto').text(formatoGuaranies.format(bienDetalle.monto)); 
      $('#observacion').text(bienDetalle.observacion); 
    }
  </script>

  <!-- Script de DataTable de jquery -->
  <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>