<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>LIST CUENTAS CONTABLES</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Listado Categorias</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
        <div class="col-md-6">
            <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Cuenta Contable</a>
        </div>
        <div class="col-md-6">
            <!-- Filtro por Tipo -->
            <select class="form-control" id="filterTipo" onchange="filterByTipo(this.value)">
                <option value="">Filtrar por Tipo</option>
                <option value="Título">Título</option>
                <option value="Grupo">Grupo</option>
                <!-- ... otros tipos ... -->
            </select>
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
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Código Padre</th> <!-- Nueva columna -->
                            <th>Imputable</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cuentascontables)): ?>
                            <?php foreach ($cuentascontables as $cuentacontable): ?>
                                <tr>
                                    <td><?php echo $cuentacontable->IDCuentaContable; ?></td>
                                    <td><?php echo $cuentacontable->Codigo_CC; ?></td>
                                    <td><?php echo $cuentacontable->Descripcion_CC; ?></td>
                                    <td><?php echo $cuentacontable->tipo; ?></td>
                                    <td><?php echo $cuentacontable->padre_id ? $cuentacontable->padre_id : 'N/A'; ?></td> <!-- Mostrar el código padre -->
                                    <td><?php echo $cuentacontable->imputable == 1 ? 'Sí' : 'No'; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $cuentacontable->IDCuentaContable; ?>">
                                                <span class="fa fa-search"></span>
                                            </button>
                                            <a href="<?php echo base_url() ?>mantenimiento/CuentaContable/edit/<?php echo $cuentacontable->IDCuentaContable; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                                            <!-- Confirmación al eliminar -->
                                            <a href="#" onclick="confirmDelete(<?php echo $cuentacontable->IDCuentaContable; ?>)" class="btn btn-danger"><span class="fa fa-remove"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
</main>

<script>
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que quieres eliminar esta cuenta?")) {
            window.location.href = "<?php echo base_url(); ?>mantenimiento/CuentaContable/delete/" + id;
        }
    }

    function filterByTipo(tipo) {
        // Aquí puedes implementar el filtrado, ya sea recargando la página con el filtro aplicado o usando JavaScript para filtrar los resultados actuales.
    }
</script>
