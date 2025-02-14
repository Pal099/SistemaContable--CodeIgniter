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
          <div class="col-md-8">
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
                                <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                                 
                                  </button>
                                  <button class="btn btn-warning btn-sm" onclick="window.location.href='<?php echo base_url() ?>registro/financiamiento/edit/<?php echo  $fuente->id_ff; ?>'">
                                    <i class="bi bi-pencil-fill"></i>
                                  </button>
                                  <button class="btn btn-danger btn-remove btn-sm" onclick="window.location.href='<?php echo base_url(); ?>registro/financiamiento/<?php echo $fuente->id_ff; ?>'">
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
<!-- /.modal --> 