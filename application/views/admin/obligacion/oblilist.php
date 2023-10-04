<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>Diario de Obligaciones</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Diario de Obligaciones</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/add" class="btn btn-primary btn-flat"><span
                class="fa fa-plus"></span> Agregar obligación</a>
          </div>
        </div>
        <hr>
        <?php
        // Verificar si los campos opcionales están completos
        $camposOpcionalesCompletos = true;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['tesoreria']) || empty($_POST['pedi_matricula']) || empty($_POST['modalidad']) || empty($_POST['tipo_presupuesto']) || empty($_POST['unidad_respon']) || empty($_POST['proyecto']) || empty($_POST['estado']) || empty($_POST['nro_pac']) || empty($_POST['nro_exp']) || empty($_POST['total']) || empty($_POST['pagado'])) {
                $camposOpcionalesCompletos = false;
            }
        }
        ?>

        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ruc</th>
                    <th>Numero</th>
                    <th>Contabilidad</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($obligaciones)): ?>
                    <?php foreach ($obligaciones as $obligacion): ?>
                      <tr>
                        <td><?php echo $obligacion->id; ?></td>
                        <td><?php echo $obligacion->ruc; ?></td>
                        <td><?php echo $obligacion->numero; ?></td>
                        <td><?php echo $obligacion->contabilidad; ?></td>
                        <td><?php echo $obligacion->direccion; ?></td>
                        <td><?php echo $obligacion->telefono; ?></td>
                        <td><?php echo $obligacion->observacion; ?></td>
                        <td><?php echo $obligacion->fecha; ?></td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info btn-view-diario_obligaciones" data-toggle="modal"
                              data-target="#modal-default" value="<?php echo $obligacion->id; ?>">
                              <span class="fa fa-search"></span>
                            </button>
                            <a href="<?php echo base_url() ?>obligaciones/diario_obligaciones/edit/<?php echo $obligacion->id; ?>"
                              class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                            <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/delete/<?php echo $obligacion->id; ?>"
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
        <?php if ($camposOpcionalesCompletos): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tesoreria</th>
                    <th>Pedido de matricula</th>
                    <th>Modalidad</th>
                    <th>Tipo de presupuesto</th>
                    <th>Unidad responsable</th>
                    <th>Proyecto</th>
                    <th>Estado</th>
                    <th>nro_pac</th>
                    <th>nro_exp</th>
                    <th>total</th>
                    <th>pagado</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($obligaciones as $obligacion): ?>
                    <tr>
                      <td><?php echo $obligacion->id; ?></td>
                      <td><?php echo $obligacion->tesoreria; ?></td>
                      <td><?php echo $obligacion->pedi_matricula; ?></td>
                      <td><?php echo $obligacion->modalidad; ?></td>
                      <td><?php echo $obligacion->tipo_presupuesto; ?></td>
                      <td><?php echo $obligacion->unidad_respon; ?></td>
                      <td><?php echo $obligacion->proyecto; ?></td>
                      <td><?php echo $obligacion->estado; ?></td>
                      <td><?php echo $obligacion->nro_pac; ?></td>
                      <td><?php echo $obligacion->nro_exp; ?></td>
                      <td><?php echo $obligacion->total; ?></td>
                      <td><?php echo $obligacion->pagado; ?></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-info btn-view-diario_obligaciones" data-toggle="modal"
                            data-target="#modal-default" value="<?php echo $obligacion->id; ?>">
                            <span class="fa fa-search"></span>
                          </button>
                          <a href="<?php echo base_url() ?>obligaciones/diario_obligaciones/edit/<?php echo $obligacion->id; ?>"
                            class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                          <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/delete/<?php echo $obligacion->id; ?>"
                            class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php endif; ?>

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</main>

<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <!-- ... (código anterior) ... -->

  <style>
    /* Estilos personalizados para la tabla */
    .table {
      font-size: 14px;
    }

    .table thead th {
      background-color: #f2f2f2;
      text-transform: uppercase;
      font-weight: bold;
    }

    .table tbody td {
      vertical-align: middle;
    }

    /* Estilos para los botones de acciones */
    .btn-group {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .btn-group .btn {
      margin-right: 5px;
    }
  </style>
</main>
