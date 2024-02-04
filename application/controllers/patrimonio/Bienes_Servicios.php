<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienes_Servicios extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Bienes_Servicios_model");
		$this->load->library('session');
		$this->load->model("Usuarios_model");
		$this->load->model("Proveedores_model");
		$this->load->model("Comprobante_Gasto_model");
	}

	

	
	
	public function index()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDbienservicio");
		$data  = array(
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/bienesyservicios/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/bienesyservicios/add");
		$this->load->view("layouts/footer");
	}

	public function store()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$codigo = $this->input->post("codigo");
		$rubro = $this->input->post("rubro");
		$descripcion = $this->input->post("descripcion");
		$codcatalogo = $this->input->post("codcatalogo");
		$descripcioncatalogo = $this->input->post("descripcioncatalogo");
		$precioref = $this->input->post("precioref");

		$data = array(
			'codigo' => $codigo,
			'rubro' => $rubro,
			'descripcion' => $descripcion,
			'codcatalogo' => $codcatalogo,
			'descripcioncatalogo' => $descripcioncatalogo,
			'precioref' => $precioref,
			'id_uni_respon_usu' => $id_uni_respon_usu,
			'estado' => "1",

		);

		if ($this->Bienes_Servicios_model->save($data)) {
			redirect(base_url() . "patrimonio/bienes_servicios");
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			redirect(base_url() . "patrimonio/bienes_servicios/add");
		}
	}
	

	public function edit($id){
		$data  = array(
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienServicio($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/bienesyservicios/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$IDbienservicio = $this->input->post("IDbienservicio");
		$codigo = $this->input->post("codigo");
		$rubro = $this->input->post("rubro");
		$codcatalogo = $this->input->post("codcatalogo");
		$descripcion= $this->input->post("descripcion"); 
		$descripcioncatalogo= $this->input->post("descripcioncatalogo");
		$precioref= $this->input->post("precioref");

			$data = array(
				'codigo' => $codigo, 
				'rubro' => $rubro,
				'descripcion' => $descripcion,	
				'codcatalogo' => $codcatalogo,
				'descripcioncatalogo' => $descripcioncatalogo,
				'precioref' => $precioref,
			);

			if ($this->Bienes_Servicios_model->update($IDbienservicio,$data)) {
				redirect(base_url()."patrimonio/bienes_servicios");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."patrimonio/bienes_servicios/edit/".$IDbienservicio);
			}		
	}
	
	public function view($id){
		$data  = array(
			'proveedor' => $this->Bienes_Servicios_model->getBienServicio($id), 
		);
		$this->load->view("admin/bienesyservicios/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Bienes_Servicios_model->update($id,$data);
		redirect(base_url() . "patrimonio/bienes_servicios");
	}
	public function getBienDetalle($id) {
		$BienDetalle = $this->Bienes_Servicios_model->getBienServicio($id);
		echo json_encode($BienDetalle);
	}
}