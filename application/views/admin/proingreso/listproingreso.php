<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>Programa de ingresos</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Listado de los Programas de ingresos</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>registro/programaingreso/add" class="btn btn-primary btn-flat"><span
                class="fa fa-plus"></span> Agregar Programa de ingresos</a>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($ingresos)): ?>
                  <?php foreach ($ingresos as $ingreso): ?>
                    <tr>
                      <td>
                        <?php echo $ingreso->id; ?>
                      </td>
                      <td>
                        <?php echo $ingreso->nombre; ?>
                      </td>
                      <td>
                        <?php echo $ingreso->codigo; ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-info btn-view-programaingreso" data-toggle="modal"
                            data-target="#modal-default" value="<?php echo $ingreso->id; ?>">
                            <span class="fa fa-search"></span>
                          </button>
                          <a href="<?php echo base_url() ?>registro/programaingreso/edit/<?php echo $ingreso->id; ?>"
                            class="btn btn-warning"><span class="fa fa-pencil"></span></a>

                          <a href="<?php echo base_url(); ?>registro/programaingreso/delete/<?php echo $ingreso->id; ?>"
                            class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
        <h4 class="modal-title">Informacion de los Programas de ingresos</h4>
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