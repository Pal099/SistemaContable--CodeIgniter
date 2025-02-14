<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recepcion_Bienes extends MY_Controller
{

	//private $permisos;
	public function __construct()
	{
		parent::__construct();
		//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Recepcion_Bienes_model");
		$this->load->library('session');
		$this->load->model("Usuarios_model");
		$this->load->model("Proveedores_model");
		$this->load->model("Unidad_academica_model");
		$this->load->model("Comprobante_Gasto_model");
		$this->load->model("Funcionarios_model");
	}





	public function index()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$id = $this->input->post("IDRecepcionBienes");
		$data = array(
			'bienes' => $this->Recepcion_Bienes_model->getRecepcionesBienes($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getproveedores($id_uni_respon_usu),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/list", $data);
		$this->load->view("layouts/footer");

	}

	public function add()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$data = array(
			'bienes' => $this->Recepcion_Bienes_model->getRecepcionesBienes($id_uni_respon_usu),
			'proveedores' => $this->Proveedores_model->getproveedores($id_uni_respon_usu),
			'comprobantes' => $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'funcionarios' => $this->Funcionarios_model->getFuncionarios($id_uni_respon_usu),
			'dependencia' => $this->Funcionarios_model->getDependencias(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store()
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$nro = $this->input->post("nro");
		$fecha = $this->input->post("fecha");
		$plazo = $this->input->post("plazo");
		$id_proveedor = $this->input->post("id_Proveedor");
		$monto = $this->input->post("monto");
		$observacion = $this->input->post("observacion");
		$unidad = $this->input->post("id_Unidad");
		$depedencia = $this->input->post("id_Dependencia");
		$funcionario = $this->input->post("id_Funcionario");
		$comprobante = $this->input->post("idcomprobante");


		$this->form_validation->set_rules("nro", "Nro", "required[recepcion_bienes.nro]");

		$this->form_validation->set_rules("monto", "Monto", "required[recepcion_bienes.monto]");


		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nro' => $nro,
				'fecha' => $fecha,
				'plazo' => $plazo,
				'id_proveedor' => $id_proveedor,
				'monto' => $monto,
				'observacion' => $observacion,
				'id_unidad' => $unidad,
				'id_dependencia' => $depedencia,
				'id_funcionario' => $funcionario,
				'id_comprobante' => $comprobante,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => "1",
			);

			if ($this->Recepcion_Bienes_model->save($data)) {
				redirect(base_url() . "patrimonio/recepcion_bienes");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la información");
				redirect(base_url() . "patrimonio/recepcion_bienes/add");
			}
		} else {
			$this->add();
		}
	}


	public function edit($id)
	{
		$nombre = $this->session->userdata('Nombre_usuario');
		$id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$bienes = $this->Recepcion_Bienes_model->getRecepcionBien($id);
		$proveedores = $this->Proveedores_model->getProveedores($id_uni_respon_usu);
		$comprobantes = $this->Comprobante_Gasto_model->getComprobantesGastos($id_uni_respon_usu);
		$unidad = $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu);
		$funcionarios = $this->Funcionarios_model->getFuncionarios($id_uni_respon_usu);
		$dependencia = $this->Funcionarios_model->getDependencias();

		$proveedorEncontrado = null;
		foreach ($proveedores as $proveedor) {
			if ($proveedor->id == $bienes->id_proveedor) {
				$proveedorEncontrado = $proveedor;
				break;
			}
		}

		$comprobantesEncontrado = null;
		foreach ($comprobantes as $comprobante) {
			if ($comprobante->IDComprobanteGasto == $bienes->id_comprobante) {
				$comprobantesEncontrado = $comprobante;
				break;
			}
		}
		
		$unidadEncontrado = null;
		foreach ($unidad as $uni) {
			if ($uni->id_unidad == $bienes->id_unidad) {
				$unidadEncontrado = $uni;
				break;
			}
		}
		
		$funcionariosEncontrado = null;
		foreach ($funcionarios as $funcionario) {
			if ($funcionario->funcionario_id == $bienes->id_funcionario) {
				$funcionariosEncontrado = $funcionario;
				break;
			}
		}
		
		$dependenciaEncontrado = null;
		foreach ($dependencia as $depen) {
			if ($depen->dependencia_id == $bienes->id_dependencia) {
				$dependenciaEncontrado = $depen;
				break;
			}
		}
		

		$data = array(
			'bienes' => $bienes,
			'prove' => $proveedores,
			'compro' => $comprobantes,
			'uni' => $unidad,
			'fun' => $funcionarios,
			'depen' => $dependencia,
			'proveedores' => $proveedorEncontrado,
			'comprobantes' => $comprobantesEncontrado,
			'unidad' => $unidadEncontrado,
			'funcionarios' => $funcionariosEncontrado,
			'dependencia' => $dependenciaEncontrado,
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/recepcionbienes/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function update()
	{
		$IDRecepcionBienes = $this->input->post("IDRecepcionBienes");
		$nro = $this->input->post("nro");
		$fecha = $this->input->post("fecha");
		$id_proveedor = $this->input->post("id_Proveedor");
		$plazo = $this->input->post("plazo");
		$monto = $this->input->post("monto");
		$observacion = $this->input->post("observacion");
		$unidad = $this->input->post("id_Unidad");
		$depedencia = $this->input->post("id_Dependencia");
		$funcionario = $this->input->post("id_Funcionario");
		$comprobante = $this->input->post("idcomprobante");


		$proveedoractual = $this->Recepcion_Bienes_model->getRecepcionBien($IDRecepcionBienes);

		$this->form_validation->set_rules("nro", "Nro", "required[recepcion_bienes.nro]");

		$this->form_validation->set_rules("monto", "Monto", "required[recepcion_bienes.monto]");


		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nro' => $nro,
				'fecha' => $fecha,
				'plazo' => $plazo,
				'id_proveedor' => $id_proveedor,
				'monto' => $monto,
				'observacion' => $observacion,
				'id_unidad' => $unidad,
				'id_dependencia' => $depedencia,
				'id_funcionario' => $funcionario,
				'id_comprobante' => $comprobante,
			);

			if ($this->Recepcion_Bienes_model->update($IDRecepcionBienes, $data)) {
				redirect(base_url() . "patrimonio/recepcion_bienes");
			} else {
				$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
				redirect(base_url() . "patrimonio/recepcion_bienes/edit/" . $IDRecepcionBienes);
			}
		} else {
			$this->edit($IDRecepcionBienes);
		}

	}

	public function view($id)
	{
		$data = array(
			'proveedor' => $this->Recepcion_Bienes_model->getRecepcionBien($id),
		);
		$this->load->view("admin/recepcionbienes/view", $data);
	}

	public function delete($id)
	{
		$data = array(
			'estado' => "0",
		);
		$this->Recepcion_Bienes_model->update($id, $data);
		redirect(base_url() . "patrimonio/recepcion_bienes");
	}
	public function getBienDetalle($id)
	{
		$BienDetalle = $this->Recepcion_Bienes_model->getRecepcionBien($id);
		echo json_encode($BienDetalle);
	}
}