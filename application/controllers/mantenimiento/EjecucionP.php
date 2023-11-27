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
    $id_uni_respon_usu = $this->session->userdata('id_uni_respon_usu');

    // Ahora pasamos el ID como argumento al método getEjecucionesP().
    $data = array(
        'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP($id_uni_respon_usu),
    );

    // Cargar vistas con datos
    $this->load->view("layouts/header");
    $this->load->view("layouts/aside");
    $this->load->view("admin/ejecucion/list_eje", $data);
    $this->load->view("layouts/footer");
}

	public function view($id){
		$data = array(
			'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionP($id),
			'presupuestos' => $this->Presupuesto_model->getPresupuestos(),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
		);
		$this->load->view("admin/ejecucion/view_eje", $data);
	}
	
}