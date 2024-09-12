<!-- mostrar.php para Libro Banco -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Libro Banco</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
                <li class="breadcrumb-item active">Visualización del Libro Banco</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entradas del Libro Banco</h5>
                        <!-- Añade aquí cualquier filtro o botón para agregar entradas, si es necesario -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Comprobante</th>
                                    <th>Cuenta Contable</th>
                                    <th>Debe</th>
                                    <th>Haber</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($entradas)):?>
                                    <?php foreach($entradas as $entrada):?>
                                        <tr>
                                            <td><?php echo $entrada['FechaEmision'];?></td>
                                            <td><?php echo $entrada['comprobante'];?></td>
                                            <td><?php echo $entrada['Codigo_CC'];?> - <?php echo $entrada['Descripcion_CC'];?></td>
                                            <td><?php echo $entrada['Debe'];?></td>
                                            <td><?php echo $entrada['Haber'];?></td>
                                            <!-- Aquí debes calcular y mostrar el saldo -->
                                            <td><?php // Calcula y muestra el saldo aquí ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay registros para el rango de fechas seleccionado.</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>