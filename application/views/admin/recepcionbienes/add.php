<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <!-- Estilos de DataTable de jquery -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
  <!-- estilos del css -->
  <link href="<?php echo base_url(); ?>/assets/css/style_presupuesto.css" rel="stylesheet">

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
                          <div class="col-md-12">
                            <div class="form-group col-md-2">
                              <label for="nro">Nro. de Orden:</label>
                              <input type="number" class="form-control" id="nro" name="nro" value="" required>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="id_unidad">Unidad:</label>
                              <select name="id_unidad" id="id_unidad" class="form-control" required>
                                <?php foreach ($unidad as $uni): ?>
                                  <option value="<?php echo $uni->id_unidad ?>">
                                    <?php echo $uni->unidad . ' - ' . $uni->id_unidad; ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="input-group">
                              <label for="id_unidad">Proveedor:</label>
                              <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                                <option selected disabled>Seleccione un Proveedor...</option>
                                <?php foreach ($proveedores as $prov): ?>
                                  <option value="<?php echo $prov->id ?>">
                                    <?php echo $prov->razon_social; ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                              <button type="button" data-bs-toggle="modal" data-bs-target="#modalProveedores"
                                class="btn btn-primary">
                                <i class="bi bi-search"> Buscar</i>
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
                          <!--Por decidir si como va a ser Dependencia-->
                          <div class="form-group col-md-4">
                            <label for="id_unidad">Dependencia:</label>
                            <select name="id_unidad" id="id_unidad" class="form-control" required>
                              <?php foreach ($unidad as $uni): ?>
                                <option value="<?php echo $uni->id_unidad ?>">
                                  <?php echo $uni->unidad . ' - ' . $uni->id_unidad; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="funcionario">Funcionario</label>
                            <input type="text" class="form-control" id="funcionario" name="funcionario" value=""
                              required>
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
                                          name="monto" >
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

  </main>
  <div class="modal fade mi-modal" id="modalProveedores" tabindex="-1" aria-labelledby="modalListProveedores"
    aria-hidden="true">
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
                <th class="columna-hidden">ID</th>
                <th>#</th>
                <th>Ruc</th>
                <th>Razón Social</th>
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
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

  <script>
    function selectProveedor(razonSocial) {
      document.getElementById('idproveedor').value = razonSocial;

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
                  onclick="selectComp('<?= $comp->IDComprobanteGasto ?>',  '<?= $comp->fecha ?>', '<?= $comp->concepto ?>', '<?= $comp->monto ?>')"
                  data-bs-dismiss="modal">
                  <td>
                    <?= $comp->IDComprobanteGasto ?>
                  </td>
                  <td>
                    <?= $comp->fecha ?>
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


  <!-- Script de DataTable de jquery -->
  <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>