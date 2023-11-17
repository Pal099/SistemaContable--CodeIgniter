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
            display: block;
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
                        <div class="col-md-12 d-flex align-items-center">
                            <h1 style="color: #030E50; font-size: 20px; margin-right: auto;">Datos del presupuesto</h1>
                            <div class="btn-group">
                                <label class="switch" for="optionalFieldsSwitch">
                                    <input type="checkbox" id="optionalFieldsSwitch">
                                    <span class="slider"></span>
                                </label>
                                <span class="optional-fields-title">ocultar presupuesto (mes)</span>
                                <!-- Botón "Nuevo" para abrir el modal -->
                            </div>
                        </div>
                    </div>

                    <!-- Campos principales -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="main-fields">
                                <div>
                                <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/update" method="POST">
                                <input type="hidden" value="<?php echo $presupuesto->ID_Presupuesto; ?>"
                                    name="ID_Presupuesto">
                                    <div class="form-group">
                                    <label for="Año">Año:</label>
                                    <input type="number" class="form-control" id="Año" name="Año"
                                        value="<?php echo $presupuesto->Año ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="idcuentacontable">Origen de financiamiento: </label>
                                    <select name="idcuentacontable" id="idcuentacontable"
                                        class="form-control">
                                        <?php foreach ($cuentacontable as $cuentaconta): ?>
                                            <?php if ($cuentaconta->id_of == $presupuesto->idcuentacontable): ?>
                                                <option value="<?php echo $cuentaconta->IDCuentaContable ?>" selected>
                                                    <?php echo $cuentaconta->Descripcion_CC; ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?php echo $cuentaconta->IDCuentaContablef ?>">
                                                    <?php echo $cuentaconta->Descripcion_CC; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="TotalPresupuestado">Total Presupuestado:</label>
                                    <input type="number" class="form-control" id="TotalPresupuestado"
                                        name="TotalPresupuestado" value="<?php echo $presupuesto->TotalPresupuestado ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="origen_de_financiamiento_id_of">Origen de financiamiento: </label>
                                    <select name="origen_de_financiamiento_id_of" id="origen_de_financiamiento_id_of"
                                        class="form-control">
                                        <?php foreach ($origen as $o): ?>
                                            <?php if ($o->id_of == $presupuesto->origen_de_financiamiento_id_of): ?>
                                                <option value="<?php echo $o->id_of ?>" selected>
                                                    <?php echo $o->nombre; ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?php echo $o->id_of ?>">
                                                    <?php echo $o->nombre; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="main-fields">
                                <div>
                                    <div class="form-group">
                                    <label for="fuente_de_financiamiento_id_ff">Fuente de Financiamiento: </label>
                                    <select name="fuente_de_financiamiento_id_ff" id="fuente_de_financiamiento_id_ff"
                                        class="form-control">
                                        <?php foreach ($registros_financieros as $fuente): ?>
                                            <?php if ($fuente->id_ff == $presupuesto->fuente_de_financiamiento_id_ff): ?>
                                                <option value="<?php echo $fuente->id_ff ?>" selected>
                                                    <?php echo $fuente->nombre; ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?php echo $fuente->id_ff ?>">
                                                    <?php echo $fuente->nombre; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="programa">Programa: </label>
                                    <select name="programa_id_pro" id="programa_id_pro" class="form-control">
                                        <?php foreach ($programa as $prog): ?>
                                            <?php if ($prog->id_pro == $presupuesto->programa_id_pro): ?>
                                                <option value="<?php echo $prog->id_pro ?>" selected>
                                                    <?php echo $prog->nombre; ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?php echo $prog->id_pro ?>">
                                                    <?php echo $prog->nombre; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="TotalModificado">Total Modificado:</label>
                                    <input type="number" class="form-control" id="TotalModificado" name="TotalModificado"
                                        value="<?php echo $presupuesto->TotalModificado ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos opcionales (ocultos por defecto) -->
                    <div class="row optional-fields">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_ene">Presupuesto Enero:</label>
                                        <input type="number" class="form-control" id="pre_ene" name="pre_ene"
                                        value="<?php echo $presupuesto->pre_ene ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_jul">Presupuesto Julio:</label>
                                        <input type="number" class="form-control" id="pre_jul" name="pre_jul"
                                        value="<?php echo $presupuesto->pre_jul ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_feb">Presupuesto Febrero:</label>
                                        <input type="number" class="form-control" id="pre_feb" name="pre_feb"
                                        value="<?php echo $presupuesto->pre_feb ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_ago">Presupuesto Agosto:</label>
                                        <input type="number" class="form-control" id="pre_ago" name="pre_ago"
                                        value="<?php echo $presupuesto->pre_ago ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_mar">Presupuesto Marzo:</label>
                                        <input type="number" class="form-control" id="pre_mar" name="pre_mar"
                                        value="<?php echo $presupuesto->pre_mar ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_sep">Presupuesto Septiembre:</label>
                                        <input type="number" class="form-control" id="pre_sep" name="pre_sep"
                                        value="<?php echo $presupuesto->pre_sep ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_abr">Presupuesto Abril:</label>
                                        <input type="number" class="form-control" id="pre_abr" name="pre_abr"
                                        value="<?php echo $presupuesto->pre_abr ?>">

                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_oct">Presupuesto Octubre:</label>
                                        <input type="number" class="form-control" id="pre_oct" name="pre_oct"
                                        value="<?php echo $presupuesto->pre_oct ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_may">Presupuesto Mayo:</label>
                                        <input type="number" class="form-control" id="pre_may" name="pre_may"
                                        value="<?php echo $presupuesto->pre_may ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_nov">Presupuesto Noviembre:</label>
                                        <input type="number" class="form-control" id="pre_nov" name="pre_nov"
                                        value="<?php echo $presupuesto->pre_nov ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pre_jun">Presupuesto Junio:</label>
                                        <input type="number" class="form-control" id="pre_jun" name="pre_jun"
                                        value="<?php echo $presupuesto->pre_jun ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pre_dic">Presupuesto Diciembre:</label>
                                        <input type="number" class="form-control" id="pre_dic" name="pre_dic"
                                        value="<?php echo $presupuesto->pre_dic?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-flat"><span
                                                class="fa fa-save"></span>Guardar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url(); ?>mantenimiento/presupuesto"
                                            class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                                    </div>
                                </div>
                </div>
            </section>
        </div>

    </main>

    <script>
        // Manejar la visibilidad de los campos opcionales
        const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
        const optionalFields = document.querySelector(".optional-fields");

        optionalFieldsSwitch.addEventListener("change", () => {
            if (optionalFieldsSwitch.checked) {
                optionalFields.style.display = "none";
            } else {
                optionalFields.style.display = "block";
            }


        });
    </script>
</body>

</html>