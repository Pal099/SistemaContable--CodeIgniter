<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ejecución Presupuestaria</title>
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
      color: #333; /* Cambia esto al color del texto que desees */
    }
  </style>
</head>
<body>
  <main id="main" class="main">
      <div class="pagetitle">
          <h1>Ejecución de Plan de Caja</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
                  <li class="breadcrumb-item active">Listado Presupuestaria</li>
              </ol>
          </nav>
      </div><!-- End Page Title -->

      <h2>Listado de Ejecuciones Presupuestarias</h2>
      <table id="TablaPresupuesto" class="table table-hover table-sm rounded-3">
          <thead>
              <tr>
                  <th>OF</th>
                  <th>FF</th>
                  <th>PROG</th>
                  <th>Cuenta</th>
                  <th>Presupuesto Inicial</th>
                  <th>Aumento/Disminución<br> Presupuestaria</th>
                  <th>Presupuesto Vigente</th>
                  <th>Obligado</th>
                  <th>SaldoPresupuestario</th>
                  <th>Pagado</th>
              </tr>
          </thead>
          <tbody>
          <?php foreach($ejecucionpresupuestaria as $ep): ?>
            <?php if ($ep->Obligado > 0 || $ep->Pagado > 0): ?>
                <tr>
                    <td><?php echo $ep->origen_de_financiamiento_id_of; ?></td>
                    <td><?php echo $ep->fuente_de_financiamiento_id_ff; ?></td>
                    <td><?php echo $ep->programa_id_pro; ?></td>
                    <td><?php echo $ep->Idcuentacontable; ?></td>
                    <td><?php echo $ep->TotalPresupuestado; ?></td>
                    <td><?php echo $ep->TotalModificado; ?></td>
                    <td><?php echo $ep->Vigente; ?></td>
                    <td><?php echo $ep->Obligado; ?></td>
                    <td><?php echo $ep->SaldoPresupuestario; ?></td>
                    <td><?php echo $ep->Pagado; ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
      </table>
  </main>

  <script>
      $(document).ready(function() {
          $('#example1').DataTable({
              "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
              }
          });
      });
  </script>
</body>
</html>