<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="<?php echo base_url(); ?>assets/css/style_pago_obli.css" rel="stylesheet">

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

</head>

<body>
    <main id="main" class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-container">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Vista del Pago de obligaciones</li>
                    </ol>
                </nav>
                <h1>Pago de Obligaciones</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center">
                            <h1 style="color: #030E50; font-size: 20px; margin-right: auto;">Datos del asiento</h1>
                            <div class="btn-group">
                                
                                <!-- Botón "Nuevo" para abrir el modal -->
                                <button class="btn btn-sm btn-primary ms-2" title="Nuevo" id="openModalBtn">
                                    <i class="bi bi-plus"></i> Nuevo
                                </button>
                                <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/edit"
                                    class="btn btn-primary btn-flat"><span class="fa fa-edit ms-2"></span> Modificar</a>

                                <button class="btn btn-sm btn-danger ms-2" title="Eliminar">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                                <a href=" <?php echo base_url(); ?>obligaciones/Pago_de_obligaciones/pdfs"
                                    target="_blank" class="btn btn-primary">Generar PDF</a>

                            </div>
                        </div>
                    </div>

                    <!-- Campos principales -->
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example1" class="table table-bordered table-hover">

                                <form id="formularioPrincipal">
                                    <div class="content3">
                                        <div class="content-container3">
                                            <div class="main-fields">
                                                <div
                                                    class="form-group <?php echo form_error('ruc') == true ? 'has-error' : '' ?>">
                                                    <label for="ruc">Ruc:</label>
                                                    <input type="text" class="form-control" id="ruc" name="ruc">
                                                    <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
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
                                                    <label for="op">N° Op</label>
                                                    <input type="text" class="form-control" id="op" name="op" value="<?php echo $op_actual; ?>" readonly>
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label for="num_asi">Numero:</label>
                                                    <input type="text" class="form-control" id="num_asi" name="num_asi" value="<?php echo $numero_siguiente; ?> " readonly>
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
                                    <table class="table table-bordered table-striped" id="miTabla">
                                                                        <thead>
                                                                            <tr>
                                                                              <!-- acá podemos insertar una ID <th>#</th> -->  
                                                                                <th>Programa</th>
                                                                                <th>Fuente</th>
                                                                                <th>Origen</th>
                                                                                <th>Cuenta Contable</th>
                                                                                <th>Comprobante</th>
                                                                                <th>Detalles</th>
                                                                                <th>Monto de Pago</th>
                                                                                <th>Debe</th>
                                                                                <th>Haber</th>
                                                                                <th>Cheque</th>
                                                                                <th><button id="agregarFila">Agregar Fila</button></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                                    <tr>
                                                                                        <!-- acá podemos insertar una ID  -->
                                                                                          <!-- acá podemos insertar una ID  -->

                                                                                        <td><select class="form-control" id="id_pro" name="id_pro">
                                                                                                <?php foreach ($programa as $prog): ?>
                                                                                                    <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_ff" name="id_ff">
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of" name="id_of">
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </td>
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
                                                                                            <input type="text" class="form-control" id="Debe" name="Debe">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber" name="Haber">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="cheques_che_id" name="cheques_che_id">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr id="filaBase">
                                                                                          <!-- segundo asiento  -->
                                                                                      
                                                                                          <!-- acá podemos insertar una ID  -->

                                                                                        <td><select class="form-control" id="id_pro_2" name="id_pro_2">
                                                                                                <?php foreach ($programa as $prog): ?>
                                                                                                    <option value="<?php echo $prog->id_pro; ?>"><?php echo $prog->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_ff_2" name="id_ff_2">
                                                                                                <?php foreach ($fuente_de_financiamiento as $ff): ?>
                                                                                                    <option value="<?php echo $ff->id_ff; ?>"><?php echo $ff->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select></td>
                                                                                        <td><select class="form-control" id="id_of_2" name="id_of_2">
                                                                                                <?php foreach ($origen_de_financiamiento as $of): ?>
                                                                                                    <option value="<?php echo $of->id_of; ?>"><?php echo $of->nombre; ?></option>
                                                                                                <?php endforeach; ?>
                                                                                            </select>
                                                                                        </td>
                                                                                     
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
                                                                                            <input type="text" class="form-control" id="Debe_2" name="Debe_2">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="Haber_2" name="Haber_2">
                                                                                        </td>
                                                                                        <td contenteditable="true">
                                                                                            <input type="text" class="form-control" id="cheques_che_id_2" name="cheques_che_id_2">
                                                                                        </td>
                                                                                        <td>
                                                                                            <button class="eliminarFila">Eliminar</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                    
                                                                        </tbody>
                                                                    </table>
                                                
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-flat" id="guardarFilas"><span
                                class="fa fa-save"></span>Guardar</button>
                        <div class="notification" id="notification">
                            <div class="icon">
                            </div>
                            <div class="message">Guardado Correctamente</div>
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <a href="<?php echo base_url(); ?>obligaciones/Pago_de_obligaciones" class="btn btn-danger"><span
                            class="fa fa-remove"></span>Cancelar</a>
                </div>
            </div>
     </div>
    </div>
