<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- ... (otros encabezados) ... -->
    <style>
        /* Estilos para el contenedor con marco */
        .content-container {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
        }

        /* Estilos para el título de la página */
        .pagetitle {
            margin-bottom: 1px;
            padding-bottom: 10px;
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

        /* Estilo para el contenedor del contenido */
        .content {
            background-color: #DCE1FF;
            /* Cambia el color a tu preferencia */
            padding: 20px;
            /* Agrega un espacio interno al contenido para evitar que se superponga con el fondo */
            color: #000000;
            /* Cambia el color del texto para que sea legible en el fondo */
        }

        /* Estilos para los campos opcionales */
        .optional-fields {
            display: none;
            border: 1px solid #ccc;
            padding: 10px;
            margin-left: 1px;
            margin-top: 12px;
            border-radius: 10px;
        }

        /* Estilos para el switch deslizable */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(20px);
            -ms-transform: translateX(20px);
            transform: translateX(20px);
        }

        /* Estilos para los campos principales */
        .main-fields {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
    <!-- En el <head> de tu documento -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <main id="main" class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-container">
            <div class="pagetitle">
                <h1>Cuadro de Resultados</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                        <li class="breadcrumb-item active">Listado de Cuadro de Resultados</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">

                                <table id="tabla" class="table table-bordered table-hover">

                                    <tr>
                                        <th>Código de Cuenta</th>
                                        <th>Descripción de Cuenta</th>
                                        <th>Suma Total Debe</th>
                                        <th>Suma Total Haber</th>
                                    </tr>
                                    <?php foreach ($resultados as $Codigo_CC => $info): ?>

                                        <?php

                                        if ($Codigo_CC === 'total_Haber' || $Codigo_CC === 'total_Debe') {
                                            continue;
                                        }
                                        ?>
                                        <tr>


                                            <td>
                                                <?php echo $Codigo_CC; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($info['Descripcion_CC']) ? $info['Descripcion_CC'] : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($info['Debe']) ? $info['Debe'] : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($info['Haber']) ? $info['Haber'] : ''; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td></td>
                                        <td><b>
                                                <?php echo isset($resultados['total_Debe']) ? $resultados['total_Debe'] : ''; ?>
                                            </b></td>
                                        <td><b>
                                                <?php echo isset($resultados['total_Haber']) ? $resultados['total_Haber'] : ''; ?>
                                            </b></td>
                                    </tr>
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
    </div>

    </main>


</body>

</html>