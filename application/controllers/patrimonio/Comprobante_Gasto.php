<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante_Gasto extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Comprobante_Gasto_model");
		$this->load->model("Bienes_Servicios_model");
		$this->load->library('session');
		$this->load->model("Usuarios_model");
		$this->load->model("Proveedores_model");
		$this->load->model("Registros_financieros_model");
		$this->load->model("Unidad_academica_model");
		$this->load->library('form_validation');

	}

	public function index()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			
		);
		//var_dump($data['proveedores']);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/list",$data);
		$this->load->view("layouts/footer");
	}

	public function filtrar()
	{
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDComprobanteGasto");
		$actividad = $this->input->post("actividad");
		$fuente = $this->input->post("fuente");
		$periodo = $this->input->post("periodo");
		$mes = $this->input->post("mes");
		if (empty($actividad) && empty($fuente) && empty($periodo) && empty($mes)) {
			// Ningún campo seleccionado, redireccionar o mostrar un mensaje de error
			redirect(base_url() . "patrimonio/comprobantegasto");
		}
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastosFiltrados($actividad, $fuente, $periodo, $mes),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getProveedores($id_uni_respon_usu),
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'bienes_servicios' => $this->Bienes_Servicios_model->getBienesServicios($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store() {
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id_unidad = $this->input->post("id_unidad");
		$fecha = $this->input->post("fecha");
		$idproveedor = $this->input->post("idproveedor");
		$monto = $this->input->post("monto");
		$concepto = $this->input->post("concepto");
		$aprobado = $this->input->post("aprobado");
		$id_ff = $this->input->post("id_ff");
		$obl = $this->input->post("obl");
		$str = $this->input->post("str");
		$op = $this->input->post("op");

		
		
		$concepto = $this->input->post("concepto");

			$data = array(
				'id_unidad' => $id_unidad,
				'fecha' => $fecha,
				'aprobado' => $aprobado,
				'idproveedor' => $idproveedor,
				'monto' => $monto,
				'concepto' => $concepto,
				'id_ff' => $id_ff,
				'obl' => $obl,
				'str' => $str,
				'op' => $op,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => "1",
				
			);
	
			if ($this->Comprobante_Gasto_model->save($data)) {
				redirect(base_url() . "patrimonio/comprobantegasto");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la información");
				redirect(base_url() . "patrimonio/comprobantegasto/add");
			}
	}
	

	public function edit($id){
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobanteGasto($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/comprobantegasto/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$IDComprobanteGasto = $this->input->post("IDComprobanteGasto");
		$id_unidad = $this->input->post("id_unidad");
		$fecha = $this->input->post("fecha");
		$idproveedor = $this->input->post("idproveedor");
		$aprobado= $this->input->post("aprobado"); 
		$monto= $this->input->post("monto");
		$concepto= $this->input->post("concepto");
		$aprobado = $this->input->post("aprobado");
		$id_ff = $this->input->post("id_ff");
		$obl = $this->input->post("obl");
		$str = $this->input->post("str");
		$op = $this->input->post("op");

		$comprobanteactual = $this->Comprobante_Gasto_model->getComprobanteGasto($IDComprobanteGasto);

			$data = array(
				'id_unidad' => $id_unidad, 
				'fecha' => $fecha,
				'aprobado' => $aprobado,	
				'idproveedor' => $idproveedor,
				'monto' => $monto,
				'concepto' => $concepto,
				'id_ff' => $id_ff,
				'obl' => $obl,
				'str' => $str,
				'op' => $op,
			);

			if ($this->Comprobante_Gasto_model->update($IDComprobanteGasto,$data)) {
				redirect(base_url()."patrimonio/comprobantegasto");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."patrimonio/comprobantegasto/edit/".$IDComprobanteGasto);
			}
		
	}
	
	public function view($id){
		$data  = array(
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobanteGasto($id), 
		);
		$this->load->view("admin/comprobantegasto/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comprobante_Gasto_model->update($id,$data);
		redirect(base_url() . "patrimonio/bienes_servicios");
	}
	public function getComprobanteDetalle($id) {
		$ComprobanteDetalle = $this->Comprobante_Gasto_model->getComprobanteGasto($id);
		echo json_encode($ComprobanteDetalle);
	}
}