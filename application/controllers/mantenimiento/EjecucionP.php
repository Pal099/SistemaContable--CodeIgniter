<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EjecucionP extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
	$this->load->model("EjecucionP_model");
	$this->load->model("Presupuesto_model");
	$this->load->model("CuentaContable_model");
	$this->load->model("Pago_obli_model");
	$this->load->model("Diario_obli_model");

	}

	
	public function index()
{
    // Suponiendo que $id_uni_respon_usu se obtenga de la sesión del usuario o mediante algún otro método.
    //$id_uni_respon_usu = $this->session->userdata('id_uni_respon_usu');

    // Ahora pasamos el ID como argumento al método getEjecucionesP().
    $data = array(
        'ejecucionpresupuestaria' => $this->EjecucionP_model->getSumaDebePorCuenta(),
    );

    // Cargar vistas con datos
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("admin/ejecucion/list_eje", $data);
    $this->load->view("layouts/footer");
}

	public function view($id){
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