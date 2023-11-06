<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
	$this->load->model("EjecucionP_model");
	$this->load->model("Presupuesto_model");
	$this->load->model("CuentaContable_model");
	}

	
	public function index()
	{
		$data  = array(
			'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ejecucionp/list", $data);
		$this->load->view("layouts/footer");

	}

	public function view($id){
		$data = array(
			'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionP($id),
			'presupuestos' => $this->Presupuesto_model->getPresupuestos(),
			'cuentacontable' => $this->CuentaContable_model->getCuentasContables(),
		);
		$this->load->view("admin/presupuesto/view", $data);
	}
}