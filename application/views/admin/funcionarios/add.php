<!DOCTYPE html>
<html lang="es">

<head>
    <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">

</head>

<body>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1> Funcionario
                <small>Nuevo</small>
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo base_url(); ?>funcionario/funcionario">Funcionarios</a>
                    </li>
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
                                <?php if ($this->session->flashdata("error")): ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        <p><i class="icon fa fa-ban"></i>
                                            <?php echo $this->session->flashdata("error"); ?>
                                        </p>

                                    </div>
                                <?php endif; ?>
                                <form action="<?php echo base_url(); ?>funcionario/funcionario/store" method="POST">
                                    <div class="form-group">
                                        <label for="Unidad">Unidad:</label>
                                        <input type="text" class="form-control columna-hidden" id="id_Unidad"
                                            name="id_Unidad">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" class="form-control" id="Unidad" name="Unidad">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalContainer_unidad" class="btn btn-primary">
                                                <i class="bi bi-search"> </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Dependencia">Dependencia:</label>
                                        <input type="text" class="form-control columna-hidden" id="id_Dependencia"
                                            name="id_Dependencia">
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" class="form-control" id="Dependencia" name="Dependencia">
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalContainer_dependencia" class="btn btn-primary">
                                                <i class="bi bi-search"> </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Funcionario">Funcionario:</label>
                                        <input type="text" class="form-control" id="Funcionario" name="Funcionario">

                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-flat"><span
                                                    class="fa fa-save"></span>Guardar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="<?php echo base_url(); ?>registro/programa"
                                                class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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

        <div class="modal fade mi-modal" id="modalContainer_unidad" tabindex="-1"
            aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de Funcionarios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="TablaUnidad" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="columna-hidden"></th>
                                    <th>#</th>
                                    <th>Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unidad as $index => $unidad): ?>
                                    <tr class="list-item"
                                        onclick="selectUni('<?= $unidad->id_unidad ?>', '<?= $unidad->unidad ?>')"
                                        data-bs-dismiss="modal">
                                        <td class="columna-hidden">
                                            <?= $unidad->id_unidad ?>
                                        </td>
                                        <td>
                                            <?= $index + 1 ?>
                                        </td>
                                        <td>
                                            <?= $unidad->unidad ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <script>
            function selectUni(id_unidad, unidad) {
                document.getElementById('id_Unidad').value = id_unidad;
                document.getElementById('Unidad').value = unidad;
            }
        </script>

        <div class="modal fade mi-modal" id="modalContainer_dependencia" tabindex="-1"
            aria-labelledby="ModalCuentasContables" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de Dependencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="TablaDependencia" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="columna-hidden"></th>
                                    <th>#</th>
                                    <th>Dependencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dependencia as $index => $dependencia): ?>
                                    <tr class="list-item"
                                        onclick="selectDep('<?= $dependencia->dependencia_id ?>', '<?= $dependencia->dependencia ?>')"
                                        data-bs-dismiss="modal">
                                        <td class="columna-hidden">
                                            <?= $dependencia->dependencia_id ?>
                                        </td>
                                        <td>
                                            <?= $index + 1 ?>
                                        </td>
                                        <td>
                                            <?= $dependencia->dependencia ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function selectDep(id_dependencia, dependencia) {
                document.getElementById('id_Dependencia').value = id_dependencia;
                document.getElementById('Dependencia').value = dependencia;
            }
        </script>


        <script>
            $(document).ready(function () {
                $('#TablaUnidad').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $('#TablaDependencia').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: true,
                    searching: true,
                    info: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    }
                });
            });
        </script>

    </main>
</body>