<main id="main" class="content">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/registro/financiamiento">Fuentes de financiamiento</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </nav>
    <div class="container-fluid bg-white border rounded-3">
        <div class="pagetitle">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <div class="col-md-6 mt-4">
                    <h1>Fuentes de financiamiento</h1>
                    <small>Editar Fuentes</small>
                </div>
            </div>
        </div>
        <hr>
        <section class="section dashboard">
            <div class="row">
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
                                    <input type="hidden" value="<?php echo $fuente->id_ff;?>" name="idFuente">

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
                </div>
            </div>
        </section>
    </div>
</main>
