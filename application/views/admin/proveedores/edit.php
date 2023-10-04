
<main id="main" class="main">

  <div class="pagetitle">
      <h1>
        Proveedores
        <small>Editar</small>
        </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/proveedores">Proveedores</a></li>
        <li class="breadcrumb-item active">Editar</li>
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
                        <form action="<?php echo base_url();?>mantenimiento/proveedores/update" method="POST">
                            <input type="hidden" value="<?php echo $proveedores->id;?>" name="idProveedores">
                            <div class="form-group <?php echo form_error('ruc') == true ? 'has-error': '';?>">
                                <label for="ruc">Ruc:</label>
                                <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $proveedores->ruc?>">
                                <?php echo form_error("ruc","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="razon_social">Razon Social:</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo $proveedores->razon_social?>">
                            </div>
                            <div class="form-group">
                                <label for="propietario">Propietario:</label>
                                <input type="text" class="form-control" id="propietario" name="propietario" value="<?php echo $proveedores->propietario?>">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $proveedores->direccion?>">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $proveedores->telefono?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $proveedores->email?>">
                            </div>
                            <div class="form-group">
                                <label for="observacion">Observacion:</label>
                                <input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo $proveedores->observacion?>">
                            </div>
                            <div class="form-group">
                                 <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                                </div> 
                                <div class="col-md-6">
                                    <a href="<?php echo base_url(); ?>mantenimiento/proveedores" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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
    </section>
</main>
