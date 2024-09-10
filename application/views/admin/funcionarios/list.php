<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <style>
        /* Estilo para el thead de DataTables */
        #example1 thead {
            background-color: #e6f7fe;
            /* Cambia esto al color que desees */
            color: white;
            /* Cambia esto al color del texto que desees */
        }
    </style>
</head>

<main id="main" class="main">
    <!-- Content Wrapper. Contains page content -->
    <div class="pagetitle">
        <h1>Funcionarios</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item active">Listado de los Funcionarios</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?php echo base_url(); ?>funcionario/funcionario/add" class="btn btn-primary btn-flat"><span
                                class="fa fa-plus"></span> Agregar Funcionario</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Unidad</th>
                                    <th>Dependencia</th>
                                    <th>Funcionario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($funcionarios)): ?>
                                    <?php foreach ($funcionarios as $funcionarios): ?>
                                        <tr>
                                            <td>
                                                <?php echo $funcionarios->unidad; ?>
                                            </td>
                                            <td>
                                                <?php echo $funcionarios->dependencia; ?>
                                            </td>
                                            <td>
                                                <?php echo $funcionarios->funcionario; ?>
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

<!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#example1').DataTable();
    });
</script>