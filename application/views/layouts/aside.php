        <!-- ==== Sidebar ============================= -->
        <!-- Left side column. contains the sidebar -->
        <aside id="sidebar" class="sidebar">
               <!-- sidebar: style can be found in sidebar.less -->
               <!--<section class="sidebar">      
                 sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-nav" id="sidebar-nav">
               <li class="nav-item">
                  <a class="nav-link " href="<?php echo base_url();?>">
                            <i class="bi bi-grid"></i> <span>Inicio</span>
                        </a>
                </li>

                 
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#mant-nav" data-bs-toggle="collapse" href="#">
                       <i class="bi bi-menu-button-wide"></i><span>Mantenimiento</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li><a href="<?php echo base_url(); ?>mantenimiento/categorias"><i class="bi bi-circle"></i> Categoria</a></li>
                           
                                                
                    </ul>

                            <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li><a href="<?php echo base_url(); ?>mantenimiento/proveedores"><i class="bi bi-circle"></i> Proveedores</a></li>
                           
                                                
                    </ul>

                            <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li><a href="<?php echo base_url(); ?>mantenimiento/productos"><i class="bi bi-circle"></i> Productos</a></li>
                           
                                                
                    </ul>

                </li>
                
            </ul>
            
        </aside>
        <!-- =============================================== -->