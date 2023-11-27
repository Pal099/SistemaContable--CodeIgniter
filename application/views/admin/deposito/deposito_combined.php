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
                    <li class="breadcrumb-item active">Vista de los Depositos</li>
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
                            <a href="<?php echo base_url(); ?>obligaciones/Deposito_obligaciones/edit" class="btn btn-primary btn-flat"><span
                                class="fa fa-edit ms-2"></span> Modificar</a>
                            <a href=" <?php echo base_url();?>obligaciones/Deposito_obligaciones/pdfs" target= "_blank"class="btn btn-primary">Generar PDF</a>

                        </div>
                    </div>
                </div>

                <!-- Campos principales -->
                <div class="row">
                    <div class="col-md-10">
                        <table id="example1" class="table table-bordered table-hover">
                        
                            <form  action="<?php echo base_url();?>obligaciones/Deposito_obligaciones/store" method="POST">
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
                                                                <input type="text" class="form-control" id="num_asi" name="num_asi" value="<?php echo $numero_actual; ?>">
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

                                                <table class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                              <!-- acá podemos insertar una ID <th>#</th> -->  
                                                                              
                                                                                <th>Fuente</th>
                                                                                <th>Origen</th>
                                                                                <th>Cuenta Contable</th>
                                                                                <th>Comprobante</th>
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

                                                                                     <!--   <td><select class="form-control" id="id_pro" name="id_pro">
                                                                                                
                                                                                            </select></td> -->
                                                                                        <td><select class="form-control" id="id_ff" name="id_ff">
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of" name="id_of">
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="idcuentacontable" name="idcuentacontable">
                                                                                                <?php foreach ($cuentacontable as $cc): ?>
                                                                                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                                                                        <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                                                                                    </option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <!-- Los siguientes campos son ejemplos, modifícalos según tus necesidades -->
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="comprobante" name="comprobante">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="MontoPago" name="MontoPago" readonly>
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Debe" name="Debe">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber" name="Haber">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                          <!-- segundo asiento  -->
                                                                                      
                                                                                          <!-- acá podemos insertar una ID  -->

                                                                                        
                                                                                        <td><select class="form-control" id="id_ff_2" name="id_ff_2">
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of_2" name="id_of_2">
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="idcuentacontable_2" name="idcuentacontable_2">
                                                                                                <?php foreach ($cuentacontable as $cc): ?>
                                                                                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                                                                        <?php echo $cc->Codigo_CC . ' - ' . $cc->Descripcion_CC; ?>
                                                                                                    </option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <!-- Los siguientes campos son ejemplos, modifícalos según tus necesidades -->
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="comprobante_2" name="comprobante_2">
                                                                                        </td>
                                                                                        <td contenteditable="false">
                                                                                            <input type="text" class="form-control" id="MontoPago_2" name="MontoPago_2" readonly>
                                                                                        </td>
                                                                                        <td contenteditable="false">
                                                                                            <input type="text" class="form-control" id="Debe_2" name="Debe_2">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber_2" name="Haber_2">
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
                                                <a href="<?php echo base_url(); ?>obligaciones/Deposito_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </form>   
                                            
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

                


    
                function selectPrograma( nombreFuente, nombreOrigen, numeroCuenta) {
                    // Captura la tabla principal por su ID
                    var tabla = document.getElementById('tablaolilist').getElementsByTagName('tbody')[0];
                    
                    // Crea una nueva fila en la tabla
                    var fila = tabla.insertRow();

                    // Inserta celdas en la fila
                    
                    var celdaFuente = fila.insertCell(0);
                    var celdaOrigen = fila.insertCell(1);
                    var celdaCuenta = fila.insertCell(2);

                    // Asigna los valores a las celdas
                 
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
</body>
</html>