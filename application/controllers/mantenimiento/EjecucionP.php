<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EjecucionP extends CI_Controller
{

    //private $permisos;
    public function __construct()
    {
        parent::__construct();
        //	$this->permisos= $this->backend_lib->control();
        $this->load->model("EjecucionP_model");
        $this->load->model("Presupuesto_model");
        $this->load->model("CuentaContable_model");
        $this->load->model("Pago_obli_model");
        $this->load->model("Diario_obli_model");
        $this->load->model('Usuarios_model');
        $this->load->model("Registros_financieros_model");
		$this->load->model("Origen_model");
		$this->load->model('ProgramGasto_model');


    }


    public function index()
    {
        // Obtener parámetros de fechas
        $fecha_inicio = $this->input->get('fecha_inicio') ?? date('Y-01-01');
        $fecha_fin = $this->input->get('fecha_fin') ?? date('Y-12-31');
        
        // Obtener datos del usuario
        $nombre = $this->session->userdata('Nombre_usuario');
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        // Obtener datos principales
        $data = array(
            'ejecucionpresupuestaria' => $this->EjecucionP_model->obtener_ejecuciones_para_vista($fecha_inicio, $fecha_fin),
            'fuente' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
            'origen' => $this->Origen_model->getOrigenes($id_uni_respon_usu),
            'programa' => $this->ProgramGasto_model->getProgramGastos($id_uni_respon_usu),
            'cuentas' => $this->CuentaContable_model->getCuentasContables($id_uni_respon_usu),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        );

        // Calcular campos derivados
        foreach($data['ejecucionpresupuestaria'] as &$item) {
            $item->Vigente = ($item->TotalPresupuestado ?? 0) + ($item->TotalModificado ?? 0);
            $item->SaldoPresupuestario = ($item->obligado ?? 0) - ($item->pagado ?? 0);
        }

        // Cargar vistas
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/ejecucion/list_eje", $data);
        $this->load->view("layouts/footer");
    }

    public function obtener_ejecucion_completa() {
        // Validar parámetros
        $cuenta_id = $this->input->get('cuenta_id');
        $fecha_inicio = $this->input->get('fecha_inicio');
        $fecha_fin = $this->input->get('fecha_fin');

        if (empty($cuenta_id) || empty($fecha_inicio) || empty($fecha_fin)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Parámetros incompletos']));
        }

        // Validar formato de fechas
        if (!DateTime::createFromFormat('Y-m-d', $fecha_inicio) || 
            !DateTime::createFromFormat('Y-m-d', $fecha_fin)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Formato de fecha inválido']));
        }

        // Obtener datos
        $resultado = $this->EjecucionP_model->obtener_ejecucion_completa(
            $cuenta_id, 
            $fecha_inicio, 
            $fecha_fin
        );

        // Formatear números
        foreach ($resultado as $key => $value) {
            $resultado[$key] = number_format($value, 0, ',', '.');
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($resultado));
    }

    public function view($id)
    {
        $data = array(
            'sumaDebePorCuenta' => $this->EjecucionP_model->getSumaDebePorCuenta(),
        );

        // Cargar vistas con datos
        $this->load->view("layouts/header");
		$this->load->view("layouts/aside");
        // Asegúrate de crear la vista 'reporte_ejecucion_presupuestaria' en la carpeta correspondiente
        $this->load->view("admin/ejecucion/list_eje", $data);
        $this->load->view("layouts/footer");
    }

}