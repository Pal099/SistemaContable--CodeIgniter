<head>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-o3O+/NvJROq4CK94LqT62USeM5dRrVo5n2t51vZafQgMOizMz5aQQVNi0HHca8w4" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-o3O+/NvJROq4CK94LqT62USeM5dRrVo5n2t51vZafQgMOizMz5aQQVNi0HHca8w4" crossorigin="anonymous">

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
<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>Fuentes de financiamiento</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
        <li class="breadcrumb-item active">Listado de las fuentes de financiamiento</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>registro/financiamiento/add" class="btn btn-primary btn-flat"><span
                class="fa fa-plus"></span> Agregar fuente de financiamiento</a>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($fuentes)): ?>
                  <?php foreach ($fuentes as $fuente): ?>
                    <tr>
                      <td>
                        <?php echo $fuente->codigo; ?>
                      </td>
                      <td>
                        <?php echo $fuente->nombre; ?>
                      </td>
                      <td>
    <a href="<?php echo base_url(); ?>registro/financiamiento/edit/<?php echo isset($fuente->id_ff) ? $fuente->id_ff : ''; ?>" class="btn btn-warning btn-xs">
    <i class="fa fa-edit"></i> Editar
</a>

    <a href="#" data-href="<?php echo base_url(); ?>registro/financiamiento/<?php echo isset($fuente->id_ff) ? $fuente->id_ff : ''; ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm-delete">
        <i class="fa fa-trash"></i> Eliminar
    </a>
</td>


                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
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
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la Fuente de financiamiento</h4>
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

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar Eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este registro?</p>
            </div>
            <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
   <button type="button" class="btn btn-danger" id="btn-confirm-delete">Eliminar</button>
</div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
   $('#confirm-delete').on('show.bs.modal', function (e) {
      var href = $(e.relatedTarget).data('href');
      $('#btn-confirm-delete').on('click', function () {
         window.location.href = href; // Redirigir a la URL de eliminación
      });
   });
});

</script>

<!-- /.modal --> 
