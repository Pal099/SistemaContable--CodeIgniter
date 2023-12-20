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
                <nav>
                    <ol class="breadcrumb">
                        <li class="bi bi-house breadcrumb-item"><a href="<?php echo base_url(); ?>"> Inicio</a></li>
                        <li class="breadcrumb-item active">Vista del Presupuesto</li>
                    </ol>
                </nav>
                <h1>Presupuesto</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata("error")): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                    <p><i class="icon fa fa-ban"></i>
                                        <?php echo $this->session->flashdata("error"); ?>
                                    </p>

                                </div>
                            <?php endif; ?>
                    <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/store" method="POST">
                                <div class="form-group">
                                    <label for="Año">Año:</label>
                                    <input type="text" class="form-control" id="Año" name="Año">
                                </div>
                                <div class="form-group">
                                     <label for="cuentacontable">Código y Descripción de Cuenta Contable:</label>
                                            <select class="form-control" id="cuentacontable" name="cuentacontable">
                                                <?php foreach ($cuentacontable as $cc): ?>
                                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                             <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                             </select>
                                </div>
                                <div class="form-group">
                                    <label for="TotalPresupuestado">Total Presupuestado:</label>
                                    <input type="text" class="form-control" id="TotalPresupuestado"
                                        name="TotalPresupuestado">
                                </div>
                                <div class="form-group">
                                    <label for="origen_de_financiamiento">origen de financiamiento:</label>
                                    <select name="origen_de_financiamiento" id="origen_de_financiamiento" class="form-control">
                                        <?php foreach ($origen as $origen): ?>
                                            <option value="<?php echo $origen->id_of?>">
                                                <?php echo $origen->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuente_de_financiamiento">Fuente de financiamiento:</label>
                                    <select name="fuente_de_financiamiento" id="fuente_de_financiamiento" class="form-control">
                                        <?php foreach ($registros_financieros as $fuente): ?>
                                            <option value="<?php echo $fuente->id_ff?>">
                                                <?php echo $fuente->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="programa_id_pro">Programa:</label>
                                    <select name="programa_id_pro" id="programa_id_pro" class="form-control">
                                        <?php foreach ($programa as $prog): ?>
                                            <option value="<?php echo $prog->id_pro?>">
                                                <?php echo $prog->nombre; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="TotalModificado">Total Modificado:</label>
                                    <input type="text" class="form-control" id="TotalModificado" name="TotalModificado">
                                </div>
                                 <!-- Agrega un campo de selección para el mes -->
                        <div class="form-group">
                            <label for="mes">Mes:</label>
                            <select name="mes" id="mes" class="form-control">
                                <?php
                                $mesesMapping = array(
                                    'Enero' => 'ene',
                                    'Febrero' => 'feb',
                                    'Marzo' => 'mar',
                                    'Abril' => 'abr',
                                    'Mayo' => 'may',
                                    'Junio' => 'jun',
                                    'Julio' => 'jul',
                                    'Agosto' => 'ago',
                                    'Septiembre' => 'sep',
                                    'Octubre' => 'oct',
                                    'Noviembre' => 'nov',
                                    'Diciembre' => 'dic'
                                );

                                foreach ($mesesMapping as $nombreMes => $abreviaturaMes) {
                                    echo "<option value='$abreviaturaMes'>$nombreMes</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Agrega campos de texto para cada mes -->
                        <?php foreach ($mesesMapping as $nombreMes => $abreviaturaMes): ?>
                            <div class="form-group" id="pre_<?php echo $abreviaturaMes; ?>_field" style="display: none;">
                                <label for="pre_<?php echo $abreviaturaMes; ?>"><?php echo $nombreMes; ?>:</label>
                                <input type="text" name="pre_<?php echo $abreviaturaMes; ?>" id="pre_<?php echo $abreviaturaMes; ?>" class="form-control">
                            </div>
                        <?php endforeach; ?>


                                <div class="form-group">
                                    <label for="monto_mes">Monto para el Mes:</label>
                                    <input type="text" class="form-control" id="monto_mes" name="monto_mes">
                                </div>
                                
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-flat"><span
                                        class="fa fa-save"></span>Guardar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo base_url(); ?>mantenimiento/presupuesto" class="btn btn-danger"><span
                                        class="fa fa-remove"></span>Cancelar</a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.box -->
        </div>
        </div>
    </section>



    <script>
    // Función para mostrar u ocultar el campo de texto según el mes seleccionado
    function mostrarCampoTexto() {
        var mesSeleccionado = document.getElementById('mes').value;
        var camposMes = document.querySelectorAll('[id^=pre_]_field');

        camposMes.forEach(function(campo) {
            campo.style.display = 'none';
        });

        var campoMesSeleccionado = document.getElementById('pre_' + mesSeleccionado + '_field');
        if (campoMesSeleccionado) {
            campoMesSeleccionado.style.display = 'block';
        }
    }

    document.getElementById('mes').addEventListener('change', mostrarCampoTexto);
    mostrarCampoTexto();
</script>


</main>