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
                <li class="breadcrumb-item">Editar presupuesto</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar presupuesto</h1>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="camposOpcionalesSwitch">
                                <label class="form-check-label" for="camposOpcionalesSwitch">Editar el presupuesto por
                                    mes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_editar_presupuesto">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>mantenimiento/presupuesto/update" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <input type="hidden" value="<?php echo $presupuesto->ID_Presupuesto; ?>" name="ID_Presupuesto">
                                                    <div class="row g-3 mb-4">
                                                    <div class="col-md-4">
                                                    <!-- Información Principal -->
                                                    <?php print_r($presupuesto); ?>
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="date" class="form-control" id="Año" name="Año" 
                                                                    value="<?php echo $presupuesto->Año ?>" required>
                                                                <label for="Año">Fecha</label>
                                                                <div class="invalid-feedback">Por favor seleccione una fecha</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="number" step="0.01" class="form-control" id="TotalPresupuestado" 
                                                                    name="TotalPresupuestado" value="<?php echo $presupuesto->TotalPresupuestado ?>" required>
                                                                <label for="TotalPresupuestado">Total Presupuestado</label>
                                                                <div class="invalid-feedback">Ingrese un monto válido</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="number" step="0.01" class="form-control" id="TotalModificado" 
                                                                    name="TotalModificado" value="<?php echo $presupuesto->TotalModificado ?>" required>
                                                                <label for="TotalModificado">Total Modificado</label>
                                                                <div class="invalid-feedback">Ingrese un monto válido</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Selects -->
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select class="form-select" name="origen_de_financiamiento_id_of" 
                                                                        id="origen_de_financiamiento_id_of" required>
                                                                    <option value="" disabled>Seleccione una opción</option>
                                                                    <?php foreach ($origen as $o): ?>
                                                                        <option value="<?php echo $o->id_of ?>" 
                                                                            <?php echo ($presupuesto->origen_de_financiamiento_id_of == $o->id_of) ? 'selected' : ''; ?>>
                                                                            <?php echo $o->nombre; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <label for="origen_de_financiamiento_id_of">Origen de Financiamiento</label>
                                                                <div class="invalid-feedback">Seleccione un origen de financiamiento</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select class="form-select" name="fuente_de_financiamiento_id_ff" 
                                                                        id="fuente_de_financiamiento_id_ff" required>
                                                                    <option value="" disabled>Seleccione una opción</option>
                                                                    <?php foreach ($registros_financieros as $fuente): ?>
                                                                        <option value="<?php echo $fuente->id_ff ?>" 
                                                                            <?php echo ($presupuesto->fuente_de_financiamiento_id_ff == $fuente->id_ff) ? 'selected' : ''; ?>>
                                                                            <?php echo $fuente->nombre; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <label for="fuente_de_financiamiento_id_ff">Fuente de Financiamiento</label>
                                                                <div class="invalid-feedback">Seleccione una fuente de financiamiento</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select class="form-select" name="programa_id_pro" id="programa_id_pro" required>
                                                                    <option value="" disabled>Seleccione una opción</option>
                                                                    <?php foreach ($programa as $prog): ?>
                                                                        <option value="<?php echo $prog->id_pro ?>" 
                                                                            <?php echo ($presupuesto->programa_id_pro == $prog->id_pro) ? 'selected' : ''; ?>>
                                                                            <?php echo $prog->nombre; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <label for="programa_id_pro">Programa</label>
                                                                <div class="invalid-feedback">Seleccione un programa</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <select name="Idcuentacontable" id="Idcuentacontable" class="form-control" required>
                                                                    <option selected disabled>Seleccione una Cuenta Contable...</option>
                                                                    <?php foreach ($cuentacontable as $cc) : ?>
                                                                        <option value="<?php echo $cc->IDCuentaContable ?>"
                                                                            <?php echo ($presupuesto->Idcuentacontable == $cc->IDCuentaContable) ? 'selected' : ''; ?>>
                                                                            <?php echo $cc->Descripcion_CC; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalCuentasCont" class="btn btn-primary">
                                                                    <i class="bi bi-search"> Buscar</i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Campos de los meses del presupuesto (probando un cambio)
                                                    <div class="collapse mt-4" id="camposMesesCollapse">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_ene">Presupuesto Enero:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_ene" name="pre_ene"
                                                                        value="<?php echo $presupuesto->pre_ene ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_jul">Presupuesto Julio:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_jul" name="pre_jul"
                                                                        value="<?php echo $presupuesto->pre_jul ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_feb">Presupuesto Febrero:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_feb" name="pre_feb"
                                                                        value="<?php echo $presupuesto->pre_feb ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_ago">Presupuesto Agosto:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_ago" name="pre_ago"
                                                                        value="<?php echo $presupuesto->pre_ago ?>">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_mar">Presupuesto Marzo:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_mar" name="pre_mar"
                                                                        value="<?php echo $presupuesto->pre_mar ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_sep">Presupuesto Septiembre:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_sep" name="pre_sep"
                                                                        value="<?php echo $presupuesto->pre_sep ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_abr">Presupuesto Abril:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_abr" name="pre_abr"
                                                                        value="<?php echo $presupuesto->pre_abr ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_oct">Presupuesto Octubre:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_oct" name="pre_oct"
                                                                        value="<?php echo $presupuesto->pre_oct ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_may">Presupuesto Mayo:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_may" name="pre_may"
                                                                        value="<?php echo $presupuesto->pre_may ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_nov">Presupuesto Noviembre:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_nov" name="pre_nov"
                                                                        value="<?php echo $presupuesto->pre_nov ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="pre_jun">Presupuesto Junio:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_jun" name="pre_jun"
                                                                        value="<?php echo $presupuesto->pre_jun ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="pre_dic">Presupuesto Diciembre:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="pre_dic" name="pre_dic"
                                                                        value="<?php echo $presupuesto->pre_dic ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label for="sal_ene">Plan Financiero Enero:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="sal_ene" name="sal_ene"
                                                                        value="<?php echo $presupuesto->sal_ene ?>">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="sal_jul">Plan Financiero Diciembre:</label>
                                                                    <input type="number" class="form-control"
                                                                        id="sal_jul" name="sal_jul"
                                                                        value="<?php echo $presupuesto->sal_jul ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- Sección de campos mensuales logica nueva -->
                                                        <div class="collapse mt-4" id="camposMesesCollapse">
                                                            <div class="card">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">Planificación Mensual</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <?php
                                                                    // Array de meses para generar campos de forma dinámica
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

                                                                    foreach ($meses as $codigo => $nombre): ?>
                                                                        <div class="form-group mb-4">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-12 mb-2">
                                                                                    <h6 class="border-bottom pb-2"><?php echo $nombre; ?></h6>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label for="pre_<?php echo $codigo; ?>">Plan Financiero:</label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text">$</span>
                                                                                        <input type="text" 
                                                                                            class="form-control number-separator calculo-suma" 
                                                                                            id="pre_<?php echo $codigo; ?>" 
                                                                                            name="pre_<?php echo $codigo; ?>" 
                                                                                            data-mes="<?php echo $codigo; ?>"
                                                                                            value="<?php echo $presupuesto->{"pre_$codigo"}; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label for="sal_<?php echo $codigo; ?>">Saldo Acumulado:</label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text">$</span>
                                                                                        <input type="text" 
                                                                                            class="form-control number-separator calculo-suma" 
                                                                                            id="sal_<?php echo $codigo; ?>" 
                                                                                            name="sal_<?php echo $codigo; ?>" 
                                                                                            data-mes="<?php echo $codigo; ?>"
                                                                                            value="<?php echo isset($plan_financiero->{"sal_$codigo"}) ? $plan_financiero->{"sal_$codigo"} : ''; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label for="total_<?php echo $codigo; ?>">Total:</label>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-text">$</span>
                                                                                        <input type="text" 
                                                                                            class="form-control number-separator" 
                                                                                            id="total_<?php echo $codigo; ?>" 
                                                                                            name="total_<?php echo $codigo; ?>" 
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>

                                                                    <!-- Resumen de Totales -->
                                                                    <div class="row mt-4 bg-light py-3 rounded">
                                                                        <div class="col-12">
                                                                            <h6 class="mb-3">Resumen Anual</h6>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="total_plan">Total Plan Financiero:</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">$</span>
                                                                                <input type="text" class="form-control" id="total_plan" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="total_saldo">Total Saldo Acumulado:</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">$</span>
                                                                                <input type="text" class="form-control" id="total_saldo" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="total_general">Total General:</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">$</span>
                                                                                <input type="text" class="form-control" id="total_general" readonly>
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
                                    <button style="margin-right: 8px;" type="submit"
                                        class="btn btn-success btn-primary"><span
                                            class="fa fa-save"></span>Guardar</button>
                                    <button type="button" class="btn btn-danger ml-3"
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
    document.getElementById('camposOpcionalesSwitch').addEventListener('change', function() {
        var camposMesesCollapse = new bootstrap.Collapse(document.getElementById('camposMesesCollapse'));
        camposMesesCollapse.toggle();
    });
    </script>
        
        
    <!-- Script para el separador de miles -->
    <script>
    document.querySelectorAll('.number-separator').forEach(function (input) {
        input.addEventListener('input', function (e) {
            // Obtener el valor actual del input
            let value = e.target.value;

            // Eliminar todos los caracteres no numéricos excepto comas y puntos
            value = value.replace(/[^\d]/g, '');

            // Eliminar las comas y reformatear con el formato de número con separadores de miles
            value = value.replace(/,/g, '');
            value = new Intl.NumberFormat().format(value);

            // Actualizar el valor del input con el nuevo formato
            e.target.value = value;

            // Llamar a la función de cálculo cuando se modifica el valor
            calcularPresupuestoVigente();
        });
    });

    // Eliminar los separadores de miles antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('.number-separator').forEach(function (input) {
            input.value = input.value.replace(/,/g, '');
        });
    });
    </script>

    <!-- Script para el cálculo del presupuesto vigente -->
    <script>
    function calcularPresupuestoVigente() {
        // Obtener valores de los campos
        let presupuestoInicial = document.getElementById('TotalPresupuestado').value.replace(/,/g, '') || 0;
        let presupuestoModificado = document.getElementById('TotalModificado').value.replace(/,/g, '') || 0;

        // Convertir los valores a números
        presupuestoInicial = parseFloat(presupuestoInicial) || 0;
        presupuestoModificado = parseFloat(presupuestoModificado) || 0;

        // Calcular el Presupuesto Vigente
        let presupuestoVigente = presupuestoInicial + presupuestoModificado;

        // Mostrar el resultado en el campo de "Presupuesto Vigente"
        document.getElementById('TotalVigente').value = new Intl.NumberFormat().format(presupuestoVigente.toFixed(2));
    }
    </script>
            <script>
        // Función para calcular la suma de los campos por mes
        function calcularSuma(mes) {
            const planFinanciero = document.getElementById('pre_' + mes);
            const saldoAcumulado = document.getElementById('sal_' + mes);
            const totalCampo = document.getElementById('total_' + mes);
            
            // Obtener valores y remover separadores de miles
            const valor1 = parseFloat(planFinanciero.value.replace(/,/g, '')) || 0;
            const valor2 = parseFloat(saldoAcumulado.value.replace(/,/g, '')) || 0;
            
            // Calcular suma
            const suma = valor1 + valor2;
            
            // Formatear resultado usando Intl.NumberFormat para consistencia con el script existente
            totalCampo.value = new Intl.NumberFormat().format(suma);
        }

        // Modificar el script existente para incluir el cálculo de sumas
        document.querySelectorAll('.number-separator').forEach(function (input) {
            input.addEventListener('input', function (e) {
                // Obtener el valor actual del input
                let value = e.target.value;

                // Eliminar todos los caracteres no numéricos excepto comas y puntos
                value = value.replace(/[^\d]/g, '');

                // Eliminar las comas y reformatear con el formato de número con separadores de miles
                value = value.replace(/,/g, '');
                value = new Intl.NumberFormat().format(value);

                // Actualizar el valor del input con el nuevo formato
                e.target.value = value;

                // Llamar a la función de cálculo cuando se modifica el valor
                calcularPresupuestoVigente();
                
                // Si el campo es parte de un cálculo de suma mensual, actualizarlo
                if (input.classList.contains('calculo-suma')) {
                    const mes = input.dataset.mes;
                    calcularSuma(mes);
                }
            });
        });

        // Mantener el código existente para eliminar separadores antes del envío del formulario
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelectorAll('.number-separator').forEach(function (input) {
                input.value = input.value.replace(/,/g, '');
            });
        });
    </script>
    <!-- Script para la tabla de cuentas contables -->
    <script>
    $(document).ready(function() {
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

    <!-- CSS adicional para mejorar la presentación -->
    <style>
    .card-header {
        border-bottom: 2px solid #dee2e6;
    }

    .form-group {
        position: relative;
    }

    .form-group:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        right: 0;
        height: 1px;
        background: #f0f0f0;
    }

    .input-group-text {
        background-color: #f8f9fa;
        min-width: 45px;
        justify-content: center;
    }

    input[readonly] {
        background-color: #f8f9fa;
    }

    h6 {
        color: #495057;
        font-weight: 600;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
    </style>
</body>

</html>