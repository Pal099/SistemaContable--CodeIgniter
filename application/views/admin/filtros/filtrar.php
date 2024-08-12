<main id="main" class="main">
    <div class="pagetitle">
        <h1>Aquí puedes filtrar por categoría o por proveedor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Inicio</a></li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url('filtro/seleccion/filtrar'); ?>" method="get">
                            <label for="categoria">Filtrar por categoría:</label>
                            <?php
                            $options = array();

                            foreach ($categorias as $categoria) { //Aquí llamamos a la variable categorias.
                                $options[$categoria->id] = $categoria->nombre;
                            }

                            echo form_dropdown('categoria', $options, $this->input->get('categoria'), 'id="categoria"');
                            ?>
                            <input type="submit" value="Filtrar">
                        </form>

                        <form action="<?php echo base_url('filtro/seleccion/filtrar'); ?>" method="get">
                            <label for="proveedor">Filtrar por proveedor:</label>
                            <?php
                            $options = array();

                            foreach ($proveedor as $proveedor) { //Aquí llamamos a la variable proveedor.
                                $options[$proveedor->id] = $proveedor->propietario;
                            }

                            echo form_dropdown('proveedor', $options, $this->input->get('proveedor'), 'id="proveedor"');
                            ?>
                            <input type="submit" value="Filtrar">
                        </form>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio Venta</th>
                                    <th>Precio Compra</th>
                                    <th>Existencia</th>
                                    <th>Stock Minimo</th>
                                    <th>Categoria</th>
                                    <th>Proveedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($productos)):?> 
                                    <?php foreach($productos as $producto):?>        
                                        <tr>
                                            <td><?php echo $producto->id;?></td>
                                            <td><?php echo $producto->codigo;?></td>
                                            <td><?php echo $producto->nombre;?></td>
                                            <td><?php echo $producto->precio_venta;?></td>
                                            <td><?php echo $producto->precio_compra;?></td>
                                            <td><?php echo $producto->existencia;?></td>
                                            <td><?php echo $producto->stock_minimo;?></td>
                                            <td><?php echo $producto->cate;?></td>
                                            <td><?php echo $producto->prop;?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>

                            <tbody>
                                <?php if(!empty($productoprov)):?> 
                                    <?php foreach($productoprov as $producto):?>        
                                        <tr>
                                            <td><?php echo $producto->id;?></td>
                                            <td><?php echo $producto->codigo;?></td>
                                            <td><?php echo $producto->nombre;?></td>
                                            <td><?php echo $producto->precio_venta;?></td>
                                            <td><?php echo $producto->precio_compra;?></td>
                                            <td><?php echo $producto->existencia;?></td>
                                            <td><?php echo $producto->stock_minimo;?></td>
                                            <td><?php echo $producto->cate;?></td>
                                            <td><?php echo $producto->prop;?></td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>



                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
