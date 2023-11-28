<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certific_disp_presu extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Cdp_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Presupuesto_model");
		$this->load->library('form_validation');

	}
	public function index() {
        $numero_asiento = $this->input->get('numero_asiento');
        $this->mostrar_vista($numero_asiento);
    }

    public function busqueda_por_asiento() {
        $numero_asiento = $this->input->get('numero_asiento');
        $this->mostrar_vista($numero_asiento);
    }

    private function mostrar_vista($numero_asiento) {
        $data['datos_vista'] = $this->Cdp_model->obtener_datos_asiento($numero_asiento);

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/cdp/list", $data);
        $this->load->view("layouts/footer");
    }
	
}