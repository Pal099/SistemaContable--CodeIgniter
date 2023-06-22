
<main id="main" class="main">

  <div class="pagetitle">
      <h1>
        Productos
        <small>Editar</small>
        </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/productos">Productos</a></li>
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
                        <form action="<?php echo base_url();?>mantenimiento/productos/update" method="POST">
                            <input type="hidden" value="<?php echo $producto->id;?>" name="idProducto">
                            <div class="form-group <?php echo form_error('nombre') == true ? 'has-error': '';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto->nombre?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="codigo">Codigo:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $producto->codigo?>"only read>
                            </div>
                            <div class="form-group">
                                <label for="precio_venta">precio venta:</label>
                                <input type="text" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo $producto->precio_venta?>">
                            </div>
                            <div class="form-group">
                                <label for="precio_compra">precio compra:</label>
                                <input type="text" class="form-control" id="precio_compra" name="precio_compra" value="<?php echo $producto->precio_compra?>">
                            </div>

                            <div class="form-group">

                                <label for="iva">iva:</label>
                                <input type="text" class="form-control" id="iva" name="iva" value="<?php echo $producto->iva?>">
                            </div>

                            <div class="form-group">
                                <label for="existencia">existencia:</label>
                                <input type="text" class="form-control" id="existencia" name="existencia" value="<?php echo $producto->existencia?>">
                            </div>
                            <div class="form-group">
                                <label for="stock_minimo">stock_minimo:</label>
                                <input type="text" class="form-control" id="stock_minimo" name="stock_minimo" value="<?php echo $producto->stock_minimo?>">
                            </div>
                            <div class="form-group">
                                 <div class="col-md-6">
                                    <button type="submit" class="btn btn -success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                                </div> 
                                <div class="col-md-6">
                                    <a href="<?php echo base_url(); ?>mantenimiento/productos" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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
