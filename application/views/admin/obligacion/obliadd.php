<main id="main" class="main">

  <div class="pagetitle">
      <h1> Diario de obligaciones
        <small>Nuevo</small>
      </h1>
      
  <!-- Enlace al archivo CSS style.css en la carpeta assets -->
  <link rel="stylesheet" type="text/css" href="assets/style.css">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>obligaciones/diario_obligaciones">Diario de obligaciones</a></li>
        <li class="breadcrumb-item active">Nuevo</li>
      </ol>
    </nav>
    <div class="form-group">
        <button type="button" class="btn btn-primary" id="mostrarCamposBtn">
            Campos opcionales
        </button>
    </div>
  </div><!-- End Page Title -->

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
                        <form id="formPrincipal" action="<?php echo base_url();?>obligaciones/diario_obligaciones/store" method="POST">
                            <div class="form-group <?php echo form_error('ruc') == true ? 'has-error':''?>">
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
                                <label for="observacion">Observación:</label>
                                <input type="text" class="form-control" id="observacion" name="observacion">
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="text" class="form-control" id="fecha" name="fecha">
                            </div>
                            
                            
                            <div class="form-group">
                               <div class="col-md-6">
                                 <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                               </div> 
                               <div class="col-md-6">
                                    <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                                 </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      </div>
    </section>
</main>
<form id="formPrincipal" action="<?php echo base_url();?>obligaciones/diario_obligaciones/store" method="POST">
  <!-- Resto del formulario principal y campos ocultos -->
  <!-- ... -->
  <!-- Campos ocultos para almacenar los valores de los campos opcionales -->
  <input type="hidden" id="pedi_matricula" name="pedi_matricula">
  <input type="hidden" id="modalidad" name="modalidad">
  <!-- ... otros campos ocultos para los demás campos opcionales ... -->
</form>

<!-- ... Tu código HTML anterior ... -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mostrarCamposBtn = document.getElementById('mostrarCamposBtn');
    const modal = document.getElementById('camposOpcionalesModal');
    const cerrarModal = document.getElementById('cerrarModal');
    const guardarBtn = document.getElementById('guardarBtn');
    const cancelarBtn = document.getElementById('cancelarBtn');

    mostrarCamposBtn.addEventListener('click', function() {
      modal.style.display = 'block';
    });

    cerrarModal.addEventListener('click', function() {
      modal.style.display = 'none';
    });

    guardarBtn.addEventListener('click', function() {
      // Obtener los valores de los campos opcionales
      const pedi_matricula = document.getElementById('pedi_matricula').value;
      const modalidad = document.getElementById('modalidad').value;
      // ... otros campos opcionales ...

      // Asignar los valores de los campos opcionales al formulario principal
      document.getElementById('pedi_matricula_main').value = pedi_matricula;
      document.getElementById('modalidad_main').value = modalidad;
      // ... asignar otros campos opcionales al formulario principal ...

      modal.style.display = 'none';
    });

    cancelarBtn.addEventListener('click', function() {
      modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  });
</script>

<!-- Resto del código HTML ... -->

<form id="formPrincipal" action="<?php echo base_url();?>obligaciones/diario_obligaciones/store" method="POST">
<div id="camposOpcionalesModal" class="modal">
  <div class="modal-content">
    <span class="close" id="cerrarModal">&times;</span>
    <div class="modal-body">
      <div class="form-group">
      <div class="form-group <?php echo form_error('ruc') == true ? 'has-error':''?>">
                                <label for="ruc">Ruc:</label>
                                <input type="text" class="form-control" id="ruc" name="ruc">
                                <?php echo form_error("ruc","<span class='help-block'>","</span>");?>
                            </div>
        <label for="pedi_matricula">Ped. Mat:</label>
        <input type="text" class="form-control" id="pedi_matricula" name="pedi_matricula">
      </div>
      <div class="form-group">
        <label for="modalidad">Modalidad:</label>
        <input type="text" class="form-control" id="modalidad" name="modalidad">
      </div>
      <div class="form-group">
                                <label for="tipo_presupuesto">Tipo de Presupuesto:</label>
                                <input type="text" class="form-control" id="tipo_presupuesto" name="tipo_presupuesto">
                            </div>
                            <div class="form-group">
                                <label for="unidad_respon">Unidad responsable:</label>
                                <input type="text" class="form-control" id="unidad_respon" name="unidad_respon">
                            </div>
                            <div class="form-group">
                                <label for="proyecto">Proyecto:</label>
                                <input type="text" class="form-control" id="proyecto" name="proyecto">
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <input type="text" class="form-control" id="estado" name="estado">
                            </div>
                            
                            <div class="form-group">
                                <label for="nro_pac">Nro. Pac:</label>
                                <input type="text" class="form-control" id="nro_pac" name="nro_pac">
                            </div>
                            <div class="form-group">
                                <label for="nro_exp">Nro. Exp:</label>
                                <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                            </div>
                            <div class="form-group">
                                <label for="nro_exp">Nro. Exp:</label>
                                <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                            </div>
                            <div class="form-group">
                                <label for="total">Total:</label>
                                <input type="text" class="form-control" id="total" name="total">
                            </div>
                            <div class="form-group">
                                <label for="pagado">Pagado:</label>
                                <input type="text" class="form-control" id="pagado" name="pagado">
                            </div>
      <!-- ... otros campos opcionales ... -->
      <!-- Botones de guardar y cancelar -->
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
</form>