</form>

                        
        </table>
    </main>
    <!-- Contenedor del modal -->
    <div class="modal-container2" id="modalContainer_2">
        <div class="modal-content2">
            <span class="close_2" id="closeModalBtn_2" onclick="closeModal_2()">&times;</span>
            <h3>Lista de Obligaciones</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ruc</th>
                        <th>Razon Social</th>
                        <th>Numero</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Monto Pagado</th>
                        <th>Monto de Pago</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Codigo y Descripción CC</th>
                        <th>Origen de Financiamiento</th>
                        <th>Programa</th>
                        <th>Fuente de Financiamiento</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asientos as $asiento => $asi): ?>
                        <?php if (($asi->id_form == 1 && $asi->Debe > 0) && ($asi->pagado < $asi->total)): ?>
                            <tr class="list-item" onclick="selectAsi('<?= $asi->ruc_proveedor ?>', '<?= $asi->razso_proveedor ?>', '<?= $asi->numero ?>', '<?= $asi->fecha ?>',
                                      '<?= $asi->MontoPago ?>','<?= $asi->Debe ?>', '<?= $asi->Haber ?>', '<?= $asi->id_ff ?>', '<?= $asi->id_pro ?>', '<?= $asi->id_of ?>'
                                      ,'<?= $asi->IDCuentaContable ?>',  <?= $asi->IDCuentaContable ?>)">
                                <td>
                                    <?= $asiento + 1 ?>
                                </td>
                                <td>
                                    <?= $asi->ruc_proveedor ?>
                                </td>
                                <td>
                                    <?= $asi->razso_proveedor ?>
                                </td>
                                <td>
                                    <?= $asi->numero ?>
                                </td>
                                <td>
                                    <?= $asi->fecha ?>
                                </td>
                                <td>
                                    <?= $asi->total ?>
                                </td>
                                <td>
                                    <?= $asi->pagado ?>
                                </td>
                                <td>
                                    <?= $asi->MontoPago ?>
                                </td>
                                <td>
                                    <?= $asi->Debe ?>
                                </td>
                                <td>
                                    <?= $asi->Haber ?>
                                </td>
                                <td>
                                    <?= $asi->codigo ?> -
                                    <?= $asi->descrip ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_fuente ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_programa ?>
                                </td>
                                <td>
                                    <?= $asi->nombre_origen ?>
                                </td>

                            </tr>
                        <?php endif; ?>
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
        // Función para abrir el modal
        function openModal_2() {
            var modalContainer = document.getElementById('modalContainer_2');
            modalContainer.style.display = 'flex';
            openModalBtn.style.zIndex = -1;
        }

        // Función para cerrar el modal
        function closeModal_2() {
            var modalContainer = document.getElementById('modalContainer_2');
            modalContainer.style.display = 'none';
            openModalBtn.style.zIndex = 1;
        }

        // Función para seleccionar un asi
        function selectAsi(ruc, razonSocial, numeros, fechas, montos, debes, habers, fuentes, programas, origens, cuentas, descrip, codigoDescrip) {
            // Actualizar los campos de texto en la vista principal
            
            document.getElementById('ruc').value = ruc;
            document.getElementById('contabilidad').value = razonSocial;
            document.getElementById('tesoreria').value = razonSocial;
            document.getElementById('fecha').value = fechas;
            document.getElementById('num_asi').value = numeros;
            document.getElementById('Debe').value = debes;
            document.getElementById('Haber').value = habers;
            document.getElementById('MontoPago').value = montos;
            document.getElementById('id_ff').value = fuentes;
            document.getElementById('id_pro').value = programas;
            document.getElementById('id_of').value = origens;
            document.getElementById('IDCuentaContable').value = cuentas;
            document.getElementById('IDCuentaContable').value = descrip;


            closeModal_2(); // Cierra el modal después de seleccionar un proveedor
        }

        // Agregar evento al botón "Nuevo" para abrir el modal
        const openModalBtn_2 = document.getElementById("openModalBtn");
        openModalBtn_2.addEventListener("click", () => {
            openModal_2();
        });

        // Agregar evento al botón de cerrar para cerrar el modal
        const closeModalBtn_2 = document.getElementById("closeModalBtn_2");
        closeModalBtn_2.addEventListener("click", () => {
            closeModal_2();
        });

    </script>

    <script>
        // Obtener la fecha actual en el formato deseado (yyyy-mm-dd)
        function obtenerFechaActual() {
            const fecha = new Date();
            const dia = fecha.getDate().toString().padStart(2, '0');
            const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
            const año = fecha.getFullYear();
            return `${dia}-${mes}-${año}`;
        }

        // Preestablecer el campo de fecha con la fecha actual
        const fechaInput = document.getElementById('fecha');
        //fechaInput.value = obtenerFechaActual();
    </script>

   
