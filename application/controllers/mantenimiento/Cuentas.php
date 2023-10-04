<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Cuentas_model");
	}

	
	public function index()
	{
		$data  = array(
			'bancos' => $this->Cuentas_model->getCuentas(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/cuentas/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/cuentas/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$idCuentas = $this->input->post("idCuentas");
		$cta_banco = $this->input->post("cta_banco");
		$cta_descri = $this->input->post("cta_descri");
		$cta_moneda = $this->input->post("cta_moneda");
		$cta_numero = $this->input->post("cta_numero");
        $cta_fecini = $this->input->post("cta_fecini");
        $cta_feccie = $this->input->post("cta_feccie");
			$data  = array(
				'cta_banco' => $cta_banco, 
                'cta_descri' => $cta_descri,
                'cta_moneda' => $cta_moneda,
                'cta_numero' => $cta_numero,
                'cta_fecini' => $cta_fecini,
                'cta_feccie' => $cta_feccie,    
				'estado' => "1"
			);

			if ($this->Cuentas_model->save($data)) {
				redirect(base_url()."mantenimiento/cuentas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/cuentas/add");
			}
	}

	public function edit($id){
		$data  = array(
			'bancos' => $this->Cuentas_model->getCuenta($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/cuentas/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idCuentas = $this->input->post("idCuentas");
		$cta_banco = $this->input->post("cta_banco");
		$cta_descri = $this->input->post("cta_descri");
		$cta_moneda = $this->input->post("cta_moneda");
		$cta_numero = $this->input->post("cta_numero");
        $cta_fecini = $this->input->post("cta_fecini");
        $cta_feccie = $this->input->post("cta_feccie");
			$data  = array(
				'cta_banco' => $cta_banco, 
                'cta_descri' => $cta_descri,
                'cta_moneda' => $cta_moneda,
                'cta_numero' => $cta_numero,
                'cta_fecini' => $cta_fecini,
                'cta_feccie' => $cta_feccie,    
				'estado' => "1"
			);

			if ($this->Cuentas_model->update($idCuentas,$data)) {
				redirect(base_url()."mantenimiento/cuentas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/cuentas/edit/".$idCuentas);
			}
		
	}

	public function view($id){
		$data  = array(
			'cuentas' => $this->Cuentas_model->getCuenta($id), 
		);
		$this->load->view("admin/cuentas/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Cuentas_model->update($id,$data);
		echo "mantenimiento/cuentas";
	}
}
