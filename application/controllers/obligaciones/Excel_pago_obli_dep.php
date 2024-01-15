<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_pago_obli_dep extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Excel_pago_obli_dep_model");
	}
	

	public function obtenerDatosVista() {
		// Obtener las fechas del formulario
		$fechaInicio = $this->input->post('fechaInicio');
		$fechaFin = $this->input->post('fechaFin');
	
		// Si las fechas están vacías, establecer valores predeterminados
		if (empty($fechaInicio) || empty($fechaFin)) {
			$fechaInicio = '2020-01-01';
			$fechaFin = '2023-12-30';
		}

		$data['fechaInicio'] = $fechaInicio;
		$data['fechaFin'] = $fechaFin;
	

			$data['datos'] = $this->Excel_pago_obli_dep_model->obtenerDatos($fechaInicio, $fechaFin);
	
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("admin/deposito/detalle", $data);
			$this->load->view("layouts/footer");

		}
	public function GenerarExcel() {
		$fechaInicio = $this->input->post('fechaInicio');
		$fechaFin = $this->input->post('fechaFin');
		$data['fechaInicio'] = $fechaInicio;
		$data['fechaFin'] = $fechaFin;
		$data['datos'] = $this->Excel_pago_obli_dep_model->obtenerDatos($fechaInicio, $fechaFin);
			$this->load->view("admin/deposito/generarexcel", $data);

	}
	public function resumenPorMeses() {

		$mes= $this->input->post('mes');

		$data['resumenPorMeses'] = $this->Excel_pago_obli_dep_model->obtenerResumenPorMeses($mes);
	
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/obligacion/detalle", $data);  
		$this->load->view("layouts/footer");
	}
}
