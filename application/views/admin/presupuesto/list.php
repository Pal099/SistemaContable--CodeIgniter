<!DOCTYPE html>
<html lang="es">

<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap5/css/bootstrap.min.css">
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
                  <td><?php echo $presupuesto->TotalPresupuestado; ?></td>
                  <td><?php echo $presupuesto->origen_de_financiamiento; ?></td>
                  <td><?php echo $presupuesto->fuente_de_financiamiento; ?></td>
                  <td><?php echo $presupuesto->programa; ?></td>
                  <td><?php echo $presupuesto->TotalModificado; ?></td>
                  <td>
                    <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                      <button type="button" class="btn btn-primary btn-view-presupuesto btn-sm" data-toggle="modal" data-target="#modal-default" value="<?php echo $presupuesto->ID_Presupuesto; ?>">
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
  <!-- Script de bootstrap -->
  <script src="<?php echo base_url(); ?>/assets/bootstrap5/js/bootstrap.min.js"></script>
</body>

</html>