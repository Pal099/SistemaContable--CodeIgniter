<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- ... (otros encabezados) ... -->
    <style>
     
    

  /* Estilo para el contenedor del modal */
.modal-container {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    align-items: center;
    justify-content: center;
}

.modal-content {
    /* Estilos para el contenido del modal */
    background-color: #fefefe;
    border: 1px solid #888;
    border-radius: 10px;
    padding: 20px;
    width: 50%; /* Ajusta el ancho del contenido del modal */
    margin-top: 20%; /* Ajusta el margen superior para centrarlo más abajo */
    transform: translateY(-50%); /* Centrado vertical */
}


/* Estilo para el contenedor del modal de programas  */
.modal-container_obli {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    align-items: center;
    justify-content: center;
}

.modal-content_obli {
    /* Estilos para el contenido del modal */
    background-color: #fefefe;
    border: 1px solid #888;
    border-radius: 10px;
    padding: 20px;
    width: 50%; /* Ajusta el ancho del contenido del modal */
    margin-top: 20%; /* Ajusta el margen superior para centrarlo más abajo */
    transform: translateY(-50%); /* Centrado vertical */
}



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
            background-color: #DCE1FF; /* Cambia el color a tu preferencia */
            padding: 20px; /* Agrega un espacio interno al contenido para evitar que se superponga con el fondo */
            color: #000000; /* Cambia el color del texto para que sea legible en el fondo */
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

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
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
                    <li class="breadcrumb-item active">Vista del Diario de obligaciones</li>
                </ol>
            </nav>
            <h1>Diario de Obligaciones</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="row">
                    <div class="col-md-12 d-flex align-items-center">
                        <h1 style="color: #030E50; font-size: 20px; margin-right: auto;">Datos del asiento</h1>
                        <div class="btn-group">
                            <label class="switch" for="optionalFieldsSwitch">
                                <input type="checkbox" id="optionalFieldsSwitch">
                                <span class="slider"></span>
                            </label>
                            <span class="optional-fields-title">Campos opcionales</span>
                            <!-- Botón "Nuevo" para abrir el modal -->
                            <button class="btn btn-sm btn-primary ms-2" title="Nuevo" id="openModalBtn">
                     <i class="bi bi-plus"></i> Nuevo
</button>
                                    <button class="btn btn-sm btn-danger ms-2" title="Eliminar">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Campos principales -->
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">

                        <div class="main-fields">
                            <div class="form-group">
                                <label for="ruc">Ruc:</label>
                                <input type="text" class="form-control" id="ruc" name="ruc">
                                <?php echo form_error("ruc","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="numero">Numero:</label>
                                <input type="text" class="form-control" id="numero" name="numero">
                            </div>
                            <div class="form-group">
                                <label for="contabilidad">Contabilidad:</label>
                                <input type="text" class="form-control" id="contabilidad" name="contabilidad">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="tesoreria">Tesoreria:</label>
                                <input type="text" class="form-control" id="tesoreria" name="tesoreria">
                            </div>
                            <div class="form-group">
                                <label for="observacion">Observación:</label>
                                <input type="text" class="form-control" id="observacion" name="observacion">
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="text" class="form-control" id="fecha" name="fecha">
                            </div>
                            <div class="form-group">
                            <label for="IDCuentaContable">Cuenta Contable:</label>
                            <select class="form-control" id="IDCuentaContable" name="IDCuentaContable">
                            <?php foreach($cuentacontable as $cc): ?>
                                <option value="<?php echo $cc->id; ?>"><?php echo $cc->nombre; ?></option>
                            <?php endforeach; ?>
                            </select>
                            </div>
                             <!-- Monto de Pago -->
                            <div class="form-group">
                                <label for="MontoPago">Monto de Pago:</label>
                                <input type="text" class="form-control" id="MontoPago" name="MontoPago">
                            </div>

                            <!-- Debe -->
                            <div class="form-group">
                                <label for="Debe">Debe:</label>
                                <input type="text" class="form-control" id="Debe" name="Debe">
                            </div>

                            <!-- Haber -->
                            <div class="form-group">
                                <label for="Haber">Haber:</label>
                                <input type="text" class="form-control" id="Haber" name="Haber">
                            </div>

                            <!-- Comprobante -->
                            <div class="form-group">
                                <label for="comprobante">Comprobante:</label>
                                <input type="text" class="form-control" id="comprobante" name="comprobante">
                            </div>

                            <!-- Origen de Financiamiento -->
                            <div class="form-group">
                                <label for="id_of">Origen de Financiamiento:</label>
                                <select class="form-control" id="id_of" name="id_of">
                                    <?php foreach($origen_de_financiamiento as $of): ?>
                                        <option value="<?php echo $of->id; ?>"><?php echo $of->nombre; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Programa -->
                            <div class="form-group">
                                <label for="id_pro">Programa:</label>
                                <select class="form-control" id="id_pro" name="id_pro">
                                    <?php foreach($programa as $prog): ?>
                                        <option value="<?php echo $prog->id; ?>"><?php echo $prog->nombre; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Fuente de Financiamiento -->
                            <div class="form-group">
                                <label for="id_ff">Fuente de Financiamiento:</label>
                                <select class="form-control" id="id_ff" name="id_ff">
                                    <?php foreach($fuente_de_financiamiento as $ff): ?>
                                        <option value="<?php echo $ff->id; ?>"><?php echo $ff->nombre; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Cheque -->
                            <div class="form-group">
                                <label for="cheques_che_id">Cheque ID:</label>
                                <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                            </div>

                        </div>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                            <!-- Campos opcionales (ocultos por defecto) -->
                            <div class="row optional-fields">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="pedi_matricula">Ped. Mat:</label>
                                                <input type="text" class="form-control" id="pedi_matricula" name="pedi_matricula">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="modalidad">Modalidad:</label>
                                                <input type="text" class="form-control" id="modalidad" name="modalidad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tipo_presupuesto">Tipo de Presupuesto:</label>
                                                <input type="text" class="form-control" id="tipo_presupuesto" name="tipo_presupuesto">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="unidad_respon">Unidad responsable:</label>
                                                <input type="text" class="form-control" id="unidad_respon" name="unidad_respon">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="proyecto">Proyecto:</label>
                                                <input type="text" class="form-control" id="proyecto" name="proyecto">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="estado">Estado:</label>
                                                <input type="text" class="form-control" id="estado" name="estado">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nro_pac">Nro. Pac:</label>
                                                <input type="text" class="form-control" id="nro_pac" name="nro_pac">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nro_exp">Nro. Exp:</label>
                                                <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="total">Total:</label>
                                                <input type="text" class="form-control" id="total" name="total">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pagado">Pagado:</label>
                                                <input type="text" class="form-control" id="pagado" name="pagado">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
\\re haciendo la vista
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>RUC</th>
                                    <th>Número</th>
                                    <th>Contabilidad</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Observación</th>
                                    <th>Fecha</th>
                                    <th>Tesorería</th>
                                    <th>Pedí Matrícula</th>
                                    <th>Modalidad</th>
                                    <th>Tipo de Presupuesto</th>
                                    <th>Unidad Responsable</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Nro. PAC</th>
                                    <th>Nro. Expediente</th>
                                    <th>Total</th>
                                    <th>Pagado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)): ?>
                                    <?php foreach ($data as $item): ?>
                                        <tr>
                                            <td><?php echo $item->id; ?></td>
                                            <td><?php echo $item->ruc; ?></td>
                                            <td><?php echo $item->numero; ?></td>
                                            <td><?php echo $item->contabilidad; ?></td>
                                            <td><?php echo $item->direccion; ?></td>
                                            <td><?php echo $item->telefono; ?></td>
                                            <td><?php echo $item->observacion; ?></td>
                                            <td><?php echo $item->fecha; ?></td>
                                            <td><?php echo $item->tesoreria; ?></td>
                                            <td><?php echo $item->pedi_matricula; ?></td>
                                            <td><?php echo $item->modalidad; ?></td>
                                            <td><?php echo $item->tipo_presupuesto; ?></td>
                                            <td><?php echo $item->unidad_respon; ?></td>
                                            <td><?php echo $item->proyecto; ?></td>
                                            <td><?php echo $item->estado; ?></td>
                                            <td><?php echo $item->nro_pac; ?></td>
                                            <td><?php echo $item->nro_exp; ?></td>
                                            <td><?php echo $item->total; ?></td>
                                            <td><?php echo $item->pagado; ?></td>
                                            <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-view-Diario_obligaciones" data-toggle="modal"
                                            data-target="#modal-default" value="<?php echo $data->id; ?>">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="<?php echo base_url() ?>mantenimiento/Diario_obligaciones/edit/<?php echo $data->id; ?>"
                                            class="btn btn-warning"><span class="fa fa-pencil"></span></a>

                                        <a href="<?php echo base_url(); ?>mantenimiento/Diario_obligaciones/delete/<?php echo $data->id; ?>"
                                            class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                                        </div>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>



                <!-- Botones -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<!-- Lista con las columnas -->

