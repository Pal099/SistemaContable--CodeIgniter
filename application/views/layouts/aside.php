<!-- ==== Sidebar ============================= -->
<!-- Left side column. contains the sidebar -->
<aside id="sidebar" class="sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <!--<section class="sidebar">      
        sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>">
                <i class="bi bi-grid"></i> <span>Inicio</span>
            </a>
        </li>                 
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#mant-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Mantenimiento</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="mant-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo base_url(); ?>mantenimiento/categorias"><i class="bi bi-circle"></i> Categoria</a></li>
                <li><a href="<?php echo base_url(); ?>mantenimiento/proveedores"><i class="bi bi-circle"></i> Proveedores</a></li>
                <li><a href="<?php echo base_url(); ?>mantenimiento/productos"><i class="bi bi-circle"></i> Productos</a></li>
                <li><a href="<?php echo base_url(); ?>mantenimiento/bancos"><i class="bi bi-circle"></i> Bancos</a></li>
                <li><a href="<?php echo base_url(); ?>mantenimiento/cuentas"><i class="bi bi-circle"></i> Cuentas</a></li>

            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#filtro-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Filtrar</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="filtro-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo base_url(); ?>filtro/seleccion"><i class="bi bi-circle"></i> Filtrar por categorías o proveedores</a></li>                       
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#registros-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Registrar</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="registros-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo base_url(); ?>registro/financiamiento"><i class="bi bi-circle"></i> Fuente de financiamiento</a></li>                       
                <li><a href="<?php echo base_url(); ?>registro/origen"><i class="bi bi-circle"></i> Origen de financiamiento</a></li>                       
                <li><a href="<?php echo base_url(); ?>registro/programagasto"><i class="bi bi-circle"></i> Programa de gastos</a></li>                       
                <li><a href="<?php echo base_url(); ?>registro/programaingreso"><i class="bi bi-circle"></i> Programa de ingresos</a></li>                       
                      
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#diario-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Actualizar</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="diario-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones"><i class="bi bi-circle"></i> Diario de obligaciones</a></li>                       
                      
            </ul>
        </li>
    </ul>
</aside>
<!-- =============================================== -->
