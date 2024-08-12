<main id="main" class="main">

  <div class="pagetitle">
      <h1>
        Bancos
        <small>Editar</small>
        </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/bancos">Bancos</a></li>
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
                        <form action="<?php echo base_url();?>mantenimiento/bancos/update" method="POST">

                            <input type="hidden" value="<?php echo $bancos->ban_id;?>" name="idBancos">
                             <div class="form-group">
                                <label for="ban_descri">Descripción:</label>
                                <input type="text" class="form-control" id="ban_descri" name="ban_descri" value="<?php echo $bancos->ban_descri?>">
                            </div>

                             <div class="form-group">
                                <label for="ban_agente">Agente:</label>
                                <input type="text" class="form-control" id="ban_agente" name="ban_agente" value="<?php echo $bancos->ban_agente?>">
                            </div>

                             <div class="form-group">
                                <label for="ban_telefono">Telefono:</label>
                                <input type="text" class="form-control" id="ban_telefono" name="ban_telefono" value="<?php echo $bancos->ban_telefono?>">
                            </div>

                            <div class="form-group">
                                 <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                                </div>
                                 
                                <div class="col-md-6">
                                    <a href="<?php echo base_url(); ?>mantenimiento/bancos" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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
