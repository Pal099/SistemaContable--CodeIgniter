<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Principal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Presupuesto_model");
        $this->load->model('Usuarios_model');   
        $this->load->model('Principal_model');   
        $this->load->model('Dashboard_model');   
        $this->load->model('CuentaContable_model');
    }

    public function index()
    {
        // Con la libreria Session traemos los datos del usuario
        // Obtenemos el nombre que nos va servir para obtener su id
        $nombre = $this->session->userdata('Nombre_usuario');

        // Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
        // id conseguido mediante el nombre del usuario
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        
        // Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
        // esa id es importante para hacer las relaciones y registros por usuario
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        
        // Debug: Verificar que los IDs no sean 0
        if($id_uni_respon_usu == 0 || empty($id_uni_respon_usu)) {
            log_message('error', 'Dashboard Error: id_uni_respon_usu es 0 o vacío para el usuario: ' . $nombre);
            // Datos por defecto si no hay configuración correcta
            $data['total_obligados_mes'] = 0;
            $data['total_pagados_mes'] = 0;
            $data['ingresos_mes'] = 0;
            $data['promedio_pago'] = 0;
            $data['total_obligados_anterior'] = 0;
            $data['total_pendientes'] = 0;
            $data['total_obligados_sin_pagar'] = 0;
            $data['gastos_mes'] = 0;
            $data['total_comprobantes'] = 0;
            $data['presupuesto_total'] = 0;
            $data['presupuesto_ejecutado'] = 0;
            $data['datos_grafico'] = ['obligados' => [0,0,0,0,0,0], 'pagados' => [0,0,0,0,0,0], 'meses' => ['Ene','Feb','Mar','Abr','May','Jun']];
            $data['top_proveedores'] = [];
            $data['ultimas_obligaciones'] = [];
            
            // Mostrar mensaje de error
            $data['error_message'] = 'Usuario no configurado correctamente. Contacte al administrador.';
        } else {
            // Obtener datos básicos
            $data['total_obligados_mes'] = $this->Principal_model->getCountObligadosMes($id_uni_respon_usu);
            $data['total_pagados_mes'] = $this->Principal_model->getCountPagadosMes($id_uni_respon_usu);
            
            // Obtener datos de ingresos
            $data['ingresos_mes'] = $this->Principal_model->getIngresosMes($id_uni_respon_usu);
            $data['promedio_pago'] = $this->Principal_model->getPromedioPago($id_uni_respon_usu);
            
            // Obtener datos adicionales del Dashboard
            $data['total_obligados_anterior'] = $this->Dashboard_model->getCountObligadosMesAnterior($id_uni_respon_usu);
            $data['total_pendientes'] = $this->Dashboard_model->getCountPendientes($id_uni_respon_usu);
            $data['total_obligados_sin_pagar'] = $this->Dashboard_model->getCountObligadosSinPagar($id_uni_respon_usu);
            
            // Obtener datos de gastos
            $gastos_data = $this->Dashboard_model->getGastosMes($id_uni_respon_usu);
            $data['gastos_mes'] = $gastos_data['gastos_mes'];
            $data['total_comprobantes'] = $gastos_data['total_comprobantes'];
            
            // Obtener datos de presupuesto
            $presupuesto_data = $this->Dashboard_model->getDatosPresupuesto($id_uni_respon_usu);
            $data['presupuesto_total'] = $presupuesto_data['presupuesto_total'];
            $data['presupuesto_ejecutado'] = $presupuesto_data['presupuesto_ejecutado'];
            
            // Obtener datos para gráficos
            $data['datos_grafico'] = $this->Dashboard_model->getTendenciasSeisMeses($id_uni_respon_usu);
            
            // Obtener datos adicionales
            $data['top_proveedores'] = $this->Dashboard_model->getTopProveedores($id_uni_respon_usu, 5);
            $data['ultimas_obligaciones'] = $this->Dashboard_model->getUltimasObligaciones($id_uni_respon_usu, 10);
        }

        // Obtener el nombre del mes en español
        $currentMonth = date('n'); // Obtener el mes actual en formato numérico (sin ceros a la izquierda)
        $data['monthInSpanish'] = $this->Principal_model->getMonthInSpanish($currentMonth);

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/principal", $data);
        $this->load->view("layouts/footer");
    }

    public function store()
    {
        // Aquí realiza el almacenamiento si es necesario
        // ...
    }

    public function add()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/categorias/add");
        $this->load->view("layouts/footer");
    }

    public function save($data)
    {
        // Aquí realiza el guardado si es necesario
        // ...
    }

    public function delete($id)
    {
        $data = array(
            'estado' => "0",
        );
        // Aquí realiza la eliminación si es necesario
        // ...
        echo "principal";
    }
}
