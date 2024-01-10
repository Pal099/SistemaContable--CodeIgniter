<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>principal">
                <i class="bi bi-house"></i>
                <span>Inicio</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Obligacion -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-book"></i><span>Obligación</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo base_url(); ?>obligaciones/diario_obligaciones/add">
                        <i class="bi bi-circle"></i><span>Diario de Obligación</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>obligaciones/pago_de_obligaciones/add">
                        <i class="bi bi-circle"></i><span>Pago de obligaciones</span>
                    </a>
                </li>
            </ul>
        </li><!-- Acá termina lo de Obligacion -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>obligaciones/deposito_obligaciones/add">
                <i class="bi bi-cash-stack"></i>
                <span>Depositos</span>
            </a>
        </li><!-- Deposito -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/Balance_Gral">
                <i class="bi bi-graph-up"></i>
                <span>Balance General</span>
            </a>
        </li><!-- Balance general -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/presupuesto">
                <i class="bi bi-bar-chart"></i>
                <span>Presupuesto</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/proveedores">
                <i class="bi bi-person"></i><span>Proveedor</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>registro/programa">
                <i class="bi bi-journal-check"></i><span>Programas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/CuentaContable">
                <i class="bi bi-person"></i><span>Cuenta Contable</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>registro/financiamiento">
                <i class="bi bi-cash-stack"></i><span>Fuente de financiamiento</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>registro/origen">
                <i class="bi bi-graph-up"></i><span>Origen de financiamiento</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo base_url(); ?>login/logout">
                <i class="bi bi-box-arrow-right"></i><span>Cerrar Sesión</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->