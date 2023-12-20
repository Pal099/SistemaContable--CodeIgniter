<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename= CuentasContablesExcel.xls");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style media= "print">
        @page{
            size: A4;
            margin: 0;
        }
        .boton{
            display: none;
            visibility: none;
        }
    </style>
</head>
<body>
<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>LISTA CUENTAS CONTABLES</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Listado Categorias</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Código Padre</th> <!-- Nueva columna -->
                            <th>Imputable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cuentascontables)): ?>
                            <?php foreach ($cuentascontables as $cuentacontable): ?>
                                <tr>
                                    <td><?php echo $cuentacontable->IDCuentaContable; ?></td>
                                    <td><?php echo $cuentacontable->Codigo_CC; ?></td>
                                    <td><?php echo $cuentacontable->Descripcion_CC; ?></td>
                                    <td><?php echo $cuentacontable->tipo; ?></td>
                                    <td><?php echo $cuentacontable->padre_id ? $cuentacontable->padre_id : 'N/A'; ?></td> <!-- Mostrar el código padre -->
                                    <td><?php echo $cuentacontable->imputable == 1 ? 'Sí' : 'No'; ?></td>
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
</main>

</body>

</html>
