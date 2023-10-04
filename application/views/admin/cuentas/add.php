<main id="main" class="main">

  <div class="pagetitle">
      <h1> Cuentas
        <small>Nuevo</small>
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/cuentas">Cuentas</a></li>
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
                        <form action="<?php echo base_url();?>mantenimiento/cuentas/store" method="POST">
                              <div class="form-group">
                                <label for="cta_banco">Cuenta del banco:</label>
                                <input type="text" class="form-control" id="cta_banco" name="cta_banco">
                            </div>
                              <div class="form-group">
                                <label for="cta_descri">Descripción:</label>
                                <input type="text" class="form-control" id="cta_descri" name="cta_descri">
                            </div>
                              <div class="form-group">
                                <label for="cta_moneda">Moneda:</label>
                                <input type="text" class="form-control" id="cta_moneda" name="cta_moneda">
                            </div>

                            <div class="form-group">
                                <label for="cta_numero">Numero de Cuenta:</label>
                                <input type="text" class="form-control" id="cta_numero" name="cta_numero">
                            </div>

                            <div class="form-group">
                                <label for="cta_fecini">Fecha de inicio:</label>
                                <input type="text" class="form-control" id="cta_fecini" name="cta_fecini">
                            </div>

                            <div class="form-group">
                                <label for="cta_feccie">Fecha de cierre:</label>
                                <input type="text" class="form-control" id="cta_feccie" name="cta_feccie">
                            </div>


                            <div class="form-group">
                               <div class="col-md-6">
                                 <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                               </div> 
                               <div class="col-md-6">
                                    <a href="<?php echo base_url(); ?>mantenimiento/cuentas" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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
