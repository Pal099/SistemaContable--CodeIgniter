
<main id="main" class="main">

  <div class="pagetitle">
      <h1>
        Fuentes de financiamiento
        <small>Editar Fuentes</small>
        </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>registro/financiamiento">Fuentes de financiamiento</a></li>
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

                        <form action="<?php echo base_url();?>registro/financiamiento/update" method="POST">
                            <input type="hidden" value="<?php echo $fuente->id;?>" name="idFuente">

                            <div class="form-group">

                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fuente->nombre?>">
                          
                            </div>

                            <div class="form-group <?php echo form_error('codigo') == true ? 'has-error': '';?>">

                                <label for="codigo">Codigo:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $fuente->codigo?>">
                                <?php echo form_error("codigo","<span class='help-block'>","</span>");?>

                            </div>
                            <div class="form-group">

                                 <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                                </div> 

                                <div class="col-md-6">
                            
                                <a href="<?php echo base_url(); ?>registro/financiamiento" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
                            
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
