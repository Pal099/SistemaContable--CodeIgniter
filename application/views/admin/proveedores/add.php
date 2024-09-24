<main id="main" class="main">

  <div class="pagetitle">
      <h1> Proveedores
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/proveedores">Proveedores</a></li>
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
                        <form action="<?php echo base_url();?>mantenimiento/proveedores/store" method="POST">
                            <div class="form-group <?php echo form_error('ruc') == true ? 'has-error':''?>">
                                <label for="ruc">Ruc:</label>
                                <input type="text" class="form-control" id="ruc" name="ruc">
                                <?php echo form_error("ruc","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group <?php echo form_error('razon_social') == true ? 'has-error':''?>">
                                <label for="razon_social">Razon social:</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social">
                                <?php echo form_error("razon_social","<span class='help-block'>","</span>");?>

                            </div>
                             
                            <div class="form-group <?php echo form_error('direccion') == true ? 'has-error':''?>">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                                <?php echo form_error("direccion","<span class='help-block'>","</span>");?>

                            </div>
                            <div class="form-group <?php echo form_error('telefono') == true ? 'has-error':''?>">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                                <?php echo form_error("telefono","<span class='help-block'>","</span>");?>

                            </div>
                            <div class="form-group <?php echo form_error('email') == true ? 'has-error':''?>">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                                <?php echo form_error("email","<span class='help-block'>","</span>");?>

                            </div>
                            <div class="form-group <?php echo form_error('observacion') == true ? 'has-error':''?>">
                                <label for="observacion">Observación:</label>
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <?php echo form_error("observacion","<span class='help-block'>","</span>");?>

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
      </div>
    </section>
</main>