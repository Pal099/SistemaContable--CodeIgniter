<head>
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <style>
    /* Estilo para el thead de DataTables */
    #example1 thead {
      background-color: #e6f7fe; /* Cambia esto al color que desees */
      color: white; /* Cambia esto al color del texto que desees */
    }
  </style>
</head>
<main id="main" class="main">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>principal">Inicio</a></li>
            <li class="breadcrumb-item">Movimientos</li>
            <li class="breadcrumb-item">Libro Mayor</li>
        </ol>
    </nav>
    <!-- Content Wrapper.  Contains page content -->
    <div class="container-fluid bg-white border rounded-3">
        <div class="pagetitle">
            <div class="container-fluid d-flex flex-row justify-content-between">
                <div class="col-md-6 mt-4">
                    <h1>Libro Mayor</h1>
                </div>
            </div>
        </div><!-- End Page Title -->
        <hr> <!-- barra separadora -->
        <div class="container-fluid">
            <!-- Campos principales -->
            <div class="row">
                <div class="container-fluid mt-2">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card border">
                                <div class="card-body">
                                    <form class="row g-3 mb-4 mt-2"
                                        action="<?php echo base_url();?>LibroMayor/mostrarLibroMayor" method="post">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="fechaInicio" class="form-label">Fecha de Operación
                                                        Desde:</label>
                                                    <input type="date" class="form-control" id="fechaInicio"
                                                        name="fecha_inicio">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="fechaFin" class="form-label">Hasta:</label>
                                                    <input type="date" class="form-control" id="fechaFin"
                                                        name="fecha_fin">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="busquedaCuentaContable" class="form-label">Buscar
                                                        Cuenta:</label>
                                                    <input type="text" class="form-control" id="busquedaCuentaContable"
                                                        name="busquedaCuentaContable"
                                                        placeholder="Ingrese código o descripción">
                                                </div>
                                                <div class="col-md-1 d-md-flex align-items-end ">
                                                    <button type="submit" class="btn btn-primary " ><i class="bi bi-search"></i> Buscar</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                    <!-- Tabla de Resultados -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>N° Asiento</th>
                                                    <th>N° OP</th>
                                                    <th>Comprobante</th>
                                                    <th>Descripción del gasto</th>
                                                    <th>Debe</th>
                                                    <th>Haber</th>
                                                    <th>Saldo</th>
                                                    <th>Cuenta Contable</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($entradas)): ?>
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
                                                    <td><?php echo $entrada['Codigo_CC']; ?> -
                                                        <?php echo $entrada['Descripcion_CC']; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No se encontraron registros.
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tabla -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>