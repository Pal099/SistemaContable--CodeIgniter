<style>
 
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<main id="main" class="content">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-container">
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
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
                            <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/edit" class="btn btn-primary btn-flat"><span
                                class="fa fa-edit ms-2"></span> Modificar</a>
                            <a href=" <?php echo base_url();?>obligaciones/diario_obligaciones/pdfs" target= "_blank"class="btn btn-primary">Generar PDF</a>

                        </div>
                    </div>
                </div>

                <!-- Campos principales -->
                <div class="row">
                    <div class="col-md-10">
                        <table id="example1" class="table table-bordered table-hover">
                        
                            <form  action="<?php echo base_url();?>obligaciones/diario_obligaciones/store" method="POST">
                                                    <div class="content3">
                                                    <div class="content-container3">
                                                        <div class="main-fields">
                                                        <div class="form-group <?php echo form_error('ruc') == true ? 'has-error':''?>">
                                                            <label for="ruc">Ruc:</label>
                                                            <input type="text" class="form-control" id="ruc" name="ruc"readonly>
                                                            <?php echo form_error("ruc","<span class='help-block'>","</span>");?>
                                                        </div>

                                                                                                            <?php
                                                    // Conexión a la base de datos (debes configurar tu conexión)
                                                    $conexion = new mysqli('localhost', 'root', '', 'contanuevo');

                                                    // Verificar la conexión
                                                    if ($conexion->connect_error) {
                                                        die("La conexión a la base de datos falló: " . $conexion->connect_error);
                                                    }

                                                    // Obtener el número actual registrado en la base de datos
                                                    $consulta = "SELECT MAX(num_asi) as ultimo_numero FROM num_asi";
                                                    $resultado = $conexion->query($consulta);

                                                    if ($resultado->num_rows > 0) {
                                                        // Obtiene el último número registrado
                                                        $fila = $resultado->fetch_assoc();
                                                        $numero_actual = $fila['ultimo_numero'];

                                                        // Incrementar el número actual en 1 para el próximo registro
                                                        $numero_siguiente = $numero_actual + 1;
                                                    } else {
                                                        // Si no hay registros, establece el número inicial como 1
                                                        $numero_actual = 1;
                                                        $numero_siguiente = 2; // Si es el primer registro, el próximo número será 2
                                                    }

                                                    // Cierra la conexión a la base de datos
                                                    $conexion->close();
                                                    ?>

                                                    <div class="form-group">
                                                        <label for="num_asi">Numero:</label>
                                                        <input type="text" class="form-control" id="num_asi" name="num_asi"
                                                            value="<?php echo $numero_siguiente; ?>" readonly>
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
                                                            <input type="date" class="form-control" id="fecha" name="fecha">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                        <!-- Primer asiento de la obligación  -->
                                                    <div class="content4">
                                                    <div class="content-container4">
                                                    <div class="main-fields">
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
                                                        <!-- Monto de Pago -->
                                                        <div class="form-group">
                                                            <label for="MontoPago">Monto de Pago:</label>
                                                            <input type="numeric" class="form-control" id="MontoPago" name="MontoPago">
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
                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Programa -->
                                                        <div class="form-group">
                                                            <label for="id_pro">Programa:</label>
                                                            <select class="form-control" id="id_pro" name="id_pro">
                                                                <?php foreach($programa as $prog): ?>
                                                                    <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Fuente de Financiamiento -->
                                                        <div class="form-group">
                                                            <label for="id_ff">Fuente de Financiamiento:</label>
                                                            <select class="form-control" id="id_ff" name="id_ff">
                                                                <?php foreach($fuente_de_financiamiento as $ff): ?>
                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Cheque -->
                                                        <div class="form-group">
                                                            <label for="">Cheque ID:</label>
                                                            <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>

                                                    <!-- Segundo asiento de la obligación  -->
                                                    <div class="main-fields">
                                                        <div class="form-group">
                                                            <label for="cuentacontable_2">Código y Descripción de Cuenta Contable:</label>
                                                            <select class="form-control" id="cuentacontable_2" name="cuentacontable_2">
                                                                <?php foreach ($cuentacontable as $cc): ?>
                                                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                                        <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <!-- Campo oculto para el select, para poder separar IDCuentaContable-->
                                                        <div class="form-group" style="display: none;">
                                                            <label for="cuentacontable_text_">Cuenta Contable Seleccionada:</label>
                                                            <input type="text" class="form-control" id="cuentacontable_text" name="cuentacontable_text" readonly>
                                                        </div>

                                                        <!-- Monto de Pago -->
                                                        <div class="form-group">
                                                            <label for="MontoPago_2">Monto de Pago:</label>
                                                            <input type="text" class="form-control" id="MontoPago" name="MontoPago">
                                                        </div>

                                                        <!-- Debe -->
                                                        <div class="form-group <?php echo form_error('Debe_2') == true ? 'has-error':''?>">
                                                            <label for="Debe_2">Debe:</label>
                                                            <input type="text" class="form-control" id="Debe_2" name="Debe_2">
                                                            <?php echo form_error("Debe_2","<span class='help-block'>","</span>");?>
                                                        </div>

                                                        <!-- Haber -->
                                                        <div class="form-group <?php echo form_error('Haber_2') == true ? 'has-error':''?>">
                                                            <label for="Haber_2">Haber:</label>
                                                            <input type="text" class="form-control" id="Haber_2" name="Haber_2">
                                                            <?php echo form_error("Haber_2","<span class='help-block'>","</span>");?>
                                                        </div>

                                                        <!-- Comprobante -->
                                                        <div class="form-group">
                                                            <label for="comprobante_2">Comprobante:</label>
                                                            <input type="text" class="form-control" id="comprobante_2" name="comprobante_2">
                                                        </div>

                                                        <!-- Origen de Financiamiento -->
                                                        <div class="form-group">
                                                            <label for="id_of_2">Origen de Financiamiento:</label>
                                                            <select class="form-control" id="id_of_2" name="id_of_2">
                                                                <?php foreach($origen_de_financiamiento as $of): ?>
                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Programa -->
                                                        <div class="form-group">
                                                            <label for="id_pro_2">Programa:</label>
                                                            <select class="form-control" id="id_pro_2" name="id_pro_2">
                                                                <?php foreach($programa as $prog): ?>
                                                                    <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Fuente de Financiamiento -->
                                                        <div class="form-group">
                                                            <label for="id_ff_2">Fuente de Financiamiento:</label>
                                                            <select class="form-control" id="id_ff_2" name="id_ff_2">
                                                                <?php foreach($fuente_de_financiamiento as $ff): ?>
                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Cheque -->
                                                        <div class="form-group">
                                                            <label for="cheques_che_id_2">Cheque ID:</label>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <div class="col-md-6">
                                        <div class="col-md-6">
                                 <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                               </div>
                                        </div>

                                                
                                            </div>
                                            <div class="col-md-6">
                                                <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </form>   
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
                            
                            </div>
                        </section>
                    </div>
                    <!-- /.content-wrapper -->
                <!-- Lista con las columnas -->



               
                <!-- Contenedor del modal -->
                <div class="modal-container" id="modalContainer">
                    <div class="modal-content1">
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
                





</body>
</html>