<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Estilos de DataTable de jquery -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/DataTables/datatables.min.css">
    <!-- estilos del css -->
    <link href="<?php echo base_url(); ?>/assets/css/style_presupuesto.css" rel="stylesheet">
</head>

<>
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
                        <form action="<?= base_url('mantenimiento/presupuesto/store') ?>" method="POST">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                value="<?= $this->security->get_csrf_hash() ?>">
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
                                                    <!-- Campos editables para Presupuesto Inicial y Modificado -->
                                                    <div class="form-group col-md-4">
                                                        <label for="TotalPresupuestado">Presupuesto Inicial:</label>
                                                        <input type="text" class="form-control number-separator"
                                                            id="TotalPresupuestado" name="TotalPresupuestado" required
                                                            oninput="calcularTotalVigente()">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="TotalModificado">Presupuesto Modificado:</label>
                                                        <input type="text" class="form-control number-separator"
                                                            id="TotalModificado" name="TotalModificado" required
                                                            oninput="calcularTotalVigente()">
                                                    </div>

                                                    <!-- Campo solo para visualización (no se envía) -->
                                                    <div class="form-group col-md-4">
                                                        <label for="TotalVigente">Total Vigente:</label>
                                                        <input type="text" class="form-control" id="TotalVigente"
                                                            disabled>
                                                    </div>
                                                    <!-- Campos de los meses -->
                                                    <div class="collapse mt-4 show" id="camposMesesCollapse">
                                                        <?php
                                                        $meses = [
                                                            'ene' => 'Enero',
                                                            'feb' => 'Febrero',
                                                            'mar' => 'Marzo',
                                                            'abr' => 'Abril',
                                                            'may' => 'Mayo',
                                                            'jun' => 'Junio',
                                                            'jul' => 'Julio',
                                                            'ago' => 'Agosto',
                                                            'sep' => 'Septiembre',
                                                            'oct' => 'Octubre',
                                                            'nov' => 'Noviembre',
                                                            'dic' => 'Diciembre'
                                                        ];

                                                        foreach ($meses as $key => $mes): ?>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label for="monto_<?= $key ?>">Presupuesto
                                                                            <?= $mes ?>:</label>
                                                                        <input type="text"
                                                                            class="form-control number-separator"
                                                                            id="monto_<?= $key ?>"
                                                                            name="montos_mensuales[<?= $key ?>]"
                                                                            data-mes="<?= $key ?>"
                                                                            placeholder="Ingrese el monto para <?= $mes ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-3 mb-3">
                                <div class="col-md-12 d-flex flex-row justify-content-center">
                                    <button style="margin-right: 8px;" type="submit"
                                        class="btn btn-success btn-primary"><span
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


    <!-- Script para el separador de miles -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formatearNumero = (numero) => new Intl.NumberFormat('es-AR').format(numero);
            const limpiarNumero = (valor) => Number(valor.toString().replace(/\./g, '')) || 0;

            // Manejador para inputs numéricos
            document.querySelectorAll('.number-separator').forEach(input => {
                input.addEventListener('input', function (e) {
                    let valor = e.target.value.replace(/[^\d]/g, '');

                    if (valor === '') {
                        e.target.value = '';
                        return;
                    }

                    e.target.value = formatearNumero(valor);
                    calcularTotalVigente();
                });
            });

            // Calcular total vigente (solo visual)
            window.calcularTotalVigente = function () {
                const inicial = limpiarNumero(document.getElementById('TotalPresupuestado').value);
                const modificado = limpiarNumero(document.getElementById('TotalModificado').value);
                document.getElementById('TotalVigente').value = formatearNumero(inicial + modificado);
            };

            // Limpiar formatos al enviar
            document.querySelector('form').addEventListener('submit', function (e) {
                document.querySelectorAll('.number-separator').forEach(input => {
                    input.value = limpiarNumero(input.value);
                });
            });
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


    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
    </body>

</html>