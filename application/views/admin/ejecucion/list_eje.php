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
          <h1>Ejecución Presupuestaria</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
                  <li class="breadcrumb-item active">Listado Presupuestaria</li>
              </ol>
          </nav>
      </div><!-- End Page Title -->

      <h2>Listado de Ejecuciones Presupuestarias</h2>
      <table id="example1" class="table table-bordered">
          <thead>
              <tr>
                  <th>Origen de Financiamiento</th>
                  <th>Fuente de Financiamiento</th>
                  <th>Programa</th>
                  <th>Cuenta</th>
                  <th>Presupuesto Inicial</th>
                  <th>Presupuesto Modificado</th>
                  <th>Obligado</th>
                  <th>Pagado</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach($ejecucionpresupuestaria as $ep): ?>
              <tr>
                  <td><?php echo $ep->codigo_of; ?></td>
                  <td><?php echo $ep->codigo_ff; ?></td>
                  <td><?php echo $ep->codigo_prog; ?></td>
                  <td><?php echo $ep->codigo_cc; ?></td>
                  <td><?php echo number_format($ep->TotalPresupuestado, 0, ',', '.'); ?></td>
                  <td><?php echo number_format($ep->TotalModificado, 0, ',', '.'); ?></td>
                  <td><?php echo number_format($ep->Obligado, 0, ',', '.'); ?></td>
                  <td><?php echo number_format($ep->Pagado, 0, ',', '.'); ?></td>
              </tr>
              <?php endforeach; ?>
          </tbody>
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
