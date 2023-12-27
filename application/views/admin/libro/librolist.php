<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Mayor</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-color {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }
        .page-title {
            padding: 20px 0;
        }
        /* Agrega aquí más estilos personalizados si es necesario */
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="page-title text-center header-color">
        <h1>Libro Mayor</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Libro Mayor</li>
            </ol>
        </nav>
    </div>

    <section class="section mt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 header-color">
                <h6 class="m-0 font-weight-bold text-primary">Filtros de Búsqueda</h6>
            </div>
            <div class="card-body">
                <form class="row g-3 mb-4" action="<?php echo base_url(); ?>LibroMayor/buscarCuenta" method="post">
                    <div class="col-md-4">
                        <label for="fechaInicio" class="form-label">Fecha de Operación Desde:</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio">
                    </div>
                    <div class="col-md-4">
                        <label for="fechaFin" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="fechaFin" name="fecha_fin">
                    </div>
                    <div class="col-md-4">
                        <label for="descripcionCuentaContable" class="form-label">Descripción de Cuenta Contable:</label>
                        <input type="text" class="form-control" id="descripcionCuentaContable" name="descripcion_cuenta_contable" placeholder="Descripción de la cuenta">
                    </div>
                    <div class="col-md-3">
                        <label for="verDiario" class="form-label">Ver Diario:</label>
                        <select class="form-select" id="verDiario" name="ver_diario">
                            <option value="todos">Todos</option>
                            <option value="libroDiarioBorrador">Libro diario borrador</option>
                            <option value="ordenPago">Orden de pago</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="programa" class="form-label">Programa:</label>
                        <select class="form-select" id="programa" name="programa">
                            <option value="todos">Todos</option>
                            <option value="seleccionar">Seleccionar</option>
                            <!-- Añadir más opciones de programas aquí -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="origenFinanciamiento" class="form-label">Origen de Financiamiento:</label>
                        <select class="form-select" id="origenFinanciamiento" name="origen_financiamiento">
                            <option value="todos">Todos</option>
                            <option value="seleccionar">Seleccionar</option>
                            <!-- Añadir más opciones de origen de financiamiento aquí -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="fuenteFinanciamiento" class="form-label">Fuente de Financiamiento:</label>
                        <select class="form-select" id="fuenteFinanciamiento" name="fuente_financiamiento">
                            <option value="todos">Todos</option>
                            <option value="seleccionar">Seleccionar</option>
                            <!-- Añadir más opciones de fuente de financiamiento aquí -->
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 header-color">
                <h6 class="m-0 font-weight-bold text-primary">Resultados</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>N° Asiento</th>
                                <th>N° OP</th>
                                <th>Comprobante</th>
                                <th>Descripción del Gasto</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Saldo</th>
                                <th>Cuenta Contable</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($entradas) && is_array($entradas)): ?>
                                <?php foreach ($entradas as $entrada): ?>
                                    <tr>
                                        <td><?php echo $entrada['FechaEmision']; ?></td>
                                        <td><?php echo $entrada['numero']; ?></td>
                                        <td><?php echo $entrada['Num_Asi_IDNum_Asi']; ?></td>
                                        <td><?php echo $entrada['comprobante']; ?></td>
                                        <td><?php echo $entrada['Descripcion']; ?></td>
                                        <td><?php echo $entrada['Debe']; ?></td>
                                        <td><?php echo $entrada['Haber']; ?></td>
                                        <td><?php // Calcular y mostrar el saldo ?></td>
                                        <td><?php echo $entrada['Codigo_CC']; ?> - <?php echo $entrada['Descripcion_CC']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron registros.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
