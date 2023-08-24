<!DOCTYPE html>
<html lang="es">
<head>
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

        /* Estilos para el contenido del modal */
        .modal-content {
            background-color: #fefefe;
            border: 1px solid #888;
            border-radius: 10px;
            padding: 20px;
            width: 50%; /* Ajusta el ancho del contenido del modal */
        }

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
2
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
                        </div>
                    </div>
                </div>

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
<div class="row">
    <div class="col-md-12">
        <table id="example1" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Programa</th>
                    <th>F.F.</th>
                    <th>O.F.</th>
                    <th>N° de cuenta</th>
                    <th>Objeto de gasto</th>
                    <th>Cta. de Proveedor</th>
                    <th>Cta. de Proveedor obs.</th>
                    <th>Comprobante</th>
                    <th>Descripcion del gasto</th>
                    <th>Debe</th>
                    <th>Haber</th>
                    <th>Item</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí podrías añadir filas con información según tus necesidades -->
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <!-- Botones "Guardar" y otros botones aquí -->
        </div>
    </div>
    </div>

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

</body>
</html>