<script>
    $(document).ready(function () {

        // Agregar fila
        $("#agregarFila").on("click", function (e) {
            e.preventDefault();
            var nuevaFila = $("#filaBase").clone();

            // Remove the ID to avoid duplicates
            nuevaFila.removeAttr('id');

            // Agregar una clase a todos los elementos de la fila clonada
            nuevaFila.find("select, input").addClass("filaClonada");

            // Clear values of the fields in the new row
            nuevaFila.find("select, input").val("");

            // Show the new row
            nuevaFila.show();

            // Append the new row to the table body
            $("#miTabla tbody").append(nuevaFila);
        });

        // Eliminar fila
        $("#miTabla").on("click", ".eliminarFila", function (e) {
            e.preventDefault();
            if ($("#miTabla tbody tr").length > 2) {
            $(this).closest("tr").remove();
            } else {
            alert("No se puede eliminar la última fila.");
            }
        });
        
        
        
    });
</script>

<script>
    
    $("#formularioPrincipal").on("submit", function() {
        //datos que no son de la tabla dinamica
        var datosFormulario = {
        
            op: $("#op").val(),
            ruc: $("#ruc").val(),
            num_asi: $("#num_asi").val(),
            detalles: $("#detalles").val(),
            contabilidad: $("#contabilidad").val(),
            direccion: $("#direccion").val(),
            telefono: $("#telefono").val(),
            tesoreria: $("#tesoreria").val(),
            observacion: $("#observacion").val(),
            fecha: $("#fecha").val(),

            // Agrega más campos según sea necesario
            id_pro: $("#id_pro").val(),
            id_ff: $("#id_ff").val(),
            id_of: $("#id_of").val(),
            IDCuentaContable: $("#idcuentacontable").val(),
            comprobante: $("#comprobante").val(),
            Debe: $("#Debe").val(),
            Haber: $("#Haber").val(),
            cheques_che_id: $("#cheques_che_id").val(),

        };
  
        // variable para saber si el debe es igual a haber
        let sumahaber = 0;
       
        var filas = [];
        

        $("#miTabla tbody tr:gt(0)").each(function () {
            var fila = {
                id_pro: $(this).find("select[name='id_pro_2']").val(),
                id_ff: $(this).find("select[name='id_ff_2']").val(),
                id_of: $(this).find("select[name='id_of_2']").val(),
                IDCuentaContable: $(this).find("input[name='idcuentacontable_2']").val(),
                detalles: $(this).find("input[name='detalles_2']").val(),
                comprobante: $(this).find("input[name='comprobante_2']").val(),
                Debe: $(this).find("input[name='Debe_2']").val(),
                Haber: $(this).find("input[name='Haber_2']").val(),
                cheques_che_id: $(this).find("input[name='cheques_che_id_2']").val(),
            };
            // Sumar los valores de "Haber" en cada fila clonada desde la segunda en adelante
            var valorClonado = parseFloat($(this).find("[name='Haber_2']").val()) || 0;
            sumahaber += valorClonado;
            filas.push(fila);
        });
     
        // Combinar datos del formulario principal y de las filas dinámicas
        var datosCompletos = {
            datosFormulario: datosFormulario,
            filas: filas,
        };
        
        if(Math.abs(sumahaber - datosFormulario.Debe) < 0.0001){
            $.ajax({
                url: '<?php echo base_url("obligaciones/Pago_de_obligaciones/store"); ?>',
                type: 'POST',
                data: {  datos: datosCompletos },
                //dataType: 'json',  // Esperamos una respuesta JSON del servidor
                success: function(response) {
                    alert(filas);
                    console.log(response);
                    if (response.includes('Datos guardados exitosamente.')) {
                        alert('Datos guardados exitosamente.');
                        // ... (código adicional si es necesario)
                    } else {
                        alert('Error al guardar los datos: ' + response);
                        // ... (código adicional si es necesario)
                    }
                },
                error: function(xhr, status, error) {
                    
                    console.log(xhr.responseText); // Agrega esta línea para ver la respuesta del servidor
                    console.log(datosCompletos);
                    alert("Error en la solicitud AJAX: " + status + " - " + error);
                    
                }
            });
        }else{
            alert('El debe y el haber son diferentes');
            return false;
        }
        
    });
