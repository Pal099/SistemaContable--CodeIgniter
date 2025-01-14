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
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select name="Idcuentacontable" id="Idcuentacontable"
                                                                class="form-control" required>
                                                                <option selected disabled>Seleccione una Cuenta
                                                                    Contable...</option>
                                                                <?php foreach ($cuentacontable as $cc) : ?>
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
                                                            <?php foreach ($registros_financieros as $fuente) : ?>
                                                            <option value="<?php echo $fuente->id_ff ?>">
                                                                <?php echo $fuente->codigo . ' - ' . $fuente->nombre ; ?>
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
                                                            <?php foreach ($origen as $o) : ?>
                                                            <option value="<?php echo $o->id_of ?>">
                                                                <?php echo $o->codigo . ' - ' . $o->nombre ; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-4">
                                                        <label for="programa_id_pro">Programa:</label>
                                                        <select name="programa_id_pro" id="programa_id_pro"
                                                            class="form-control" required>
                                                            <?php foreach ($programa as $prog) : ?>
                                                            <option value="<?php echo $prog->id_pro ?>">
                                                                <?php echo $prog->codigo . ' - ' . $prog->nombre ; ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="TotalPresupuestado">Presupuesto Inicial:</label>
                                                        <input type="text" class="form-control number-separator" id="TotalPresupuestado" name="TotalPresupuestado" required oninput="calcularPresupuestoVigente()">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="TotalModificado">Presupuesto Modificado:</label>
                                                        <input type="text" class="form-control number-separator" id="TotalModificado" name="TotalModificado" required oninput="calcularPresupuestoVigente()">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="TotalVigente">Presupuesto Vigente:</label>
                                                        <input type="text" class="form-control" id="TotalVigente" name="TotalVigente" disabled>
                                                    </div>
                                                        <!-- Campos de los meses -->
                                                        <div class="collapse mt-4" id="camposMesesCollapse">
                                                            <!-- Enero -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_ene">Plan Financiero Enero:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_ene" name="pre_ene" data-mes="ene">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_ene">Saldo Acumulado Enero:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_ene" name="sal_ene" data-mes="ene">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_ene">Total Enero:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_ene" name="total_ene" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Febrero -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_feb">Plan Financiero Febrero:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_feb" name="pre_feb" data-mes="feb">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_feb">Saldo Acumulado Febrero:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_feb" name="sal_feb" data-mes="feb">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_feb">Total Febrero:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_feb" name="total_feb" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Marzo -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_mar">Plan Financiero Marzo:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_mar" name="pre_mar" data-mes="mar">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_mar">Saldo Acumulado Marzo:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_mar" name="sal_mar" data-mes="mar">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_mar">Total Marzo:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_mar" name="total_mar" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Abril -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_abr">Plan Financiero Abril:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_abr" name="pre_abr" data-mes="abr">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_abr">Saldo Acumulado Abril:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_abr" name="sal_abr" data-mes="abr">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_abr">Total Abril:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_abr" name="total_abr" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Mayo -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_may">Plan Financiero Mayo:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_may" name="pre_may" data-mes="may">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_may">Saldo Acumulado Mayo:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_may" name="sal_may" data-mes="may">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_may">Total Mayo:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_may" name="total_may" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Junio -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_jun">Plan Financiero Junio:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_jun" name="pre_jun" data-mes="jun">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_jun">Saldo Acumulado Junio:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_jun" name="sal_jun" data-mes="jun">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_jun">Total Junio:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_jun" name="total_jun" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Julio -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_jul">Plan Financiero Julio:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_jul" name="pre_jul" data-mes="jul">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_jul">Saldo Acumulado Julio:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_jul" name="sal_jul" data-mes="jul">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_jul">Total Julio:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_jul" name="total_jul" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Agosto -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_ago">Plan Financiero Agosto:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_ago" name="pre_ago" data-mes="ago">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_ago">Saldo Acumulado Agosto:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_ago" name="sal_ago" data-mes="ago">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_ago">Total Agosto:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_ago" name="total_ago" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Septiembre -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_sep">Plan Financiero Septiembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_sep" name="pre_sep" data-mes="sep">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_sep">Saldo Acumulado Septiembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_sep" name="sal_sep" data-mes="sep">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_sep">Total Septiembre:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_sep" name="total_sep" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Octubre -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_oct">Plan Financiero Octubre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_oct" name="pre_oct" data-mes="oct">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_oct">Saldo Acumulado Octubre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_oct" name="sal_oct" data-mes="oct">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_oct">Total Octubre:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_oct" name="total_oct" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Noviembre -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_nov">Plan Financiero Noviembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_nov" name="pre_nov" data-mes="nov">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_nov">Saldo Acumulado Noviembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_nov" name="sal_nov" data-mes="nov">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_nov">Total Noviembre:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_nov" name="total_nov" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Diciembre -->
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="pre_dic">Plan Financiero Diciembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="pre_dic" name="pre_dic" data-mes="dic">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="sal_dic">Saldo Acumulado Diciembre:</label>
                                                                        <input type="text" class="form-control number-separator calculo-suma" id="sal_dic" name="sal_dic" data-mes="dic">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="total_dic">Total Diciembre:</label>
                                                                        <input type="text" class="form-control number-separator" id="total_dic" name="total_dic" readonly>
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
    <div class="modal fade mi-modal" id="modalCuentasCont" tabindex="-1" aria-labelledby="ModalCuentasContables" aria-hidden="true">
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
</body>

</html>