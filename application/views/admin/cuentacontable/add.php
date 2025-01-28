<main id="main" class="main">

  <div class="pagetitle">
      <h1> PLAN DE CUENTAS
        <small></small>
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/CuentaContable">Plan de Cuentas</a></li>
        <li class="breadcrumb-item active">Nuevo</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>

                        <!-- Formulario principal para cuentas contables -->
                        <form action="<?php echo base_url();?>mantenimiento/CuentaContable/store" method="POST">
                            
<!-- Campo para seleccionar la cuenta padre -->
<div class="form-group">
    <label for="padre_id">Padre Inmediato:</label>
    <div class="input-group">
        <input type="text" class="form-control" id="padre_id" name="padre_id" readonly>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCuentasCont2">
            Seleccionar
        </button>
    </div>
    <?php echo form_error("padre_id", "<span class='help-block'>", "</span>"); ?>
</div>

<!-- Dropdown para seleccionar el tipo -->
<div class="form-group">
    <label for="tipo">Tipo:</label>
    <select class="form-control" id="tipo" name="tipo">
        <option value="">Seleccione un tipo</option>
    </select>
    <?php echo form_error("tipo", "<span class='help-block'>", "</span>"); ?>
</div>

<!-- Modal para seleccionar la cuenta padre -->
<div class="modal fade" id="modalCuentasCont2" tabindex="-1" aria-labelledby="ModalCuentasContables" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Cuenta Padre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="TablaCuentaCont">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cuentasPadres)): ?>
    <?php foreach ($cuentasPadres as $padre): ?>
        <tr onclick="selectCuentaPadre('<?= $padre->Codigo_CC ?>', '<?= $padre->Descripcion_CC ?>', '<?= $padre->IDCuentaContable ?>',)" data-bs-dismiss="modal">
            <td><?= $padre->IDCuentaContable ?></td>
            <td><?= $padre->Codigo_CC ?></td>
            <td><?= $padre->Descripcion_CC ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="3">No hay cuentas disponibles.</td>
    </tr>
<?php endif; ?>

</tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Seleccionar cuenta padre y cargar los tipos relacionados
function selectCuentaPadre(codigoPadre) {
    document.getElementById('padre_id').value = codigoPadre;

    document.getElementById("tipo").addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];

    // Obtener el valor de data-tipo
    const nombreTipo = selectedOption.getAttribute("data-tipo");

    // Asignar el valor al campo oculto
    document.getElementById("hiddenNombreTipo").value = nombreTipo || '';


    
});




    console.log("Código Padre Seleccionado:", codigoPadre); // Verificar el valor antes de enviarlo

    $.ajax({
        url: '<?php echo base_url("mantenimiento/CuentaContable/obtenerTiposPorCodigoPadre"); ?>',
        type: 'POST',
        data: { codigoPadre: codigoPadre },
        dataType: 'json',
        success: function (response) {
            console.log("Respuesta del Servidor:", response); // Verificar la respuesta del servidor

            const tipoDropdown = $('#tipo'); // Seleccionar el dropdown
            tipoDropdown.empty(); // Limpiar las opciones actuales

            if (response.length > 0) {
    tipoDropdown.append('<option value="">Seleccione un tipo</option>');
    response.forEach(function (tipo) {
        // Agregar data-tipo con el valor del tipo
        tipoDropdown.append(`
            <option value="${tipo.codigo}" data-id-padre="${tipo.id_padre}" data-tipo="${tipo.tipo}">
                ${tipo.descripcion} - (${tipo.tipo})
            </option>
        `);
    });
} else {
                tipoDropdown.append('<option value="">No hay tipos disponibles</option>');
            }
        },
        error: function () {
            alert('Error al cargar los tipos. Intente nuevamente.');
        }
    });

    // Actualizar los campos "codigo_nuevo" y "id_padre" al seleccionar un tipo
    $('#tipo').off('change').on('change', function () {
        const codigoSeleccionado = $(this).val(); // Valor seleccionado
        const idPadreSeleccionado = $('#tipo option:selected').data('id-padre'); // Obtener data-id-padre de la opción seleccionada

        $('#codigo_nuevo').val(codigoSeleccionado); // Actualizar campo "codigo_nuevo"
        $('#id_padre').val(idPadreSeleccionado); // Actualizar campo "id_padre"
    });
}
</script>


<div class="form-group">
    <label for="codigo_nuevo">Código Nuevo:</label>
    <input type="text" class="form-control" id="codigo_nuevo" name="codigo_nuevo" />
</div>

<div class="form-group">
    <label for="descri_nueva">Descripcion Nueva Cuenta:</label>
    <input type="text" class="form-control" id="descri_nueva" name="descri_nueva" />
</div>

<div class="form-group">
    <label for="id_padre">id_padre:</label>
    <input type="text" class="form-control" id="id_padre" name="id_padre" />
</div>

<input  id="hiddenNombreTipo" name="nombreTipo">
<input  id="hiddenidcuentacontable" name="IDCuentaContable">


                            
                            <!-- Imputable -->
                            <div class="form-group">
                                <label for="imputable">Asentable:</label>
                                <input type="checkbox" id="imputable" name="imputable" value="1">
                                <label for="imputable">Sí</label>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span> Guardar</button>
                                <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable" class="btn btn-danger"><span class="fa fa-remove"></span> Cancelar</a>
                            </div>
                        </form>
<!--                          
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
