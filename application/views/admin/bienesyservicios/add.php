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
                <li class="breadcrumb-item">Bienes y/o Servicios</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/bienes_servicios">Listado Bienes y/o Servicios</a></li>
                <li class="breadcrumb-item">Agregar Bienes y/o Servicios</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Agregar Bienes y/o Servicios</h1>
                    </div>
                    <div class="col-md-6 mt-4">
                        <div class="d-flex justify-content-md-end">
                            <div class="form-check form-switch mt-2 " style="font-size: 17px;">
                           
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
                        <form action="<?php echo base_url(); ?>patrimonio/bienes_servicios/store" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                            <div class="row g-3 align-items-center mt-2">
                                                    <div class="form-group col-md-4">
                                                        <label for="rubro">Rubro </label>
                                                        <input type="text" class="form-control" id="rubro" name="rubro" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="descripcion">Descripcion </label>
                                                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="codcatalogo"> Cod Catalogo</label>
                                                        <input type="text" class="form-control" id="codcatalogo" name="codcatalogo" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="descripcioncatalogo">Catalogo</label>
                                                        <input type="text" class="form-control" id="descripcioncatalogo" name="descripcioncatalogo" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="precioref">Precio Ref</label>
                                                        <input type="text" class="form-control" id="precioref" name="precioref" required>
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
                                        onclick="window.location.href='<?php echo base_url(); ?>patrimonio/bienes_servicios'">
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
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>