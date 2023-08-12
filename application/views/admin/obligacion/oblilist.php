<main id="main" class="main">
  <!-- Content Wrapper. Contains page content -->
  <div class="pagetitle">
    <h1>Diario de Obligaciones</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="breadcrumb-item active">Diario de Obligaciones</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="checkbox-container">
            <label>
              <input type="checkbox" id="checkboxCamposOpcionales"> Habilitar campos opcionales
            </label>
          </div>
        </div>
        <hr>

        <!-- Formulario para agregar obligaciones -->
        <div class="row">
          <!-- Left side columns -->
          <div class="box box-solid">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <?php if ($this->session->flashdata("error")): ?>
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                    </div>
                  <?php endif; ?>
                  <form id="formPrincipal" action="<?php echo base_url(); ?>obligaciones/diario_obligaciones/store" method="POST">
                    <!-- Campos principales -->
                    <div class="form-group <?php echo form_error('ruc') == true ? 'has-error' : ''; ?>">
                      <label for="ruc">Ruc:</label>
                      <input type="text" class="form-control" id="ruc" name="ruc">
                      <?php echo form_error("ruc", "<span class='help-block'>", "</span>"); ?>
                    </div>
                    <div class="form-group">
                      <label for="numero">Numero:</label>
                      <input type="text" class="form-control" id="numero" name="numero">
                    </div>
                    <div class="form-group">
                      <label for="contabilidad">Contabilidad:</label>
                      <input type="text" class="form-control" id="contabilidad" name="contabilidad">
                    </div>
                    <div class="form-group">
                      <label for="direccion">Dirección:</label>
                      <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                    <div class="form-group">
                      <label for="telefono">Teléfono:</label>
                      <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="form-group">
                      <label for="observacion">Observación:</label>
                      <input type="text" class="form-control" id="observacion" name="observacion">
                    </div>
                    <div class="form-group">
                      <label for="fecha">Fecha:</label>
                      <input type="text" class="form-control" id="fecha" name="fecha">
                    </div>
                    <!-- Fin campos principales -->

                   

                    <!-- Campos opcionales -->
                    <div id="camposOpcionales">
                      <div class="form-group">
                        <label for="tesoreria">Tesoreria:</label>
                        <input type="text" class="form-control" id="tesoreria" name="tesoreria">
                      </div>
                      <div class="form-group">
                        <label for="pedi_matricula">Pedido de matrícula:</label>
                        <input type="text" class="form-control" id="pedi_matricula" name="pedi_matricula">
                      </div>
                      <div class="form-group">
                        <label for="modalidad">Modalidad:</label>
                        <input type="text" class="form-control" id="modalidad" name="modalidad">
                      </div>
                      <div class="form-group">
                        <label for="tipo_presupuesto">Tipo de presupuesto:</label>
                        <input type="text" class="form-control" id="tipo_presupuesto" name="tipo_presupuesto">
                      </div>
                      <div class="form-group">
                        <label for="unidad_respon">Unidad responsable:</label>
                        <input type="text" class="form-control" id="unidad_respon" name="unidad_respon">
                      </div>
                      <div class="form-group">
                        <label for="proyecto">Proyecto:</label>
                        <input type="text" class="form-control" id="proyecto" name="proyecto">
                      </div>
                      <div class="form-group">
                        <label for="estado">Estado:</label>
                        <input type="text" class="form-control" id="estado" name="estado">
                      </div>
                      <div class="form-group">
                        <label for="nro_pac">nro_pac:</label>
                        <input type="text" class="form-control" id="nro_pac" name="nro_pac">
                      </div>
                      <div class="form-group">
                        <label for="nro_exp">nro_exp:</label>
                        <input type="text" class="form-control" id="nro_exp" name="nro_exp">
                      </div>
                      <div class="form-group">
                        <label for="total">total:</label>
                        <input type="text" class="form-control" id="total" name="total">
                      </div>
                      <div class="form-group">
                        <label for="pagado">pagado:</label>
                        <input type="text" class="form-control" id="pagado" name="pagado">
                      </div>
                    </div>
                    <!-- Fin campos opcionales -->

                    <div class="form-group">
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span>Guardar</button>
                      </div>
                      <div class="col-md-6">
                        <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span>Cancelar</a>
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

        <!-- Tabla de Obligaciones -->
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ruc</th>
                    <th>Numero</th>
                    <th>Contabilidad</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($obligaciones)): ?>
                    <?php foreach ($obligaciones as $obligacion): ?>
                      <tr>
                        <td><?php echo $obligacion->id; ?></td>
                        <td><?php echo $obligacion->ruc; ?></td>
                        <td><?php echo $obligacion->numero; ?></td>
                        <td><?php echo $obligacion->contabilidad; ?></td>
                        <td><?php echo $obligacion->direccion; ?></td>
                        <td><?php echo $obligacion->telefono; ?></td>
                        <td><?php echo $obligacion->observacion; ?></td>
                        <td><?php echo $obligacion->fecha; ?></td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info btn-view-diario_obligaciones" data-toggle="modal"
                              data-target="#modal-default" value="<?php echo $obligacion->id; ?>">
                              <span class="fa fa-search"></span>
                            </button>
                            <a href="<?php echo base_url() ?>obligaciones/diario_obligaciones/edit/<?php echo $obligacion->id; ?>"
                              class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                            <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/delete/<?php echo $obligacion->id; ?>"
                              class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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

      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
</main>


<style>
  /* ... (estilos existentes) ... */

  /* Estilos para ocultar los campos opcionales */
  #camposOpcionales {
    display: none;
  }

  /* Estilos para el checkbox */
  .checkbox-container {
    margin-top: 15px;
  }

  .checkbox-container label {
    font-weight: normal;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxCamposOpcionales = document.getElementById('checkboxCamposOpcionales');
    const camposOpcionales = document.getElementById('camposOpcionales');

    checkboxCamposOpcionales.addEventListener('change', function() {
      if (checkboxCamposOpcionales.checked) {
        camposOpcionales.style.display = 'block';
      } else {
        camposOpcionales.style.display = 'none';
      }
    });
  });
</script>
