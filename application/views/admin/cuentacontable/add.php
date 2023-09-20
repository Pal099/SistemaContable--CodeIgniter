<main id="main" class="main">

  <div class="pagetitle">
      <h1> Categorias
        <small>Nuevo</small>
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/CuentaContable">Categorias</a></li>
        <li class="breadcrumb-item active">Nuevo</li>
      </ol>
    </nav>
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
                        <form action="<?php echo base_url();?>mantenimiento/CuentaContable/store" method="POST">
    <!-- Código de Cuenta Contable -->
    <div class="form-group <?php echo form_error('Codigo_CC') == true ? 'has-error':''?>">
        <label for="Codigo_CC">Código:</label>
        <input type="text" class="form-control" id="Codigo_CC" name="Codigo_CC">
        <?php echo form_error("Codigo_CC","<span class='help-block'>","</span>");?>
    </div>
    <!-- Descripción -->
    <div class="form-group <?php echo form_error('Descripcion_CC') == true ? 'has-error':''?>">
        <label for="Descripcion_CC">Descripción:</label>
        <input type="text" class="form-control" id="Descripcion_CC" name="Descripcion_CC">
        <?php echo form_error("Descripcion_CC","<span class='help-block'>","</span>");?>
    </div>
    <!-- Tipo -->
    <div class="form-group">
        <label for="tipo">Tipo:</label>
        <select class="form-control" id="tipo" name="tipo">
            <option value="Título">Título</option>
            <option value="Grupo">Grupo</option>
            <option value="Subgrupo">Subgrupo</option>
            <option value="Cuenta">Cuenta</option>
            <option value="Subcuenta">Subcuenta</option>
            <option value="Analítico 1">Analítico 1</option>
            <option value="Analítico 2">Analítico 2</option>
        </select>
    </div>
    <!-- Imputable -->
    <div class="form-group">
        <label for="imputable">Imputable:</label>
        <input type="checkbox" id="imputable" name="imputable" value="1">
    </div>
    <!-- Botones de Acción -->
    <div class="form-group">
       <div class="col-md-6">
         <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span> Guardar</button>
       </div> 
       <div class="col-md-6">
            <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable" class="btn btn-danger"><span class="fa fa-remove"></span> Cancelar</a>
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
