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
                <li class="breadcrumb-item">Presupuesto</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/mantenimiento/presupuesto">Listado
                        Presupuesto</a></li>
                <li class="breadcrumb-item">Agregar presupuesto</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar presupuesto</h1>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="camposOpcionalesSwitch">
                                <label class="form-check-label" for="camposOpcionalesSwitch">Agregar presupuesto por
                                    mes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_agregar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/store" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <div class="form-group col-md-4">
                                                        <label for="Año">Fecha:</label>
                                                        <input type="date" class="form-control" id="Año" name="Año"
                                                            placeholder="Ej. YYYY/MM/DD" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="TotalPresupuestado">Presupuesto Inicial:</label>
                                                        <input type="number" class="form-control"
                                                            id="TotalPresupuestado" name="TotalPresupuestado" required>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="TotalModificado">Presupuesto Modificado:</label>
                                                        <input type="number" class="form-control" id="TotalModificado"
                                                            name="TotalModificado" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="fuente_de_financiamiento_id_ff">Fuente de
                                                            Financiamiento:</label>
                                                        <select name="fuente_de_financiamiento_id_ff"
                                                            id="fuente_de_financiamiento_id_ff" class="form-control"
                                                            required>
                                                            <?php foreach ($registros_financieros as $fuente): ?>
                                                                <option value="<?php echo $fuente->id_ff ?>">
                                                                    <?php echo $fuente->codigo . ' - ' . $fuente->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="origen_de_financiamiento_id_of">Origen de
                                                            Financiamiento:</label>
                                                        <select name="origen_de_financiamiento_id_of"
                                                            id="origen_de_financiamiento_id_of" class="form-control"
                                                            required>
                                                            <?php foreach ($origen as $o): ?>
                                                                <option value="<?php echo $o->id_of ?>">
                                                                    <?php echo $o->codigo . ' - ' . $o->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="programa_id_pro">Programa:</label>
                                                        <select name="programa_id_pro" id="programa_id_pro"
                                                            class="form-control" required>
                                                            <?php foreach ($programa as $prog): ?>
                                                                <option value="<?php echo $prog->id_pro ?>">
                                                                    <?php echo $prog->codigo . ' - ' . $prog->nombre; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select name="Idcuentacontable" id="Idcuentacontable"
                                                                class="form-control" required>
                                                                <option selected disabled>Seleccione una Cuenta
                                                                    Contable...</option>
                                                                <?php foreach ($cuentacontable as $cc): ?>
                                                                    <option value="<?php echo $cc->IDCuentaContable ?>">
                                                                        <?php echo $cc->Descripcion_CC; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <button type="button" data-bs-toggle="modal"
                                                                data-bs-target="#modalCuentasCont"
                                                                class="btn btn-primary">
                                                                <i class="bi bi-search"> Buscar</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Campos de los meses del presupuesto -->
                                                    <!-- Campos de los meses del presupuesto -->
                                                    <div class="collapse mt-4" id="camposMesesCollapse">
                                                        <div class="form-group">
                                                            <div class="row row-cols-1 row-cols-md-2 g-3">
                                                                <!-- Enero -->
                                                                <div class="col">
                                                                    <label for="pre_ene">Presupuesto Enero:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_ene" name="pre_ene" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Febrero -->
                                                                <div class="col">
                                                                    <label for="pre_feb">Presupuesto Febrero:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_feb" name="pre_feb" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Marzo -->
                                                                <div class="col">
                                                                    <label for="pre_mar">Presupuesto Marzo:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_mar" name="pre_mar" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Abril -->
                                                                <div class="col">
                                                                    <label for="pre_abr">Presupuesto Abril:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_abr" name="pre_abr" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Mayo -->
                                                                <div class="col">
                                                                    <label for="pre_may">Presupuesto Mayo:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_may" name="pre_may" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Junio -->
                                                                <div class="col">
                                                                    <label for="pre_jun">Presupuesto Junio:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_jun" name="pre_jun" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Julio -->
                                                                <div class="col">
                                                                    <label for="pre_jul">Presupuesto Julio:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_jul" name="pre_jul" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Agosto -->
                                                                <div class="col">
                                                                    <label for="pre_ago">Presupuesto Agosto:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_ago" name="pre_ago" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Septiembre -->
                                                                <div class="col">
                                                                    <label for="pre_sep">Presupuesto Septiembre:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_sep" name="pre_sep" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Octubre -->
                                                                <div class="col">
                                                                    <label for="pre_oct">Presupuesto Octubre:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_oct" name="pre_oct" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Noviembre -->
                                                                <div class="col">
                                                                    <label for="pre_nov">Presupuesto Noviembre:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_nov" name="pre_nov" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>

                                                                <!-- Diciembre -->
                                                                <div class="col">
                                                                    <label for="pre_dic">Presupuesto Diciembre:</label>
                                                                    <input type="text"
                                                                        class="form-control monto-formateado"
                                                                        id="pre_dic" name="pre_dic" data-valor-real=""
                                                                        placeholder="Ej: 1.000.000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
        </div>
        <div class="container-fluid mt-3 mb-3">
            <div class="col-md-12 d-flex flex-row justify-content-center">
                <button style="margin-right: 8px;" type="submit" class="btn btn-success btn-primary"><span
                        class="fa fa-save"></span>Guardar</button>
                <button class="btn btn-danger ml-3"
                    onclick="window.location.href='<?php echo base_url(); ?>mantenimiento/presupuesto'">
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
    <!-- Modal de las cuentas Contables -->
    <div class="modal fade mi-modal" id="modalCuentasCont" tabindex="-1" aria-labelledby="ModalCuentasContables"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cuentas-contables">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buscador de Cuentas Contables</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="TablaCuentaCont">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código de Cuenta</th>
                                <th>Descripción de Cuenta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cuentacontable as $dato): ?>
                                <tr class="list-item"
                                    onclick="selectCC(<?= $dato->IDCuentaContable ?>,'<?= $dato->Codigo_CC ?>', '<?= $dato->Descripcion_CC ?>')"
                                    data-bs-dismiss="modal">
                                    <td>
                                        <?= $dato->IDCuentaContable ?>
                                    </td>
                                    <td>
                                        <?= $dato->Codigo_CC ?>
                                    </td>
                                    <td>
                                        <?= $dato->Descripcion_CC ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Script para seleccionar la cuenta contable -->
    <script>
        function selectCC(IDCuentaContable) {
            // Actualizar el valor del select con los valores seleccionados
            var selectElement = document.getElementById('Idcuentacontable');
            selectElement.value = IDCuentaContable;
        }
    </script>
    <!-- Script para mostrar los campos de los meses -->
    <script>
        document.getElementById('camposOpcionalesSwitch').addEventListener('change', function () {
            var camposMesesCollapse = new bootstrap.Collapse(document.getElementById('camposMesesCollapse'));
            camposMesesCollapse.toggle();
        });
    </script>

    <!-- Script para la tabla de cuentas contables -->
    <script>
        $(document).ready(function () {
            var table1 = $('#TablaCuentaCont').DataTable({
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
    <!-- Script para formatear los montos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Función de formateo
            const formatearMonto = (valor) => {
                return valor.replace(/[^0-9]/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            };

            // Aplicar a todos los campos de meses
            document.querySelectorAll('.monto-formateado').forEach(input => {
                input.addEventListener('input', function (e) {
                    const posicionCursor = this.selectionStart;
                    const valorOriginal = this.value;

                    // Formatear
                    this.value = formatearMonto(this.value);
                    this.setAttribute('data-valor-real', this.value.replace(/\./g, ''));

                    // Mantener posición del cursor
                    const diferencia = this.value.length - valorOriginal.length;
                    this.setSelectionRange(posicionCursor + diferencia, posicionCursor + diferencia);
                });

                // Formatear al perder el foco
                input.addEventListener('blur', function () {
                    if (this.value === '') this.value = '0';
                    this.value = formatearMonto(this.value);
                });

                // Quitar ceros iniciales al enfocar
                input.addEventListener('focus', function () {
                    if (this.value === '0') this.value = '';
                });
            });

            // Limpiar formato antes de enviar
            document.querySelector('form').addEventListener('submit', function (e) {
                document.querySelectorAll('.monto-formateado').forEach(input => {
                    input.value = input.getAttribute('data-valor-real') || '0';
                });
            });
        });
    </script>
    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>