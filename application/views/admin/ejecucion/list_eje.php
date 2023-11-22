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
                <th>ID</th>
                <th>Presupuesto</th>
                <th>Cuenta Contable</th>
                <!-- Agrega más cabeceras según los datos que quieras mostrar -->
            </tr>
        </thead>
        <tbody>
            <?php foreach($ejecucionpresupuestaria as $ep): ?>
            <tr>
                <td><?php echo $ep->ID; // Asegúrate de que la propiedad coincida con tu base de datos ?></td>
                <td><?php echo $ep->presupuesto; ?></td>
                <td><?php echo $ep->cuentacontable; ?></td>
                <!-- Asegúrate de agregar aquí más celdas si agregaste más cabeceras -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
