<head>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <style>
    /* Estilo para el thead de DataTables */
    #example1 thead {
      background-color: #e6f7fe; /* Cambia esto al color que desees */
      color: white; /* Cambia esto al color del texto que desees */
    }
  </style>
</head>
<main id="main" class="main">
<!-- Content Wrapper. Contains page content -->
<div class="pagetitle">
      <h1>Bancos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
          <li class="breadcrumb-item active">Listado de Bancos</li>
        </ol>
      </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
                    <div class="col-md-12">
                            <a href="<?php echo base_url();?>mantenimiento/bancos/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Banco</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Agente</th>
                                    <th>Teléfono</th>
                                     <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($bancos)):?>
                                    <?php foreach($bancos as $banco):?>
                                        <tr>
                                             <td><?php echo $banco->ban_id;?></td>
                                            <td><?php echo $banco->ban_descri;?></td>
                                            <td><?php echo $banco->ban_agente;?></td>
                                            <td><?php echo $banco->ban_telefono;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view-banco" data-toggle="modal" data-target="#modal-default" value="<?php echo $banco->ban_id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <a href="<?php echo base_url()?>mantenimiento/bancos/edit/<?php echo $banco->ban_id;?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                      
                                                    <a href="<?php echo base_url();?>mantenimiento/bancos/delete/<?php echo $banco->ban_id;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
        <h4 class="modal-title">Informacion de los Bancos</h4>
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

<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    });
</script>