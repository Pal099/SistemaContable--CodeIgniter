<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>Mi carrito</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Lista de todos los productos agregados al carrito</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>principal/carrito" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> comprar todos</a>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Categoría</th>
                  <th>Cantidad</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($productos)): ?>
                  <?php foreach ($productos as $producto): ?>
                    <tr>
                      <td>
                        <?php echo $producto->id; ?>
                      </td>
                      <td>
                        <?php echo $producto->nombre; ?>
                      </td>
                      <td>
                        <?php echo $producto->categoria; ?>
                      </td>
                      <td>
                        <?php echo $producto->cantidad; ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url(); ?>principal/delete<?php echo $producto->id; ?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
        <h4 class="modal-title">Información de la Categoría</h4>
      </div>
      <div class="modal-body">
        <!-- Contenido adicional del modal -->
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
