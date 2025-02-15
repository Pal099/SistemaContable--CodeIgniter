<main id="main" class="main">

  <div class="pagetitle">
      <h1> Productos
        <small>Nuevo</small>
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/productos">productos</a></li>
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
                        
                        <form action="<?php echo base_url();?>mantenimiento/productos/store" method="POST">
                            <div class="form-group <?php echo form_error('codigo') == true ? 'has-error':''?>">
                                <label for="codigo">Codigo:</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                                <?php echo form_error("codigo","<span class='help-block'>","</span>");?>
                            </div>

                            <div class="form-group <?php echo form_error('nombre') == true ? 'has-error':''?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>

                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra:</label>
                                <input type="text" class="form-control" id="precio_compra" name="precio_compra">
                            </div>

                            <div class="form-group">
                                <label for="precio_venta">Precio de venta:</label>
                                <input type="text" class="form-control" id="precio_venta" name="precio_venta">
                            </div>
                            <div class="form-group">
                                <label for="fecha_venta">Registro de venta:</label>
                                <input type="text" class="form-control" id="fecha_venta" name="fecha_venta">
                            </div>
                            <div class="form-group">
                                    <label for="iva">iva:</label>
                                    <select id="iva" class="form-select form-select-lg mb-3" name="iva">
                                    <option selected disabled>
                                            <?php echo $producto->iva?></option>
                                        <option value="0">0</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                            <?php echo $producto->iva ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">

                                    <label for="id_categoria">Categoria:</label>

                                    <select name="id_categoria" id="id_categoria" class="form-control">
                                        <?php foreach ($categorias as $Categoria): ?>

                                            <option value="<?php echo $Categoria->id ?>"><?php echo $Categoria->nombre; ?> 
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <label for="id_proveedores">Proveedor:</label>

                                <select name="id_proveedor" id="id_proveedor" class="form-control">
                                    <?php foreach ($proveedores as $proveedor): ?>

                                        <option value="<?php echo $proveedor->id ?>"><?php echo $proveedor->propietario; ?>
                                        </option>


                                    <?php endforeach; ?>

                                </select>

                        </div>

                            <div class="form-group">
                                <label for="existencia">Existencia:</label>
                                <input type="text" class="form-control" id="existencia" name="existencia">
                            </div>

                            <div class="form-group">
                                <label for="stock_minimo">Stock minimo:</label>
                                <input type="text" class="form-control" id="stock_minimo" name="stock_minimo">
                            </div>

                            <div class="form-group">
                               <div class="col-md-6">
                                 <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
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
      </div>
    </section>
</main>
