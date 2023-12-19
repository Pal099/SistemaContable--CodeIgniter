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
    <script src="assets/js/modal_obli.js"></script>
    <link href="<?php echo base_url();?>assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">


</head>
<body>
<main id="main" class="content">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-container">
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Vista del Deposito Bancario</li>
                </ol>
            </nav>
            <h1>Deposito Bancario</h1>
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
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                        
                            <form  action="<?php echo base_url();?>obligaciones/deposito_obligaciones/store" method="POST">
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

                                                    // Obtener el número actual registrado en la base de datos
                                                    $consulta = "SELECT MAX(op) as op FROM num_asi";
                                                    $resultado = $conexion->query($consulta);

                                                    // Verificar si hay filas en el resultado
                                                    if ($resultado !== false && $resultado->num_rows > 0) {
                                                        $op = $resultado->fetch_assoc();
                                                        $op_actual = $op['op'];
                                                        // Incrementar el número actual en 1 para el próximo registro
                                                        $op_actual = $op_actual + 1;
                                                    } else {
                                                        $op_actual = 0; // Manejar el caso en que la consulta no fue exitosa
                                                    }

                                                    // Cierra la conexión a la base de datos
                                                    $conexion->close();
                                                    ?>

                                                            <div class="form-group">
                                                                <label for="num_asi">Numero:</label>
                                                                <input type="text" class="form-control" id="num_asi" name="num_asi" value="<?php echo $numero_siguiente; ?>" readonly>
                                                            </div>


                                                        <div class="form-group">
                                                            <label for="contabilidad">Contabilidad:</label>
                                                            <input type="text" class="form-control" id="contabilidad" name="contabilidad" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="direccion">Dirección:</label>
                                                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telefono">Teléfono:</label>
                                                            <input type="text" class="form-control" id="telefono" name="telefono" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tesoreria">Tesoreria:</label>
                                                            <input type="text" class="form-control" id="tesoreria" name="tesoreria" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="observacion">Observación:</label>
                                                            <input type="text" class="form-control" id="observacion" name="observacion">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha:</label>
                                                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                
                                                        <!-- Primer asiento de la obligación  -->

                                                <table class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                              <!-- acá podemos insertar una ID <th>#</th> -->  
                                                                               
                                                                                <th>Fuente</th>
                                                                                <th>Origen</th>
                                                                                <th>Cuenta Contable</th>
                                                                                <th>Comprobante</th>
                                                                                <th>Detalles</th>
                                                                                <th>Monto de Pago</th>
                                                                                <th>Debe</th>
                                                                                <th>Haber</th>
                                                                                <th>Cheque</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                                    <tr>
                                                                                        <!-- acá podemos insertar una ID  -->
                                                                                          <!-- acá podemos insertar una ID  -->

                                                                                        
                                                                                        <td><select class="form-control" id="id_ff" name="id_ff" required>
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of" name="id_of" required>
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td>
                                                                                            <input type="hidden" class="form-control" id="idcuentacontable" name="idcuentacontable">
                                                                                            <input type="text" class="form-control" id="codigo_cc" name="codigo_cc">
                                                                                            <input type="text" class="form-control" id="descripcion_cc" name="descripcion_cc" >
                                                                                            <button class="btn btn-sm btn-primary ms-2" id="openModalBtn_3">
                                                                                                <i class="bi bi-search"></i> Busqueda Cuenta
                                                                                            </button>
                                                                                        </td>
                                                                                        <!-- Los siguientes campos son ejemplos, modifícalos según tus necesidades -->
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="comprobante" name="comprobante">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="detalles" name="detalles" required>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="MontoPago" name="MontoPago" readonly>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Debe" name="Debe" required>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber" name="Haber" required>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                          <!-- segundo asiento  -->
                                                                                      
                                                                                          <!-- acá podemos insertar una ID  -->

                                                                                        
                                                                                        <td><select class="form-control" id="id_ff_2" name="id_ff_2" required>
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of_2" name="id_of_2" required>
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td>
                                                                                            <input type="hidden" class="form-control" id="idcuentacontable_2" name="idcuentacontable_2">
                                                                                            <input type="text" class="form-control" id="codigo_cc_2" name="codigo_cc_2">
                                                                                            <input type="text" class="form-control" id="descripcion_cc_2" name="descripcion_cc_2" >
                                                                                            <button class="btn btn-sm btn-primary ms-2" id="openModalBtn_4">
                                                                                                <i class="bi bi-search"></i> Busqueda Cuenta
                                                                                            </button>
                                                                                        </td>
                                                                                        <!-- Los siguientes campos son ejemplos, modifícalos según tus necesidades -->
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="comprobante_2" name="comprobante_2">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="detalles_2" name="detalles_2" required>
                                                                                        </td>
                                                                                        <td contenteditable="false">
                                                                                            <input type="text" class="form-control" id="MontoPago_2" name="MontoPago_2" readonly>
                                                                                        </td>
                                                                                        <td contenteditable="false">
                                                                                            <input type="text" class="form-control" id="Debe_2" name="Debe_2" required>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber_2" name="Haber_2" required>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="cheques_che_id_2" name="cheques_che_id_2">
                                                                                        </td>
                                                                                    </tr>
                                                                        </tbody>
                                                                    </table>
                                                    <!-- Segundo asiento de la obligación  -->
                                                    
                                                    
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
                                                <div class="form-group">
                                                    <label for="OP">N° Op</label>
                                                    <input type="text" class="form-control" id="OP"
                                                    name="OP" value="<?= $op_actual ?>"readonly>
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
                                                <a href="<?php echo base_url(); ?>obligaciones/deposito_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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
                                                        <button type="button" class="btn btn-info btn-view-Deposito_obligaciones" data-toggle="modal"
                                                            data-target="#modal-default" value="<?php echo $data->id; ?>">
                                                            <span class="fa fa-search"></span>
                                                        </button>
                                                        
                                                        <a href="<?php echo base_url(); ?>mantenimiento/Deposito_obligaciones/delete/<?php echo $data->id; ?>"
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
                <div class="modal-container" id="modalContainer_3">
                    <div class="modal-content">
                        
                        <span class="close_3" id="closeModalBtn_3" onclick="closeModal_3()">&times;</span>
                        <h3>Buscador de Cuentas Contables</h3>
                        <input type="text" id="searchInput" placeholder="Buscar por código o descripción...">
                        <table class="table table-bordered table-hover" id="cuentasContablesTable">
                        <thead>
                                            <tr >
                                               <th>IDCuentaContable</th>
                                                <th>Código de Cuenta</th>
                                                <th>Descripción de Cuenta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentacontable as $dato): ?>
                                                <tr class="list-item" onclick="selectCC( '<?= $dato->IDCuentaContable ?>','<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')">
                                                    <td>
                                                        <?= $dato->IDCuentaContable ?>
                                                    </td>
                                                    <td>
                                                        <?= $dato->Codigo_CC ?>
                                                    </td>
                                                    <td>
                                                        <?= $dato->Descripcion_CC ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                    </div>
                </div>
                <div class="modal-container" id="modalContainer_4">
                    <div class="modal-content">
                        
                        <span class="close_4" id="closeModalBtn_4" onclick="closeModal_4()">&times;</span>
                        <h3>Buscador de Cuentas Contables</h3>
                        <input type="text" id="searchInput_2" placeholder="Buscar por código o descripción...">
                        <table class="table table-bordered table-hover" id="cuentasContablesTable_2">
                        <thead>
                                            <tr >
                                               <th>IDCuentaContable</th>
                                                <th>Código de Cuenta</th>
                                                <th>Descripción de Cuenta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cuentacontable as $dato): ?>
                                                <tr class="list-item" onclick="selectCC2(  <?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')">
                                                    <td>
                                                        <?= $dato->IDCuentaContable ?>
                                                    </td>
                                                    <td>
                                                        <?= $dato->Codigo_CC ?>
                                                    </td>
                                                    <td>
                                                        <?= $dato->Descripcion_CC ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                    </div>
                </div>

                <script>
                    
                document.addEventListener("DOMContentLoaded", function () {
                    // Agregar evento al botón "Cancelar"
                    const cancelarBtn = document.getElementById("cancelarBtn");
                    cancelarBtn.addEventListener("click", function () {
                        // Limpia el contenido de la tabla de datos seleccionados
                        const tablaDatosSeleccionados = document.getElementById("tablaolilist");
                        const tbody = tablaDatosSeleccionados.querySelector("tbody");
                        tbody.innerHTML = ""; // Borra todas las filas

                        // Oculta el campo de comprobante
                        const comprobanteContainer = document.querySelector('.comprobante-container');
                        comprobanteContainer.style.display = 'none';
                    });

                });

                


    
                function selectPrograma(nombrePrograma, nombreFuente, nombreOrigen, numeroCuenta) {
                    // Captura la tabla principal por su ID
                    var tabla = document.getElementById('tablaolilist').getElementsByTagName('tbody')[0];
                    
                    // Crea una nueva fila en la tabla
                    var fila = tabla.insertRow();

                    // Inserta celdas en la fila
                    var celdaPrograma = fila.insertCell(0);
                    var celdaFuente = fila.insertCell(1);
                    var celdaOrigen = fila.insertCell(2);
                    var celdaCuenta = fila.insertCell(3);

                    // Asigna los valores a las celdas
                    celdaPrograma.innerHTML = nombrePrograma;
                    celdaFuente.innerHTML = nombreFuente;
                    celdaOrigen.innerHTML = nombreOrigen;
                    celdaCuenta.innerHTML = numeroCuenta;

                    // Muestra el campo de comprobante
                    var comprobanteContainer = document.querySelector('.comprobante-container');
                    comprobanteContainer.style.display = 'block';

                    closeModal_obli()
                }
            
            
    // Función para abrir el modal
    function openModal() {
        var modalContainer = document.getElementById('modalContainer');
        modalContainer.style.display = 'flex';
        openModalBtn.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal() {
        var modalContainer = document.getElementById('modalContainer');
        modalContainer.style.display = 'none';
        openModalBtn.style.zIndex = 1;
    }


                // Función para seleccionar un proveedor
                function selectProveedor(ruc, razonSocial, direccion) {
                        // Actualizar los campos de texto en la vista principal
                        document.getElementById('ruc').value = ruc;
                        document.getElementById('contabilidad').value = razonSocial;
                        document.getElementById('tesoreria').value = razonSocial;
                        document.getElementById('direccion').value = direccion;


                        
                        closeModal(); // Cierra el modal después de seleccionar un proveedor
                    }

                    // Agregar evento al botón "Nuevo" para abrir el modal
                    const openModalBtn = document.getElementById("openModalBtn");
                    openModalBtn.addEventListener("click", () => {
                        openModal();
                    });

                    // Agregar evento al botón de cerrar para cerrar el modal
                    const closeModalBtn = document.getElementById("closeModalBtn");
                    closeModalBtn.addEventListener("click", () => {
                        closeModal();
                    });
                


            
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

                    




    document.addEventListener("DOMContentLoaded", function () {
        var select = document.getElementById("cuentacontable");
        var textInput = document.getElementById("cuentacontable_text");

        // Actualiza el campo de texto oculto al cambiar la selección
        select.addEventListener("change", function () {
            var selectedOption = select.options[select.selectedIndex];
            textInput.value = selectedOption.textContent;
        });
    });

</script>

<script>
    // Función para abrir el modal de las cuentas contables
    function openModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'flex';
        openModalBtn_3.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'none';
        openModalBtn_3.style.zIndex = 1;
    }
    function selectCC( IDCuentaContable,Codigo_CC, Descripcion_CC) {
    // Actualizar los campos de texto en la vista principal con los valores seleccionados
        document.getElementById('idcuentacontable').value = IDCuentaContable;
        document.getElementById('codigo_cc').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
        document.getElementById('descripcion_cc').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

        closeModal_3(); 
    }

 // Agregar evento al botón "buscar cuenta" para abrir el modal
        const openModalBtn_3 = document.getElementById("openModalBtn_3");
            openModalBtn_3.addEventListener("click", (event) => {
            event.preventDefault();

            openModal_3();
        });

        // Agregar evento al botón de cerrar para cerrar el modal
        const closeModalBtn_3 = document.getElementById("closeModalBtn_3");
            closeModalBtn_3.addEventListener("click", (event) => {
            event.preventDefault();
            closeModal_3();
        });
    
    function filterResults() {
        var input, filter, table, tr, td1, td2, i, txtValue;
        input = document.getElementById("searchInput"); // Ajusta el ID según tu campo de búsqueda
        filter = input.value.toUpperCase();
        table = document.getElementById("cuentasContablesTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
            td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)
            
            if (td1 && td2) {
                // Combina los textos de ambas posiciones en una cadena
                txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);
                
                // Busca en la cadena combinada
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    document.getElementById("searchInput").addEventListener("input", filterResults);
</script>

<script>
    // Función para abrir el modal de las cuentas contables
    function openModal_4() {
        var modalContainer = document.getElementById('modalContainer_4');
        modalContainer.style.display = 'flex';
        openModalBtn_4.style.zIndex = -1;
    }

    // Función para cerrar el modal
    function closeModal_4() {
        var modalContainer = document.getElementById('modalContainer_4');
        modalContainer.style.display = 'none';
        openModalBtn_4.style.zIndex = 1;
    }
    function selectCC2( IDCuentaContable, Codigo_CC, Descripcion_CC) {
    // Actualizar los campos de texto en la vista principal con los valores seleccionados
        document.getElementById('idcuentacontable_2').value = IDCuentaContable;
        document.getElementById('codigo_cc_2').value = Codigo_CC; // Asume que tienes un campo con id 'codigo_cc'
        document.getElementById('descripcion_cc_2').value = Descripcion_CC; // Asume que tienes un campo con id 'descripcion_cc'

        closeModal_4(); 
    }

    // Agregar evento al botón "buscar cuenta" para abrir el modal
        const openModalBtn_4 = document.getElementById("openModalBtn_4");
        openModalBtn_4.addEventListener("click", (event) => {
            event.preventDefault();

            openModal_4();
        });

        // Agregar evento al botón de cerrar para cerrar el modal
        const closeModalBtn_4 = document.getElementById("closeModalBtn_4");
        closeModalBtn_4.addEventListener("click", (event) => {
            event.preventDefault();
            closeModal_4();
        });
    
    function filterResults() {
        var input, filter, table, tr, td1, td2, i, txtValue;
        input = document.getElementById("searchInput_2"); // Ajusta el ID según tu campo de búsqueda
        filter = input.value.toUpperCase();
        table = document.getElementById("cuentasContablesTable_2");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1]; // Índice para la posición 1 (Código de Cuenta)
            td2 = tr[i].getElementsByTagName("td")[2]; // Índice para la posición 2 (Descripción de Cuenta)
            
            if (td1 && td2) {
                // Combina los textos de ambas posiciones en una cadena
                txtValue = (td1.textContent || td1.innerText) + ' ' + (td2.textContent || td2.innerText);
                
                // Busca en la cadena combinada
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    document.getElementById("searchInput_2").addEventListener("input", filterResults);
</script>


</body>
</html>