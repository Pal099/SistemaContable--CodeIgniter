<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
	}

	
	public function index()
	{
		$data  = array(
			'proveedores' => $this->Proveedores_model->getProveedores(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$ruc = $this->input->post("ruc");
		$razon_social = $this->input->post("razon_social");
		$propietario = $this->input->post("propietario");
		$direccion= $this->input->post("direccion");
		$telefono= $this->input->post("telefono");
		$email= $this->input->post("email");
		$observacion = $this->input->post("observacion");
		$this->form_validation->set_rules("ruc","Ruc","required|is_unique[proveedores.ruc]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'ruc' => $ruc, 
				'razon_social' => $razon_social,
				'propietario' => $propietario,
				'direccion' => $direccion,
				'telefono' => $telefono,
				'email' => $email,
				'observacion' => $observacion,
				'estado' => "1"
			);

			if ($this->Proveedores_model->save($data)) {
				redirect(base_url()."mantenimiento/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/proveedores/add");
			}
		}
		else{
			$this->add();
		}

		
	}

	public function edit($id){
		$data  = array(
			'proveedor' => $this->Proveedores_model->getProveedor($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idProveedores = $this->input->post("idProveedores");
		$ruc = $this->input->post("ruc");
		$razon_social = $this->input->post("razon_social");
		$telefono = $this->input->post("telefono");
		$propietario = $this->input->post("propietario");
		$telefono = $this->input->post("telefono");
		$email= $this->input->post("email");
		$observacion= $this->input->post("observacion");

		$proveedoractual = $this->Proveedores_model->getProveedor($idProveedores);

		if ($ruc == $proveedoractual->ruc) {
			$is_unique = "";
		}else{
			$is_unique = "|is_unique[proveedor.ruc]";
		}
		
		$this->form_validation->set_rules("ruc","Ruc","required".$is_unique);
		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'ruc' => $ruc, 
				'razon_social' => $razon_social,
				'propietario' => $propietario,
				'direccion' => $direccion,	
				'telefono' => $telefono,
				'email' => $email,
				'observacion' => $observacion,
			);

			if ($this->Proveedores_model->update($idProveedores,$data)) {
				redirect(base_url()."mantenimiento/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/proveedores/edit/".$idProveedores);
			}
		}else{
			$this->edit($idProveedores);
		}
		
	}

	public function view($id){
		$data  = array(
			'proveedor' => $this->Proveedores_model->getProveedor($id), 
		);
		$this->load->view("admin/proveedores/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Proveedores_model->update($id,$data);
		echo "mantenimiento/proveedores";
	}
}
