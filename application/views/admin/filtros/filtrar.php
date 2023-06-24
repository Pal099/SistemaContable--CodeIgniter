<main id="main" class="main">
<!-- Content Wrapper. Contains page content -->
<div class="pagetitle">
      <h1>Aquí puedes filtar por categoria o por proveedor</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        </ol>
      </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
                    <div class="col-md-12">
                            <a href="<?php echo base_url();?>filtro/seleccion/listar" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Filtrar Categoria</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio Venta</th>
                                    <th>Precio Compra</th>
                                    <th>Existencia</th>
                                    <th>Stock Minimo</th>
                                    <th>Categoria</th>
                                    <th>Proveedor</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($productos)):?>
                                    <?php foreach($productos as $Producto):?>
                                        <tr>
                                            <td><?php echo $Producto->id;?></td>
                                            <td><?php echo $Producto->codigo;?></td>
                                            <td><?php echo $Producto->nombre;?></td>
                                            <td><?php echo $Producto->precio_venta;?></td>
                                            <td><?php echo $Producto->precio_compra;?></td>
                                            <td><?php echo $Producto->existencia;?></td>
                                            <td><?php echo $Producto->stock_minimo;?></td>
                                            <td><?php echo $Producto->cate;?></td>
                                            <td><?php echo $Producto->prop;?></td>
                                            <td>
                                             <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view-productos" data-toggle="modal" data-target="#modal-default" value="<?php echo $Producto->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <a href="<?php echo base_url()?>mantenimiento/productos/edit/<?php echo $Producto->id;?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                      
                                                    <a href="<?php echo base_url();?>mantenimiento/productos/delete/<?php echo $Producto->id;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</main>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Producto</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
