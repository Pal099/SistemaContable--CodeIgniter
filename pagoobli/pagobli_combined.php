<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Agrega estos enlaces en el <head> de tu documento HTML -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../assets/css/paginastyle.css">

</head>

<body>
    <main id="main" class="content">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-container">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="bi bi-house breadcrumb-item"><a href="<?php echo base_url(); ?>"> Inicio</a></li>
                        <li class="breadcrumb-item active">Vista del Pago de Obligaciones</li>
                    </ol>
                </nav>
                <h1>Pago de Obligaciones</h1>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <!-- Left side columns -->
                    <div class="row">
                        <div class="col-md-9 d-flex align-items-center">
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
                        <div class="col-md-10">
                            <table id="example1" class="table table-bordered table-hover">
                                <form action="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/store"
                                    method="POST">
                                    <div class="main-fields">
                                        <?php $fields = ["ruc", "numero", "contabilidad", "direccion", "telefono", "tesoreria", "observacion", "fecha"]; ?>
                                        <?php foreach ($fields as $field): ?>
                                            <div class="form-group">
                                                <label for="<?= $field; ?>">
                                                    <?= ucfirst($field); ?>:
                                                </label>
                                                <input type="text" class="form-control" id="<?= $field; ?>"
                                                    name="<?= $field; ?>">
                                                <?php echo form_error($field, "<span class='help-block'>", "</span>"); ?>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Primer asiento de la obligación -->
                                        <div class="form-group">
                                            <label for="cuentacontable">Código y Descripción de Cuenta Contable:</label>
                                            <select class="form-control" id="cuentacontable" name="cuentacontable">
                                                <?php foreach ($cuentacontable as $cc): ?>
                                                    <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                        <?php echo $cc->CodigoCuentaContable . ' - ' . $cc->DescripcionCuentaContable; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <?php $asientoFields = ["MontoPago", "Debe", "Haber", "comprobante", "id_of", "id_pro", "id_ff", "cheques_che_id"]; ?>
                                        <?php foreach ($asientoFields as $field): ?>
                                            <div class="form-group">
                                                <label for="<?= $field; ?>">
                                                    <?= ucfirst($field); ?>:
                                                </label>
                                                <input type="text" class="form-control" id="<?= $field; ?>"
                                                    name="<?= $field; ?>">
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                    <!-- boton -->
                                    <br>
                                    <div class="form-group">
                                        <label for="toggleButton">Segunda Asiento</label>
                                        <button type="button" id="toggleButton" class="btn btn-primary">Mostrar</button>
                                    </div>

                                    <!-- segunda campo -->
                                    <div class="main-fields">
                                        <div class="asiento-fields hidden">
                                            <div class="form-group">
                                                <label for="cuentacontable">Código y Descripción de Cuenta
                                                    Contable:</label>
                                                <select class="form-control" id="cuentacontable" name="cuentacontable">
                                                    <?php foreach ($cuentacontable as $cc): ?>
                                                        <option value="<?php echo $cc->IDCuentaContable; ?>">
                                                            <?php echo $cc->CodigoCuentaContable . ' - ' . $cc->DescripcionCuentaContable; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <?php $asientoFields = ["MontoPago", "Debe", "Haber", "comprobante", "id_of", "id_pro", "id_ff", "cheques_che_id"]; ?>
                                            <?php foreach ($asientoFields as $field): ?>
                                                <div class="form-group">
                                                    <label for="<?= $field; ?>">
                                                        <?= ucfirst($field); ?>:
                                                    </label>
                                                    <input type="text" class="form-control" id="<?= $field; ?>"
                                                        name="<?= $field; ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <!-- Campos opcionales -->
                                    <div class="row optional-fields">
                                        <div class="col-md-12">
                                            <?php $optionalFields = ["pedi_matricula", "modalidad", "tipo_presupuesto", "unidad_respon", "proyecto", "estado", "nro_pac", "nro_exp", "total", "pagado"]; ?>
                                            <div class="form-group">
                                                <div class="row">
                                                    <?php foreach ($optionalFields as $field): ?>
                                                        <div class="col-md-6">
                                                            <label for="<?= $field; ?>">
                                                                <?= ucfirst($field); ?>:
                                                            </label>
                                                            <input type="text" class="form-control" id="<?= $field; ?>"
                                                                name="<?= $field; ?>">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-success btn-flat"><span
                                                            class="fa fa-save"></span> Guardar</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones"
                                                        class="btn btn-danger"><span class="fa fa-remove"></span>
                                                        Cancelar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </form>


                                <script>
                                    document.getElementById('toggleButton').addEventListener('click', function () {
                                        const asientoFields = document.querySelector('.asiento-fields');
                                        asientoFields.classList.toggle('hidden');
                                    });
                                </script>


                                
                                <thead class="scroll-container">
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
                                                <td>
                                                    <?php echo $item->id; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->ruc; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->numero; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->contabilidad; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->direccion; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->telefono; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->observacion; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->fecha; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->tesoreria; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->pedi_matricula; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->modalidad; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->tipo_presupuesto; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->unidad_respon; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->proyecto; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->estado; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->nro_pac; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->nro_exp; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->total; ?>
                                                </td>
                                                <td>
                                                    <?php echo $item->pagado; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-view-Diario_obligaciones"
                                                            data-toggle="modal" data-target="#modal-default"
                                                            value="<?php echo $data->id; ?>">
                                                            <span class="fa fa-search"></span>
                                                        </button>
                                                        <a href="<?php echo base_url() ?>mantenimiento/Diario_obligaciones/edit/<?php echo $data->id; ?>"
                                                            class="btn btn-warning"><span class="fa fa-pencil"></span></a>

                                                        <a href="<?php echo base_url(); ?>mantenimiento/Diario_obligaciones/delete/<?php echo $data->id; ?>"
                                                            class="btn btn-danger btn-remove"><span
                                                                class="fa fa-remove"></span></a>
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
                        <tr class="list-item"
                            onclick="selectProveedor('<?= $proveedor->ruc ?>', '<?= $proveedor->razon_social ?>', '<?= $proveedor->direccion ?>')">
                            <td>
                                <?= $index + 1 ?>
                            </td>
                            <td>
                                <?= $proveedor->ruc ?>
                            </td>
                            <td>
                                <?= $proveedor->razon_social ?>
                            </td>
                            <td>
                                <?= $proveedor->direccion ?>
                            </td>
                            <td>
                                <?= $proveedor->telefono ?>
                            </td>
                            <td>
                                <?= $proveedor->email ?>
                            </td>
                            <td>
                                <?= $proveedor->observacion ?>
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

    </script>


    <script>
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
    </script>





    <script>
        // Función para abrir el modal
        function openModal() {
            var modalContainer = document.getElementById('modalContainer');
            modalContainer.style.display = 'flex';
        }

        // Función para cerrar el modal
        function closeModal() {
            var modalContainer = document.getElementById('modalContainer');
            modalContainer.style.display = 'none';
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
    </script>


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
        fechaInput.value = obtenerFechaActual();
    </script>





    <script>
        // Función para abrir el modal de programas
        function openModal_obli() {
            var modalContainer = document.getElementById('modalContainer_obli');
            modalContainer.style.display = 'flex';
        }

        // Función para cerrar el modal de programas
        function closeModal_obli() {
            var modalContainer = document.getElementById('modalContainer_obli');
            modalContainer.style.display = 'none';
        }



        // Agregar evento al botón "Seleccionar Datos" para abrir el modal de programas
        const openModalBtn_obli = document.getElementById("openModalBtn_obli");
        openModalBtn_obli.addEventListener("click", () => {
            openModal_obli();
        });

        // Agregar evento al botón de cerrar para cerrar el modal de programas
        const closeModalBtn_obli = document.getElementById("closeModalBtn_obli");
        closeModalBtn_obli.addEventListener("click", () => {
            closeModal_obli();
        });
    </script>
</body>

</html>