</script>

<script>
    // Función para abrir el modal de las cuentas contables
    function openModal_3() {
        var modalContainer = document.getElementById('modalContainer_3');
        modalContainer.style.display = 'flex';
        modalContainer.style.top = '30%';

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
        modalContainer.style.top = '30%';

        openModalBtn_4.style.zIndex = -1;
    }

        // Función para cerrar el modal
        function closeModal_4() {
            var modalContainer = document.getElementById('modalContainer_4');
            modalContainer.style.display = 'none';
            openModalBtn_4.style.zIndex = 1;
        }

        function selectCC2(IDCuentaContable, Codigo_CC, Descripcion_CC) {
            // Obtener la fila actual dinámica
            var currentDynamicRow = $("#miTabla tbody tr:last");

            // Actualizar los campos de texto en la vista principal con los valores seleccionados
            currentDynamicRow.find('#idcuentacontable_2').val(IDCuentaContable);
            currentDynamicRow.find('#codigo_cc_2').val(Codigo_CC);
            currentDynamicRow.find('#descripcion_cc_2').val(Descripcion_CC);

            closeModal_4();
        }

        // Abrir modal en fila dinamica
        const openModalBtn_4 = document.getElementById("openModalBtn_4");
        // To this (using event delegation)
        document.getElementById("miTabla").addEventListener("click", function(event) {
            if (event.target && event.target.id === "openModalBtn_4") {
                event.preventDefault();
                
                openModal_4();
            }
        });
        
        // Cerrar modal en fila dinamica
        const closeModalBtn_4 = document.getElementById("closeModalBtn_4");
        // To this (using event delegation)
        document.getElementById("miTabla").addEventListener("click", function(event) {
            if (event.target && event.target.id === "closeModalBtn_4") {
                event.preventDefault();
                closeModal_4();
            }
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