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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/patrimonio/bienes_servicios">Listado
                        Bienes y/o Servicios</a></li>
                <li class="breadcrumb-item">Editar Bienes y/o Servicios</li>
            </ol>
        </nav>
        <div class="container-fluid bg-white border rounded-3">
            <div class="pagetitle">
                <div class="container-fluid d-flex flex-row justify-content-between">
                    <div class="col-md-6 mt-4">
                        <h1>Editar Bienes y/o Servicios</h1>
                    </div>
                </div>
            </div>
            <!-- fin del encabezado -->
            <hr> <!-- barra separadora -->
            <section class="seccion_editar_bien">
                <div class="container-fluid">
                    <div class="row">
                        <form action="<?php echo base_url(); ?>patrimonio/bienes_servicios/update" method="POST">
                            <div class="container-fluid mt-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row g-3 align-items-center mt-2">
                                                    <input type="hidden"
                                                        value="<?php echo $bienes_servicios->IDbienservicio; ?>"
                                                        name="IDbienservicio">
                                                    <div class="form-group col-md-4">
                                                        <label for="codigo">Codigo:</label>
                                                        <input type="text" class="form-control" id="codigo" name="codigo"
                                                            value="<?php echo $bienes_servicios->codigo ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="rubro">Rubro:</label>
                                                        <input type="text" class="form-control"
                                                            id="rubro" name="rubro"
                                                            value="<?php echo $bienes_servicios->rubro ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="descripcion">Descripcion:</label>
                                                        <input type="text" class="form-control" id="descripcion"
                                                            name="descripcion"
                                                            value="<?php echo $bienes_servicios->descripcion ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="codcatalogo">Cod Catalogo:</label>
                                                        <input type="text" class="form-control" id="codcatalogo"
                                                            name="codcatalogo"
                                                            value="<?php echo $bienes_servicios->codcatalogo ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="descripcioncatalogo">Catalogo:</label>
                                                        <input type="text" class="form-control" id="descripcioncatalogo"
                                                            name="descripcioncatalogo"
                                                            value="<?php echo $bienes_servicios->descripcioncatalogo ?>">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="precioref">Precio Ref:</label>
                                                        <input type="number" class="form-control" id="precioref"
                                                            name="precioref"
                                                            value="<?php echo $bienes_servicios->precioref ?>">
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
    <!-- Script de DataTable de jquery -->
    <script src="<?php echo base_url(); ?>/assets/DataTables/datatables.min.js"></script>
</body>

</html>