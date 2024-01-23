<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Estilos de DataTable de jquery -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/presupuesto_lista.css">
  <!-- Copia el bloque de head del modelo -->
</head>

<body>
  <main id="main" class="content">
  <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
        <li class="breadcrumb-item active">Listado de Origen de Financiamiento</li>
      </ol>
    </nav>
    <!-- Contenedor de los componentes -->
    <div class="container-fluid bg-white border rounded-3">
      <!-- Encabezado -->
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 mt-4">
            <h1>Origen de Financiamiento</h1>
          </div>
          <div class="col-md-6 d-flex flex-row justify-content-end align-items-center mt-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>registro/origen/add'">
                <i class="bi bi-plus-circle"></i> Agregar Origen
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin del Encabezado -->
      <hr> <!-- barra separadora -->
        <div class="seccion_tabla">
          <div class="container-fluid">
            <div class="row">
              <div class="container-fluid mt-2">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <div class="card border">
                      <div class="card-body mt-4">
                        <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-hover">
                            <!-- Copia la estructura y encabezados de la tabla del modelo -->
                            <thead>
                              <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- Copia el bucle de filas de la tabla del modelo -->
                              <?php if (!empty($origenes)): ?>
                                <?php foreach ($origenes as $origen): ?>
                                  <tr>
                                    <td>
                                      <?php echo $origen->codigo; ?>
                                    </td>
                                    <td>
                                      <?php echo $origen->nombre; ?>
                                    </td>
                                    <td>
                                      <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                        <!-- Copia los botones de acciones del modelo -->
                                        <button class="btn btn-warning btn-sm" onclick="window.location.href='<?php echo base_url() ?>registro/origen/edit/<?php echo $origen->id_of; ?>'">
                                          <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="btn btn-danger btn-remove btn-sm" onclick="window.location.href='<?php echo base_url(); ?>registro/origen/delete/<?php echo $origen->id_of; ?>'">
                                          <i class="bi bi-trash"></i>
                                        </button>
                                      </div>
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
      </div>
    </section>

    <!-- Copia el bloque de modal del modelo -->

    <!-- Copia los scripts dentro del body del modelo -->
    <script>
      $(document).ready(function() {
        var table1 = $('#example1').DataTable({
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

    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
  </body>

</html>
