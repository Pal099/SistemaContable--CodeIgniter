<!-- ==== Sidebar ============================= -->
<!-- Left side column. contains the sidebar -->
<aside id="sidebar" class="sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <!--<section class="sidebar">      
                 sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>">
                                <i class="bi bi-grid"></i> <span>Inicio</span>
                        </a>
                </li>


                <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#mant-nav" data-bs-toggle="collapse" href="#">
                                <i class="bi bi-menu-button-wide"></i><span>Mantenimiento</span><i
                                        class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li><a href="<?php echo base_url(); ?>mantenimiento/proveedores"><i
                                                        class="bi bi-circle"></i> Proveedores</a></li>


                        </ul>
                        <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li><a href="<?php echo base_url(); ?>mantenimiento/productos"><i
                                                        class="bi bi-circle"></i> Productos</a></li>


                        </ul>
                        <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li><a href="<?php echo base_url(); ?>mantenimiento/presupuesto"><i
                                                        class="bi bi-circle"></i> Presupuesto</a></li>


                        </ul>
                        <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                                <li><a href="<?php echo base_url(); ?>mantenimiento/categorias"><i
                                                        class="bi bi-circle"></i> Categorias</a></li>


                        </ul>
                </li>
                <span>Filtrar productos por categoria</span>
                <li class="nav-item">

                        <select name="id_categoria" id="id_categoria" onchange="ShowSelected();">
                                <option value="" disabled selected>Seleccione una Categoria:</option>
                                <option value="">Otro</option>
                                @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}
                                        @endforeach
                        </select>
                        <a href="<?php echo base_url(); ?>mantenimiento/categorias/add"
                                class="btn btn-primary btn-flat">
                                Filtrar </a>
                </li>
                <span>Filtrar productos por proveedor</span>
                <li class="nav-item">
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                        </select>
                        <a href="<?php echo base_url(); ?>mantenimiento/categorias/add"
                                class="btn btn-primary btn-flat">Filtrar </a>
                </li>
                <script>
                        $(document).ready(function () {
                                var id = $('#addLocationIdReq').val();    //#addLocationIdReq es el identificador
                                // de tu elemento
                                alert(id);
                        });
                </script>
        </ul>

</aside>
<!-- =============================================== -->