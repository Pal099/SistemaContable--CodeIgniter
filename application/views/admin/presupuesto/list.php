<main id="main" class="main">
<!-- Content Wrapper. Contains page content -->
<div class="pagetitle">
      <h1>Presupuestos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>principal">Inicio</a></li>
          <li class="breadcrumb-item active">Listado Presupuesto</li>
        </ol>
      </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
                    <div class="col-md-12">
                            <a href="<?php echo base_url();?>mantenimiento/presupuesto/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar presupuesto</a>
                      

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tabla" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id </th>
                                    <th>Año</th>
                                    <th>Descripcion</th>
                                    <th>Total presupuestado</th>
                                    <th>Origen de financiamiento</th>
                                    <th>Fuente de financiamiento</th>
                                    <th>Programa</th>
                                    <th>Total modificado</th>
                                    <th>Mes</th>
                                    <th>Monto mes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($presupuestos)):?>
                                    <?php foreach($presupuestos as $presupuesto):?>
                                        <tr>
                                            <td><?php echo $presupuesto->ID_Presupuesto;?></td>
                                            <td><?php echo $presupuesto->Año;?></td>
                                            <td><?php echo $presupuesto->Descripcion;?></td>
                                            <td><?php echo $presupuesto->TotalPresupuestado;?></td>
                                            <td><?php echo $presupuesto->origen_de_financiamiento;?></td>
                                            <td><?php echo $presupuesto->fuente_de_financiamiento;?></td>
                                            <td><?php echo $presupuesto->programa_id_pro;?></td>
                                            <td><?php echo $presupuesto->TotalModificado;?></td>
                                            <td><?php echo $presupuesto->mes;?></td>
                                            <td><?php echo $presupuesto->monto_mes;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view-presupuesto" data-toggle="modal" data-target="#modal-default" value="<?php echo $presupuesto->ID_Presupuesto;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <a href="<?php echo base_url()?>mantenimiento/presupuesto/edit/<?php echo $presupuesto->ID_Presupuesto;?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                      
                                                    <a href="<?php echo base_url();?>mantenimiento/presupuesto/delete/<?php echo $presupuesto->ID_Presupuesto;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
        <h4 class="modal-title">Informacion de los presupuestos</h4>
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
