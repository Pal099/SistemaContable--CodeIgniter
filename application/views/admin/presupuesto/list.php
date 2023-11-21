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
      <h1>Presupuestos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
          <li class="breadcrumb-item active">Listado Presupuesto</li>
        </ol>
      </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
                    <div class="col-md-12">
                            <a href="<?php echo base_url();?>mantenimiento/presupuesto/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar presupuesto</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tabla" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id </th>
                                    <th>Año</th>
                                    <th>Descripcion</th>
                                    <th>Total presupuestado</th>
                                    <th>Origen de financiamiento</th>
                                    <th>Fuente de financiamiento</th>
                                    <th>Programa</th>
                                    <th>Total modificado</th>
                                    <th>Enero</th>
                                    <th>Febrero</th>
                                    <th>Marzo</th>
                                    <th>Abril</th>
                                    <th>Mayo</th>
                                    <th>Junio</th>
                                    <th>Julio</th>
                                    <th>Agosto</th>
                                    <th>Septiembre</th>
                                    <th>Octubre</th>
                                    <th>Noviembre</th>
                                    <th>Diciembre</th>
                                </tr>
                            </thead>
    <?php if (!empty($presupuestos)|| !empty($cuentacontable) || !empty($programa)|| !empty($registros_financieros) || !empty($origen)): ?>
    <?php foreach ($presupuestos as $presupuesto): ?>
            <td><?php echo $presupuesto->ID_Presupuesto; ?></td>
            <td><?php echo $presupuesto->Año; ?></td>
            <td><?php echo $presupuesto->Idcuentacontable; ?></td>
            <td><?php echo $presupuesto->TotalPresupuestado; ?></td>
            <td><?php echo $presupuesto->origen_de_financiamiento; ?></td>
            <td><?php echo $presupuesto->fuente_de_financiamiento; ?></td>
            <td><?php echo $presupuesto->programa; ?></td>
            <td><?php echo $presupuesto->TotalModificado; ?></td>
            <td><?php echo $presupuesto->pre_ene; ?></td>
            <td><?php echo $presupuesto->pre_feb; ?></td>
            <td><?php echo $presupuesto->pre_mar; ?></td>
            <td><?php echo $presupuesto->pre_abr; ?></td>
            <td><?php echo $presupuesto->pre_may; ?></td>
            <td><?php echo $presupuesto->pre_jun; ?></td>
            <td><?php echo $presupuesto->pre_jul; ?></td>
            <td><?php echo $presupuesto->pre_ago; ?></td>
            <td><?php echo $presupuesto->pre_sep; ?></td>
            <td><?php echo $presupuesto->pre_oct; ?></td>
            <td><?php echo $presupuesto->pre_nov; ?></td>
            <td><?php echo $presupuesto->pre_dic; ?></td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-view-presupuesto" data-toggle="modal" data-target="#modal-default" value="<?php echo $presupuesto->ID_Presupuesto; ?>">
                        <span class="fa fa-search"></span>
                    </button>
                    <a href="<?php echo base_url() ?>mantenimiento/presupuesto/edit/<?php echo $presupuesto->ID_Presupuesto; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                    <a href="<?php echo base_url(); ?>mantenimiento/presupuesto/delete/<?php echo $presupuesto->ID_Presupuesto; ?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>


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
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de los presupuestos</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
        </div>

    </main>

    <script>
        // Manejar la visibilidad de los campos opcionales
        const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
        const optionalFields = document.querySelector(".optional-fields");

        optionalFieldsSwitch.addEventListener("change", () => {
            if (optionalFieldsSwitch.checked) {
                optionalFields.style.display = "block";
            } else {
                optionalFields.style.display = "none";
            }


        });
    </script>
</body>

</html>
