<!DOCTYPE html>
<html lang="es">

<head>
  <link href="<?php echo base_url(); ?>/assets/css/style_diario_obli.css" rel="stylesheet" type="text/css">
  <!-- Estilos de DataTable de jquery -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">

</head>

<body>
  <main id="main" class="content">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
        <li class="breadcrumb-item">Recepcion de Bienes</li>
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/recepcion_bienes">Listado
            Recepcion de Bienes</a></li>
        <li class="breadcrumb-item">Agregar Recepcion de Bienes</li>
      </ol>
    </nav>
    <div class="container-fluid bg-white border rounded-3">
      <div class="pagetitle">
        <div class="container-fluid d-flex flex-row justify-content-between">
          <div class="col-md-6 mt-4">
            <h1>Agregar Recepcion de Bienes</h1>
          </div>
          <div class="col-md-6 mt-4">
            <div class="d-flex justify-content-md-end">
              <div class="form-check form-switch mt-2 " style="font-size: 17px;">

              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="seccion_agregar_presupuesto">
        <div class="container-fluid">
          <div class="row">
            <form action="<?php echo base_url(); ?>patrimonio/Recepcion_Bienes/store" method="POST">
              <div class="container-fluid mt-2">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <div class="card border">
                      <div class="card-body">
                        <div class="row g-3 align-items-center mt-2">

                          <div class="form-group col-md-4">
                            <label for="nro">Nro. de Orden:</label>
                            <input type="number" class="form-control" id="nro" name="nro" value="" required>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="Unidad">Unidad:</label>
                            <input type="text" class="form-control columna-hidden" id="id_Unidad" name="id_Unidad">
                            <div style="display: flex; align-items: center;">
                              <input type="text" class="form-control" id="Unidad" name="Unidad">
                              <button type="button" data-bs-toggle="modal" data-bs-target="#modalContainer_unidad"
                                class="btn btn-primary">
                                <i class="bi bi-search"> </i>
                              </button>
                            </div>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="Proveedor">Proveedor:</label>
                            <input type="text" class="form-control columna-hidden" id="id_Proveedor"
                              name="id_Proveedor">
                            <div style="display: flex; align-items: center;">
                              <input type="text" class="form-control" id="Proveedor" name="Proveedor">
                              <button type="button" data-bs-toggle="modal" data-bs-target="#modalContainer_proveedores"
                                class="btn btn-primary">
                                <i class="bi bi-search"> </i>
                              </button>
                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Ej. YYYY/MM/DD"
                              required>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="plazo">Plazo</label>
                            <input type="date" class="form-control" id="plazo" name="plazo" placeholder="Ej. YYYY/MM/DD"
                              required>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="Dependencia">Dependencia:</label>
                            <input type="text" class="form-control columna-hidden" id="id_Dependencia"
                              name="id_Dependencia">
                            <div style="display: flex; align-items: center;">
                              <input type="text" class="form-control" id="Dependencia" name="Dependencia">
                              <button type="button" data-bs-toggle="modal" data-bs-target="#modalContainer_dependencia"
                                class="btn btn-primary">
                                <i class="bi bi-search"> </i>
                              </button>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="Funcionario">Funcionario:</label>
                            <input type="text" class="form-control columna-hidden" id="id_Funcionario"
                              name="id_Funcionario">
                            <div style="display: flex; align-items: center;">
                              <input type="text" class="form-control" id="Funcionario" name="Funcionario">
                              <button type="button" data-bs-toggle="modal" data-bs-target="#modalContainer_funcionario"
                                class="btn btn-primary">
                                <i class="bi bi-search"> </i>
                              </button>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="concepto">Observacion:</label>
                            <input type="text" class="form-control" id="observacion" name="observacion" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <section class="seccion_tabla">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="container-fluid mt-2">
                        <div class="row justify-content-center">
                          <div class="col-md-12">
                            <div class="card border">
                              <div class="card-body mt-4">
                                <div class="table-responsive">
                                  <table class="table table-bordered" id="tablaItems">
                                    <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Concepto</th>
                                        <th>Obl.</th>
                                        <th>Str</th>
                                        <th>O.P.</th>
                                        <th>Monto</th>
                                        <th>Buscar</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbodyItems">
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent"
                                            id="idcomprobante" name="idcomprobante" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="date" class="form-control border-0 bg-transparent" id="fechaT"
                                            name="fechaT" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent" id="concepto"
                                            name="concepto" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent" id="obl"
                                            name="obl" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent" id="str"
                                            name="str" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent" id="op"
                                            name="op" readonly>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="input-group input-group-sm align-items-center  ">
                                          <input type="text" class="form-control border-0 bg-transparent" id="monto"
                                            name="monto">
                                        </div>
                                      </td>
                                      <td>
                                        <button id="actualizarTablaBoton" type="button" data-bs-toggle="modal"
                                          data-bs-target="#modalComprobantes" class="btn btn-primary">
                                          <i class="bi bi-search"> </i>
                                        </button>
                                      </td>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <div class="container-fluid mt-3 mb-3">
                  <div class="col-md-12 d-flex flex-row justify-content-center">
                    <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span
                        class="fa fa-save"></span>Guardar</button>
                    <button class="btn btn-danger ml-3"
                      onclick="window.location.href='<?php echo base_url(); ?>patrimonio/comprobante_gasto'">
                      <i class="fa fa-remove"></i> Cancelar
                    </button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </section>
    </div>

    <!-- Modal Proveedores con boostrap -->
    <div class="modal fade mi-modal" id="modalContainer_proveedores" tabindex="-1"
      aria-labelledby="ModalCuentasContables" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lista de Proveedores</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table id="TablaProveedores" class="table table-hover table-sm">
              <thead>
                <tr>
                  <th class="columna-hidden"></th>
                  <th>#</th>
                  <th>Ruc</th>
                  <th>Razón Social</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Observación</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($proveedores as $index => $proveedor): ?>
                  <tr class="list-item"
                    onclick="selectProveedor('<?= $proveedor->id ?>', '<?= $proveedor->razon_social ?>')"
                    data-bs-dismiss="modal">
                    <td class="columna-hidden">
                      <?= $proveedor->id ?>
                    </td>
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <?= $proveedor->ruc ?>
                    </td>
                    <td>
                      <?= $proveedor->razon_social ?>
                    </td>
                    <td>
                      <?= $proveedor->direccion ?>
                    </td>
                    <td>
                      <?= $proveedor->telefono ?>
                    </td>
                    <td>
                      <?= $proveedor->email ?>
                    </td>
                    <td>
                      <?= $proveedor->observacion ?>
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
      function selectProveedor(id_proveedor, razonSocial) {
        document.getElementById('id_Proveedor').value = id_proveedor;
        document.getElementById('Proveedor').value = razonSocial;

      }
    </script>

    <div class="modal fade mi-modal" id="modalContainer_unidad" tabindex="-1" aria-labelledby="ModalCuentasContables"
      aria-hidden="true">
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
                  <tr class="list-item" onclick="selectUni('<?= $unidad->id_unidad ?>', '<?= $unidad->unidad ?>')"
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

    <div class="modal fade mi-modal" id="modalContainer_funcionario" tabindex="-1"
      aria-labelledby="ModalCuentasContables" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lista de Funcionario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table id="TablaFuncionario" class="table table-hover table-sm">
              <thead>
                <tr>
                  <th class="columna-hidden"></th>
                  <th>#</th>
                  <th>Dependencia</th>
                  <th>Unidad</th>
                  <th>Funcionario</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($funcionarios as $index => $funcionarios): ?>
                  <tr class="list-item"
                    onclick="selectFun('<?= $funcionarios->funcionario_id ?>', '<?= $funcionarios->funcionario ?>')"
                    data-bs-dismiss="modal">
                    <td class="columna-hidden">
                      <?= $funcionarios->funcionario_id ?>
                    </td>
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <?= $funcionarios->unidad ?>
                    </td>
                    <td>
                      <?= $funcionarios->dependencia ?>
                    </td>
                    <td>
                      <?= $funcionarios->funcionario ?>
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
      function selectFun(id_funcionario, funcionario) {
        document.getElementById('id_Funcionario').value = id_funcionario;
        document.getElementById('Funcionario').value = funcionario;
      }
    </script>

    <div class="modal fade mi-modal" id="modalComprobantes" tabindex="-1" aria-labelledby="modalListComprobantes"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-presupuesto-large">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lista de Comrpobantes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table id="TablaComprobantes" class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Proveedor</th>
                  <th>Monto</th>
                  <th>Obs.</th>
                  <th class="columna-hidden">ff</th>
                  <th class="columna-hidden">str</th>
                  <th class="columna-hidden">op</th>
                  <th class="columna-hidden">obl</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($comprobantes as $index => $comp): ?>
                  <tr class="list-item"
                    onclick="selectComp('<?= $comp->IDComprobanteGasto ?>',  '<?= $comp->fecha ?>', '<?= $comp->concepto ?>', '<?= $comp->monto ?>', '<?= $comp->obl ?>'
                    , '<?= $comp->str ?>', '<?= $comp->op ?>')"
                    data-bs-dismiss="modal">
                    <td>
                      <?= $comp->IDComprobanteGasto ?>
                    </td>
                    <td>
                      <?= $comp->fecha ?>
                    </td>
                    <td>
                      <?= $comp->idproveedor ?>
                    </td>
                    <td>
                      <?= $comp->monto ?>
                    </td>
                    <td>
                      <?= $comp->concepto ?>
                    </td>
                    <td class="columna-hidden">
                      <?= $comp->id_ff ?>
                    </td>
                    <td class="columna-hidden">
                      <?= $comp->obl ?>
                    </td>
                    <td class="columna-hidden">
                      <?= $comp->str ?>
                    </td>
                    <td class="columna-hidden">
                      <?= $comp->op ?>
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
      function selectComp(IDComprobanteGasto, fecha, concepto, monto, obl, str, op) {
        document.getElementById('idcomprobante').value = IDComprobanteGasto;
        document.getElementById('fechaT').value = fecha;
        document.getElementById('concepto').value = concepto;
        document.getElementById('monto').value = monto;
        document.getElementById('obl').value = obl;
        document.getElementById('str').value = str;
        document.getElementById('op').value = op;
      }
    </script>



    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>

    <!-- Script encargado de las tablas de proveedores -->
    <script>
      $(document).ready(function () {
        $('#TablaProveedores').DataTable({
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
        $('#TablaComprobantes').DataTable({
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
        $('#TablaFuncionario').DataTable({
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

</html>