<form action="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/store" method="POST">
    <div class="main-fields">
        <?php $fields = ["ruc", "numero", "contabilidad", "direccion", "telefono", "tesoreria", "observacion", "fecha"]; ?>
        <?php foreach ($fields as $field) : ?>
            <div class="form-group">
                <label for="<?= $field; ?>"><?= ucfirst($field); ?>:</label>
                <input type="text" class="form-control" id="<?= $field; ?>" name="<?= $field; ?>">
                <?php echo form_error($field, "<span class='help-block'>", "</span>"); ?>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="toggleButton">Mostrar campos adicionales</label>
            <button type="button" id="toggleButton" class="btn btn-primary">Mostrar</button>
        </div>

        <div class="asiento-fields hidden">
            <?php $asientoFields = ["cuentacontable", "MontoPago", "Debe", "Haber", "comprobante", "id_of", "id_pro", "id_ff", "cheques_che_id"]; ?>
            <?php for ($i = 1; $i <= 2; $i++) : ?>
                <div class="form-group">
                    <label for="cuentacontable">Código y Descripción de Cuenta Contable:</label>
                    <select class="form-control" id="cuentacontable" name="cuentacontable">
                        <?php foreach ($cuentacontable as $cc) : ?>
                            <option value="<?php echo $cc->IDCuentaContable; ?>">
                                <?php echo $cc->CodigoCuentaContable . ' - ' . $cc->DescripcionCuentaContable; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php foreach ($asientoFields as $field) : ?>
                    <div class="form-group">
                        <label for="<?= $field; ?>"><?= ucfirst($field); ?>:</label>
                        <input type="text" class="form-control" id="<?= $field; ?>" name="<?= $field; ?>">
                    </div>
                <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>

    <div class="row optional-fields">
        <div class="col-md-12">
            <?php $optionalFields = ["pedi_matricula", "modalidad", "tipo_presupuesto", "unidad_respon", "proyecto", "estado", "nro_pac", "nro_exp", "total", "pagado"]; ?>
            <div class="form-group">
                <div class="row">
                    <?php foreach ($optionalFields as $field) : ?>
                        <div class="col-md-6">
                            <label for="<?= $field; ?>"><?= ucfirst($field); ?>:</label>
                            <input type="text" class="form-control" id="<?= $field; ?>" name="<?= $field; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span> Guardar</button>
                </div>
                <div class="col-md-6">
                    <a href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones" class="btn btn-danger"><span class="fa fa-remove"></span> Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('toggleButton').addEventListener('click', function () {
        const asientoFields = document.querySelector('.asiento-fields');
        asientoFields.classList.toggle('hidden');
    });
</script>

<style>
    .hidden {
        display: none;
    }
</style>
