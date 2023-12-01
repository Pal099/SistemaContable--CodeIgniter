<head>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

</head>
<main id="main" class="main">
    <!-- Content Wrapper. Contains page content -->
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
                <th>Origen de Financiamiento    </th>
                <th>Fuente de Financiamiento</th>
                <th>Programa</th>
                <th>Cuenta</th>
                <th>Presupuesto Inicial</th>
                <th>Presupuesto Modificado</th>
                <th>Obligado</th>
                <th>Pagado</th>


                <!-- Agrega más cabeceras según los datos que quieras mostrar -->
            </tr>
        </thead>
        <tbody>
            <?php foreach($ejecucionpresupuestaria as $ep): ?>
            <tr>
                <td><?php echo $ep->ID; // Asegúrate de que la propiedad coincida con tu base de datos ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->presupuesto; ?></td>

                <!-- Asegúrate de agregar aquí más celdas si agregaste más cabeceras -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    });
</script>