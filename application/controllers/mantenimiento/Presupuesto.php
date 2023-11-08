<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presupuesto extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
	$this->load->model("Presupuesto_model");
	$this->load->model("Registros_financieros_model");
	$this->load->model("Origen_model");
	$this->load->model('ProgramGasto_model');
	$this->load->model('Cuentas_model');
	$this->load->model('EjecucionP_model');
	}

	
	public function index()
	{
		$data  = array(
			'presupuestos' => $this->Presupuesto_model->getPresu(),
			'descripciones' => $this->Cuentas_model->getCuentas(),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'ejecucionpresupuestaria' => $this->EjecucionP_model->getEjecucionesP(),
		);
		
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/list", $data);
		$this->load->view("layouts/footer");

	}

	public function add(){
		$data  = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuestos(),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'descripciones' => $this->Cuentas_model->getCuentas(),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/add", $data);
		$this->load->view("layouts/footer");
	}

	public function store(){

		$id_presupuesto = $this->input->post("ID_Presupuesto");
		$año = $this->input->post("Año");
		$descripcion = $this->input->post("Descripcion");
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
		$TotalModificado = $this->input->post("TotalModificado");
		$pre_ene = $this->input->post("pre_ene");
		$pre_feb = $this->input->post("pre_feb");
		$pre_mar = $this->input->post("pre_mar");
		$pre_abr = $this->input->post("pre_abr");
		$pre_may = $this->input->post("pre_may");
		$pre_jun = $this->input->post("pre_jun");
		$pre_jul = $this->input->post("pre_jul");
		$pre_ago = $this->input->post("pre_ago");
		$pre_sep = $this->input->post("pre_sep");
		$pre_oct = $this->input->post("pre_oct");
		$pre_nov = $this->input->post("pre_nov");
		$pre_dic = $this->input->post("pre_dic");


			$data = array(
				'ID_Presupuesto' => $id_presupuesto,
				'Año' => $año,
				'Descripcion' => $descripcion,
				'TotalPresupuestado' => $totalpresupuestado,
				'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
				'programa_id_pro' => $programa_id_pro,
				'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
				'TotalModificado' => $TotalModificado,
				'pre_ene' => $pre_ene,
				'pre_feb' => $pre_feb,
				'pre_mar' => $pre_mar,
				'pre_abr' => $pre_abr,
				'pre_may' => $pre_may,
				'pre_jun' => $pre_jun,
				'pre_jul' => $pre_jul,
				'pre_ago' => $pre_ago,
				'pre_sep' => $pre_sep,
				'pre_oct' => $pre_oct,
				'pre_nov' => $pre_nov,
				'pre_dic' => $pre_dic,
				'estado' => "1"
			);

			if ($this->Presupuesto_model->save($data)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			} else {
				$this->session->set_flashdata("error", "No se pudo guardar la informacion");
				redirect(base_url() . "mantenimiento/presupuesto/add");
			}

			$datos = array(
				'id_pro' => $this->input->post('programa_id_pro'),
				'id_ff' => $this->input->post('fuente_de_financiamiento'),
				'id_of' => $this->input->post('origen_de_financiamiento'),
				'Haber' => $this->input->post('TotalModificado'),
				'Debe' => $this->input->post('TotalPresupuestado'),
				'MontoPago' => $this->input->post('monto_mes'),
				// No incluir otros campos que no deseas insertar.
			);
		
			if ($this->Presupuesto_model->save2($datos)) {
				redirect(base_url() . "mantenimiento/presupuesto");
			}
	}

	public function edit($id){
		$data = array(
			'presupuesto' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/presupuesto/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$id = $this->input->post("ID_Presupuesto");
		$anio = $this->input->post("Anio");
		$descripcion = $this->input->post("Descripcion");
		$totalpresupuestado = $this->input->post("TotalPresupuestado");
		$origen_de_financiamiento_id_of = $this->input->post("origen_de_financiamiento_id_of");
		$programa_id_pro = $this->input->post("programa_id_pro");
		$fuente_de_financiamiento_id_ff = $this->input->post("fuente_de_financiamiento_id_ff");
		$TotalModificado = $this->input->post("TotalModificado");
		$pre_ene = $this->input->post("pre_ene");
		$pre_feb = $this->input->post("pre_feb");
		$pre_mar = $this->input->post("pre_mar");
		$pre_abr = $this->input->post("pre_abr");
		$pre_may = $this->input->post("pre_may");
		$pre_jun = $this->input->post("pre_jun");
		$pre_jul = $this->input->post("pre_jul");
		$pre_ago = $this->input->post("pre_ago");
		$pre_sep = $this->input->post("pre_sep");
		$pre_oct = $this->input->post("pre_oct");
		$pre_nov = $this->input->post("pre_nov");
		$pre_dic = $this->input->post("pre_dic");

		$presupuestoactual = $this->Presupuesto_model->getPresupuesto($id);
		$data = array(
			'ID_Presupuesto' => $id,
			'Anio' => $anio,
			'Descripcion' => $descripcion,
			'TotalPresupuestado' => $totalpresupuestado,
			'origen_de_financiamiento_id_of' => $origen_de_financiamiento_id_of,
			'programa_id_pro' => $programa_id_pro,
			'fuente_de_financiamiento_id_ff' => $fuente_de_financiamiento_id_ff,
			'TotalModificado' => $TotalModificado,
			'pre_ene' => $pre_ene,
			'pre_feb' => $pre_feb,
			'pre_mar' => $pre_mar,
			'pre_abr' => $pre_abr,
			'pre_may' => $pre_may,
			'pre_jun' => $pre_jun,
			'pre_jul' => $pre_jul,
			'pre_ago' => $pre_ago,
			'pre_sep' => $pre_sep,
			'pre_oct' => $pre_oct,
			'pre_nov' => $pre_nov,
			'pre_dic' => $pre_dic,
			'estado' => "1"
		);
		if ($this->Presupuesto_model->update($id, $data)) {
			redirect(base_url() . "mantenimiento/presupuesto");
		} else {
			$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
			redirect(base_url() . "mantenimiento/presupuesto/edit/" . $id);
		}
		
	}

	public function view($id){
		$data = array(
			'presupuestos' => $this->Presupuesto_model->getPresupuesto($id),
			'registros_financieros' => $this->Registros_financieros_model->getFuentes(),
			'origen' => $this->Origen_model->getOrigenes(),
			'programa' => $this->ProgramGasto_model->getProgramGastos(),
			'descripcion' => $this->Cuentas_model->getCuentas(),
		);
		$this->load->view("admin/presupuesto/view", $data);
	}

	public function delete($id){
		$data = array(
			'estado' => "0",
		);
		$this->Presupuesto_model->update($id, $data);
		echo "mantenimiento/presupuesto";
	}
}