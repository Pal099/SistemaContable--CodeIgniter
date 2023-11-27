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
    <table class="table table-bordered">
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
