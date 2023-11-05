<main id="main" class="main">

  <div class="pagetitle">
      <h1> PLAN DE CUENTAS
        <small>Nuevo</small>
      </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url();?>mantenimiento/CuentaContable">Plan de Cuentas</a></li>
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

                            <!-- Formulario para seleccionar el tipo y cargar cuentas padre -->
                              <!-- Formulario para seleccionar el tipo y cargar cuentas padre -->
                              <form action="<?php echo base_url();?>mantenimiento/CuentaContable/store" method="GET">
                                <!-- Tipo -->
                                <div class="form-group">
                                    <label for="tipo">Tipo:</label>
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option value="Título">Título</option>
                                        <option value="Grupo">Grupo</option>
                                        <option value="SubGrupo">SubGrupo</option>
                                        <option value="Cuenta">Cuenta</option>
                                        <option value="SubCuenta">SubCuenta</option>
                                        <option value="Analitico1">Analitico1</option>
                                        <option value="Analitico2">Analitico2</option>

                                        <!-- ... otros tipos ... -->
                                    </select>
                                    <button type="button"id="loadPadre" class="btn btn-primary btn-flat">Cargar Cuentas Padre</button>
                                </div>
                            </form>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script type="text/javascript">
                                $(document).ready(function(){ 
                                    $('#loadPadre').click(function(){
                                        var tipo = $('#tipo').val();
                                        $.ajax({
                                            url: "<?php echo base_url();?>mantenimiento/CuentaContable/getCuentasPadre",
                                            method: "POST",
                                            data: { tipo: tipo },
                                            success: function(data) {
                                                // Actualiza el DOM con las cuentas padre
                                                $('#padre_id').html(data);
                                            }
                                        });
                                    });
                                });
                                </script>

                            <!-- Formulario principal -->

                                <form action="<?php echo base_url();?>mantenimiento/CuentaContable/store" method="POST">
                                    <!-- Código de Cuenta Contable -->
                                    <input type="hidden" name="tipo" id="hiddenTipo" value="">

                                    <div class="form-group <?php echo form_error('Codigo_CC') == true ? 'has-error':''?>">
                                        <label for="Codigo_CC">Código:</label>
                                        <input type="text" class="form-control" id="Codigo_CC" name="Codigo_CC" placeholder="Ejemplo: 2.1.1.01">
                                        <?php echo form_error("Codigo_CC","<span class='help-block'>","</span>");?>
                                    </div>
                                    <!-- Descripción -->
                                    <div class="form-group <?php echo form_error('Descripcion_CC') == true ? 'has-error':''?>">
                                        <label for="Descripcion_CC">Descripción:</label>
                                        <input type="text" class="form-control" id="Descripcion_CC" name="Descripcion_CC">
                                        <?php echo form_error("Descripcion_CC","<span class='help-block'>","</span>");?>
                                    </div>
                                    <!-- Cuentas Padre (solo se mostrarán si se ha seleccionado un tipo) -->
                                    <?php if (isset($cuentasPadre) && !empty($cuentasPadre)): ?>
                                    <div class="form-group" id="divPadre">
                                        <label for="padre_id">Cuenta Padre:</label>
                                        <select class="form-control" id="padre_id" name="padre_id">
                                            <?php foreach ($cuentasPadre as $cuenta): ?>
                                            <option value="<?php echo $cuenta->Codigo_CC; ?>"><?php echo $cuenta->Descripcion_CC; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?php else: ?>
                                        <p>No hay cuentas padre disponibles.</p>
                                    <?php endif; ?>
                                    <!-- Imputable -->
                                    <div class="form-group">
                                        <label for="imputable">Imputable:</label>
                                        <input type="checkbox" id="imputable" name="imputable" value="1">
                                        <label for="imputable">Sí</label>
                                    </div>
                                    <!-- Botones de Acción -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span> Guardar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable" class="btn btn-danger"><span class="fa fa-remove"></span> Cancelar</a>
                                        </div>
                                
                                    </div>

                                </form>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#tipo').change(function(){
                                        var tipo = $(this).val();
                                        $('#hiddenTipo').val(tipo);  // Establecer el tipo en el input oculto
                                        
                                        $.ajax({
                                            url: "<?php echo base_url();?>mantenimiento/CuentaContable/getCuentasPadre",
                                            method: "POST",
                                            data: { tipo: tipo },
                                            success: function(data) {
                                                $('#padre_id').html(data);
                                            }
                                        });
                                    });

                                    $("form").submit(function(e){
                                        let error = "";
                                        if($("#Codigo_CC").val() == ""){
                                            error += "El campo Código es obligatorio.<br>";
                                        }
                                        if($("#Descripcion_CC").val() == ""){
                                            error += "El campo Descripción es obligatorio.<br>";
                                        }
                                        if($("#hiddenTipo").val() == ""){
                                            error += "El campo Tipo es obligatorio.<br>";
                                        }
                                        if(error != ""){
                                            e.preventDefault();
                                            alert(error);
                                        }
                                        if($("#imputable").is(":checked")){
                                            alert("Imputable está seleccionado, valor: " + $("#imputable").val());
                                        } else {
                                            alert("Imputable no está seleccionado");
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
