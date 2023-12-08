<!DOCTYPE html>
<html lang="es">

<head>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

  <style>
    /* Estilo para el thead de DataTables */
    #example1 thead {
      background-color: #e6f7fe; /* Cambia esto al color que desees */
      color: white; /* Cambia esto al color del texto que desees */
    }
    

  </style>
</head>

<body>
  <main id="main" class="content">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-container">
      <div class="pagetitle">
        <h1>Presupuestos</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
            <li class="breadcrumb-item active">Listado Presupuesto</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">
          <!-- Left side columns -->
          <div class="col-lg-12">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>mantenimiento/presupuesto/add" class="btn btn-primary btn-flat">
                  <span class="fa fa-plus"></span> Agregar presupuesto
                </a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Id </th>
                        <th>Año</th>
                        <th>Descripcion</th>
                        <th>Total presupuestado</th>
                        <th>Origen de financiamiento</th>
                        <th>Fuente de financiamiento</th>
                        <th>Programa</th>
                        <th>Total modificado</th>
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
                        <th>Acciones</th> <!-- Agregado -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($presupuestos) || !empty($cuentacontable) || !empty($programa) || !empty($registros_financieros) || !empty($origen)): ?>
                        <?php foreach ($presupuestos as $presupuesto): ?>
                          <tr>
                            <td><?php echo $presupuesto->ID_Presupuesto; ?></td>
                            <td><?php echo $presupuesto->Año; ?></td>
                            <td><?php echo $presupuesto->Idcuentacontable; ?></td>
                            <td><?php echo $presupuesto->TotalPresupuestado; ?></td>
                            <td><?php echo $presupuesto->origen_de_financiamiento; ?></td>
                            <td><?php echo $presupuesto->fuente_de_financiamiento; ?></td>
                            <td><?php echo $presupuesto->programa; ?></td>
                            <td><?php echo $presupuesto->TotalModificado; ?></td>
                            <td><?php echo $presupuesto->pre_ene; ?></td>
                            <td><?php echo $presupuesto->pre_feb; ?></td>
                            <td><?php echo $presupuesto->pre_mar; ?></td>
                            <td><?php echo $presupuesto->pre_abr; ?></td>
                            <td><?php echo $presupuesto->pre_may; ?></td>
                            <td><?php echo $presupuesto->pre_jun; ?></td>
                            <td><?php echo $presupuesto->pre_jul; ?></td>
                            <td><?php echo $presupuesto->pre_ago; ?></td>
                            <td><?php echo $presupuesto->pre_sep; ?></td>
                            <td><?php echo $presupuesto->pre_oct; ?></td>
                            <td><?php echo $presupuesto->pre_nov; ?></td>
                            <td><?php echo $presupuesto->pre_dic; ?></td>
                            <td>
                              <div class="btn-group">
                                <button type="button" class="btn btn-info btn-view-presupuesto" data-toggle="modal" data-target="#modal-default" value="<?php echo $presupuesto->ID_Presupuesto; ?>">
                                  <span class="fa fa-search"></span>
                                </button>
                                <a href="<?php echo base_url() ?>mantenimiento/presupuesto/edit/<?php echo $presupuesto->ID_Presupuesto; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                                <a href="<?php echo base_url(); ?>mantenimiento/presupuesto/delete/<?php echo $presupuesto->ID_Presupuesto; ?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </main>
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Informacion de los presupuestos</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  </div>

  </main>

  <script>
    // Manejar la visibilidad de los campos opcionales
    const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
    const optionalFields = document.querySelector(".optional-fields");

    optionalFieldsSwitch.addEventListener("change", () => {
      if (optionalFieldsSwitch.checked) {
        optionalFields.style.display = "block";
      } else {
        optionalFields.style.display = "none";
      }
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#example1').DataTable();
    });
  </script>
</body>

</html>
