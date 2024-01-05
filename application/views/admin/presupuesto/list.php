<!DOCTYPE html>
<html lang="es">

<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap5/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/presupuesto_lista.css">
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
    <div class="container-fluid bg-white rounded-3">
      <!-- Encabezado -->
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 ">
            <h1>Listado de Presupuesto</h1>
          </div>
          <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-2 ">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="<?php echo base_url(); ?>mantenimiento/presupuesto/add" class="btn btn-primary"><span class="fa fa-plus"></span> </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin del Encabezado -->
      <section class="seccion_tabla">
        <div class="container-fluid">
          <!-- Listado de los proveedores -->
          <div class="col-12 pt-4 pb-4">
            <table id="tabla" class="table table-hover table-bordered table-sm rounded-3">
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
      </section>
    </div>
  </main>

  <!-- script para ver los presupuestos modal -->
  <div class="modal fade mi-modal" data-bs-backdrop="false" id="modalPresupuesto" tabindex="-1" aria-labelledby="ModalVerPresupuesto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-extra-large">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalles del Presupuesto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <table class="table table-bordered table-hover" id="TablaPresupuestoModal">
              <thead>
                <tr>
                  <th>Año</th>
                  <th>Total P.</th>
                  <th>Total M.</th>
                  <th>Enero</th>
                  <th>Febrero</th>
                  <th>Marzo</th>
                  <th>Abril</th>
                  <th>Mayo</th>
                  <th>Junio</th>
                  <th>Julio</th>
                  <th>Agosto</th>
                  <th>Septiembre</th>
                  <th>Octubre</th>
                  <th>Noviembre</th>
                  <th>Diciembre</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

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
      // Limpia el cuerpo de la tabla
      $('#TablaPresupuestoModal tbody').empty();

      // Formato de numeros en guaranies
      var formatoGuaranies = new Intl.NumberFormat('es-PY', {
        style: 'currency',
        currency: 'PYG'
      });

      // Formato de la fila para la tabla
      var nuevaFila =
        '<tr>' +
        '<td>' + presupuestoDetalle.Año + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.TotalPresupuestado) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.TotalModificado) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_ene) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_feb) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_mar) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_abr) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_may) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_jun) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_jul) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_ago) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_sep) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_oct) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_nov) + '</td>' +
        '<td>' + formatoGuaranies.format(presupuestoDetalle.pre_dic) + '</td>' +
        '</tr>';

      // Agregar la nueva fila al cuerpo de la tabla
      $('#TablaPresupuestoModal tbody').append(nuevaFila);
    }
  </script>

  <!-- Script de bootstrap -->
  <script src="<?php echo base_url(); ?>/assets/bootstrap5/js/bootstrap.min.js"></script>
</body>

</html>