<button class="btn btn-sm btn-primary ms-2" title="Seleccione datos para su carga" id="openModalBtn_obli">
    <i class="bi bi-plus"></i> Seleccionar datos
<button class="btn btn-sm btn-primary btn-select-datos" title="Seleccione datos para su carga" id="openModalBtn_obli">
   <i class="bi bi-plus"></i> Seleccionar datos
</button>


</main>
<!-- Contenedor del modal -->
<div class="modal-container" id="modalContainer">
    <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h3>Lista de Proveedores</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ruc</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $index => $proveedor): ?>
                    <tr class="list-item" onclick="selectProveedor('<?= $proveedor->ruc ?>', '<?= $proveedor->razon_social ?>', '<?= $proveedor->direccion ?>')">
                        <td><?= $index + 1 ?></td>
                        <td><?= $proveedor->ruc ?></td>
                        <td><?= $proveedor->razon_social ?></td>
                        <td><?= $proveedor->direccion ?></td>
                        <td><?= $proveedor->telefono ?></td>
                        <td><?= $proveedor->email ?></td>
                        <td><?= $proveedor->observacion ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>




<!-- Contenedor del modal de programa, ff, of -->
</div>
<div class="modal-container_obli" id="modalContainer_obli">
    <div class="modal-content_obli">
        <span class="close" id="closeModalBtn_obli">&times;</span>
        <h3>Tabla dinámica</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nombre Programa</th>
                    <th>Fuente de Financiamiento</th>
                    <th>Origen de Financiamiento</th>
                    <th>Numero de cuenta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gastos as $index => $gasto): ?>
                    <tr class="list-item" onclick="selectPrograma('<?= $gasto->nombre_programa ?>','<?= $gasto->nombre_fuente ?>','<?= $gasto->nombre_origen?>')">
                        
                        <td><?= $gasto->nombre_programa ?></td>
                        <td><?= $gasto->nombre_fuente ?></td>
                        <td><?= $gasto->nombre_origen ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.content-wrapper -->
</main>

<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <!-- ... (código anterior) ... -->

  <style>
    /* Estilos personalizados para la tabla */
    .table {
      font-size: 14px;
    }

    .table thead th {
      background-color: #f2f2f2;
      text-transform: uppercase;
      font-weight: bold;
    }

    .table tbody td {
      vertical-align: middle;
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
  </style>
</main>
