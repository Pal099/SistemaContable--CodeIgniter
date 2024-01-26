<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcion_Bienes extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Recepcion_Bienes_model");
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
		$id = $this->input->post("IDRecepcionBienes");
		$data  = array(
			'bienes' => $this->Recepcion_Bienes_model->getRecepcionesBienes($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getproveedores($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/add");
		$this->load->view("layouts/footer");
	}

	public function store() {
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$nro = $this->input->post("nro");
		$fecha = $this->input->post("fecha");
		$plazo = $this->input->post("plazo");
		$id_proveedor = $this->input->post("id_proveedor");
		$monto = $this->input->post("monto");
		$observacion = $this->input->post("observacion");
		$this->form_validation->set_rules("nro", "Nro", "required|is_unique[recepcion_bienes.nro]");
		$this->form_validation->set_rules("fecha","Fecha","required|is_unique[recepcion_bienes.fecha]");
		$this->form_validation->set_rules("plazo","Plazo","required|is_unique[recepcion_bienes.plazo]");
		$this->form_validation->set_rules("id_proveedor","Proveedor","required|is_unique[recepcion_bienes.id_proveedor]");
		$this->form_validation->set_rules("monto","Monto","required|is_unique[recepcion_bienes.monto]");
		$this->form_validation->set_rules("observacion","Observacion","required|is_unique[recepcion_bienes.observacion]");

	
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nro' => $nro,
				'fecha' => $fecha,
				'plazo' => $plazo,
				'id_proveedor' => $id_proveedor,
				'monto' => $monto,
				'observacion' => $observacion,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => "1",
				
			);
	
			if ($this->Recepcion_Bienes_model->save($data)) {
				redirect(base_url() . "patrimonio/recepcionbienes");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la información");
				redirect(base_url() . "patrimonio/recepcionbienes/add");
			}
		} else {
			$this->add();
		}
	}
	

	public function edit($id){
		$data  = array(
			'bienes' => $this->Recepcion_Bienes_model->getRecepcionBien($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$IDRecepcionBienes = $this->input->post("IDRecepcionBienes");
		$nro = $this->input->post("nro");
		$fecha = $this->input->post("fecha");
		$id_proveedor = $this->input->post("id_proveedor");
		$plazo= $this->input->post("plazo"); 
		$monto= $this->input->post("monto");
		$observacion= $this->input->post("observacion");

		$proveedoractual = $this->Recepcion_Bienes_model->getRecepcionBien($IDRecepcionBienes);


		
		
		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nro' => $nro, 
				'fecha' => $fecha,
				'plazo' => $plazo,	
				'id_proveedor' => $id_proveedor,
				'monto' => $monto,
				'observacion' => $observacion,
			);

			if ($this->Recepcion_Bienes_model->update($IDRecepcionBienes,$data)) {
				redirect(base_url()."patrimonio/recepcionbienes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."patrimonio/recepcionbienes/edit/".$IDRecepcionBienes);
			}
		}else{
			$this->edit($IDRecepcionBienes);
		}
		
	}
	
	public function view($id){
		$data  = array(
			'proveedor' => $this->Recepcion_Bienes_model->getRecepcionBien($id), 
		);
		$this->load->view("admin/recepcionbienes/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Recepcion_Bienes_model->update($id,$data);
		echo "patrimonio/recepcionbienes";
	}
	public function getBienDetalle($id) {
		$BienDetalle = $this->Recepcion_Bienes_model->getRecepcionBien($id);
		echo json_encode($BienDetalle);
	}
}