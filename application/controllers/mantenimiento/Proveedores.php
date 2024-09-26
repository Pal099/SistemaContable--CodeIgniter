<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->library('session');
		$this->load->model("Usuarios_model");
		
	}

	

	
	
	public function index()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$this->form_validation->set_rules("ruc","Ruc","required|is_unique[proveedores.ruc]");
		
		$data  = array(
			'proveedores' => $this->Proveedores_model->getproveedores($id_uni_respon_usu ),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/proveedores/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/proveedores/add");
		$this->load->view("layouts/footer");
	}

	public function store() {
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$ruc = $this->input->post("ruc");
		$razon_social = $this->input->post("razon_social");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$observacion = $this->input->post("observacion");

		$this->form_validation->set_rules("ruc", "RUC", "required|is_unique[proveedores.ruc]", array(
			'required' => 'El campo RUC es obligatorio.',
			'is_unique' => 'El RUC ya está registrado.'
		));
		$this->form_validation->set_rules("razon_social", "Razón Social", "required", array(
			'required' => 'El campo Razón Social es obligatorio.'
		));
		$this->form_validation->set_rules("direccion", "Dirección", "required", array(
			'required' => 'El campo Direccion es obligatorio.'
		));
		$this->form_validation->set_rules("telefono", "Teléfono", "required", array(
			'required' => 'El campo Telefono es obligatorio.'
		));
		$this->form_validation->set_rules("email", "Email", "required", array(
			'required' => 'El campo Email es obligatorio.'
		));
		$this->form_validation->set_rules("observacion", "Observación", "required", array(
			'required' => 'El campo Observación es obligatorio.'
		));

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'ruc' => $ruc,
				'razon_social' => $razon_social,
				'direccion' => $direccion,
				'telefono' => $telefono,
				'email' => $email,
				'observacion' => $observacion,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => "1",
				
			);
	
			if ($this->Proveedores_model->save($data)) {
				redirect(base_url() . "mantenimiento/proveedores");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la información");
				redirect(base_url() . "mantenimiento/proveedores/add");
			}
		} else {
			$this->add();
		}
	}
	

	public function edit($id){
		$data  = array(
			'proveedor' => $this->Proveedores_model->getProveedor($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/proveedores/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idProveedores = $this->input->post("idProveedores");
		$ruc = $this->input->post("ruc");
		$razon_social = $this->input->post("razon_social");
		$telefono = $this->input->post("telefono");
		$direccion= $this->input->post("direccion"); 
		$email= $this->input->post("email");
		$observacion= $this->input->post("observacion");

		$proveedoractual = $this->Proveedores_model->getProveedor($idProveedores);

		if ($ruc == $proveedoractual->ruc) {
			$is_unique = "";
		}else{
			$is_unique = "|is_unique[proveedores.ruc]";
		}
		
		$this->form_validation->set_rules("ruc","Ruc","required".$is_unique);
		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'ruc' => $ruc, 
				'razon_social' => $razon_social,
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
		redirect(base_url() . "mantenimiento/proveedores");
	}
}