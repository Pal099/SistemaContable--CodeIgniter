<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>principal">
                <i class="bi bi-house"></i> <span>Inicio</span>
            </a>
        </li>
        <!-- Obligacion -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-clipboard-data"></i><span>Movimientos</span><i class="bi bi-chevron-down ms-auto"></i>
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
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>obligaciones/deposito_obligaciones/add">
                        <i class="bi bi-circle"></i><span>Depositos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/LibroMayor">
                        <i class="bi bi-circle"></i><span>Libro Mayor</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/LibroBanco">
                        <i class="bi bi-circle"></i><span>Libro Banco</span>
                    </a>
                </li>
            </ul>
        </li><!-- Acá termina lo de Obligacion -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav2" data-bs-toggle="collapse" href="#">
                <i class='bx bx-scatter-chart'></i><span>Balances</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/Balance_Gral">
                        <i class="bi bi-circle"></i><span>Balance General</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/cuadroderesultados">
                        <i class="bi bi-circle"></i><span>Cuadro de Resultados</span>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/Sys">
                        <i class="bi bi-circle"></i><span>Sumas y Saldos</span>
                    </a>
                </li>
            </ul>

        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav3" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash-stack"></i><span>Presupuesto</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav3" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/presupuesto">
                        <i class="bi bi-circle"></i><span>Presupuesto</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/EjecucionPc">
                        <i class="bi bi-circle"></i><span>Ejecución Presupuestaria</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>obligaciones/Certific_disp_presu">
                        <i class="bi bi-circle"></i><span>Certificado de Disponibilidad Presupuestaria</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/EjecucionPC">
                        <i class="bi bi-bar-chart"></i>
                        <span>Ejecución de Plan de Caja</span>
                    </a>
                </li>
            </ul>

        </li>

        <!-- Utilidades -->


        <li class="nav-item">
            
             <a class="nav-link collapsed" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash-stack"></i><span>Utilidades</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/proveedores">
                        <i class="bi bi-circle"></i><span>Proveedor</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/programa">
                        <i class="bi bi-circle"></i><span>Programas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable">
                        <i class="bi bi-circle"></i><span>Cuenta Contable</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/financiamiento">
                        <i class="bi bi-circle"></i><span>Fuente de financiamiento</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/origen">
                        <i class="bi bi-circle"></i><span>Origen de financiamiento</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/cuvdsvasdentas">
                        <i class="bi bi-circle"></i><span>Cuentas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/cuentavzdvss">
                        <i class="bi bi-circle"></i><span>Niveles</span>
                    </a>
                </li>
            </ul>
        </li><!-- Acá termina lo de Utilidades -->

        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>login/logout">
                <i class="bi bi-box-arrow-right"></i><span>Cerrar Sesión</span>
            </a>
        </li>

    </ul>
</aside><aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>principal">
                <i class="bi bi-house"></i> <span>Inicio</span>
            </a>
        </li>
        <!-- Obligacion -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-clipboard-data"></i><span>Movimientos</span><i class="bi bi-chevron-down ms-auto"></i>
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
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>obligaciones/deposito_obligaciones/add">
                        <i class="bi bi-circle"></i><span>Depositos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/LibroMayor">
                        <i class="bi bi-circle"></i><span>Libro Mayor</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/LibroBanco">
                        <i class="bi bi-circle"></i><span>Libro Banco</span>
                    </a>
                </li>
            </ul>
        </li><!-- Acá termina lo de Obligacion -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav2" data-bs-toggle="collapse" href="#">
                <i class='bx bx-scatter-chart'></i><span>Balances</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/Balance_Gral">
                        <i class="bi bi-circle"></i><span>Balance General</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/cuadroderesultados">
                        <i class="bi bi-circle"></i><span>Cuadro de Resultados</span>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/Sys">
                        <i class="bi bi-circle"></i><span>Sumas y Saldos</span>
                    </a>
                </li>
            </ul>

        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav3" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash-stack"></i><span>Presupuesto</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav3" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/presupuesto">
                        <i class="bi bi-circle"></i><span>Presupuesto</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/EjecucionP">
                        <i class="bi bi-circle"></i><span>Ejecución Presupuestaria</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>obligaciones/Certific_disp_presu">
                        <i class="bi bi-circle"></i><span>Certificado de Disponibilidad Presupuestaria</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?php echo base_url(); ?>mantenimiento/EjecucionPC">
                        <i class="bi bi-bar-chart"></i>
                        <span>Ejecución de Plan de Caja</span>
                    </a>
                </li>
            </ul>

        </li>

        <!-- Utilidades -->


        <li class="nav-item">

            <a class="nav-link collapsed" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash-stack"></i><span>Utilidades</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/proveedores">
                        <i class="bi bi-circle"></i><span>Proveedor</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/programa">
                        <i class="bi bi-circle"></i><span>Programas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/CuentaContable">
                        <i class="bi bi-circle"></i><span>Cuenta Contable</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/financiamiento">
                        <i class="bi bi-circle"></i><span>Fuente de financiamiento</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>registro/origen">
                        <i class="bi bi-circle"></i><span>Origen de financiamiento</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/cuentas">
                        <i class="bi bi-circle"></i><span>Cuentas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>mantenimiento/niveles">
                        <i class="bi bi-circle"></i><span>Niveles</span>
                    </a>
                </li>
            </ul>
        </li><!-- Acá termina lo de Utilidades -->
        <li class="nav-item">
            
            <a class="nav-link collapsed" data-bs-target="#components-nav5" data-bs-toggle="collapse" href="#">
               <i class="bi bi-basket2"></i><span>Patrimonio/Suministro</span><i class="bi bi-chevron-down ms-auto"></i>
           </a>
           <ul id="components-nav5" class="nav-content collapse " data-bs-parent="#sidebar-nav">
           <li class="nav-item">
                   <a href="<?php echo base_url(); ?>patrimonio/comprobante_gasto">
                       <i class="bi bi-circle"></i><span>Comprobante de Gastos</span>
                   </a>
               </li> 
               <li class="nav-item">
                   <a href="<?php echo base_url(); ?>patrimonio/recepcion_bienes">
                       <i class="bi bi-circle"></i><span>Recepcion de Bienes</span>
                   </a>
               </li>
               <li class="nav-item">
                   <a href="<?php echo base_url(); ?>patrimonio/bienes_servicios">
                       <i class="bi bi-circle"></i><span>Bienes y/o Servicios</span>
                   </a>
               </li>
               <li class="nav-item">
                   <a href="<?php echo base_url(); ?>patrimonio/pedido_material">
                       <i class="bi bi-circle"></i><span>Pedido Material</span>
                   </a>
               </li>
           </ul>
       </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>login/logout">
                <i class="bi bi-box-arrow-right"></i><span>Cerrar Sesión</span>
            </a>
        </li>

    </ul>
</aside>