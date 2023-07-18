<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaIngreso extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
    $this->load->database();
		$this->load->model("Registros_financieros_model");
	}

	//----------------------Index Fuente--------------------------------------------------------

	public function index()
	{
		$data  = array(
			'ingreso' => $this->Registros_financieros_model->getProgramIngresos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proingreso/listproingreso",$data);
		$this->load->view("layouts/footer");

	}
    public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proingreso/addproingreso");
		$this->load->view("layouts/footer");
	}
    public function store(){

		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[programa_ingreso.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'estado' => "1"
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Registros_financieros_model->save($data)) {
				redirect(base_url()."registro/programaingreso");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."admin/proingreso/addproingreso");
			}
		}
		else{
			$this->add();  
		}
	}
	public function edit($id){
		$data  = array(
			'ingresos' => $this->Registros_financieros_model->getProgramIngreso($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proingreso/editproingreso",$data);
		$this->load->view("layouts/footer");
	}
    public function update(){
		$idProgramIngreso = $this->input->post("idProgramIngreso");
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");
	
		$ProgramIngresoactual = $this->Registros_financieros_model->getProgramIngreso($idProgramIngreso);
	
		if ($codigo == $ProgramIngresoactual->codigo) {
			$is_unique = "";
		} else {
			$is_unique = "|is_unique[programa_ingreso.codigo]";
		}
	
		$this->form_validation->set_rules("codigo", "Codigo", "required" . $is_unique);
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nombre' => $nombre,
				'codigo' => $codigo,
			);
	
			if ($this->Registros_financieros_model->updateProgramIngreso($idProgramIngreso, $data)) {
				redirect(base_url()."registro/programaingreso");
			} else {
				$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
				redirect(base_url()."admin/proingreso/editproingreso/".$idProgramIngreso);
			}
		} else {
			$this->edit($idProgramIngreso);
		}
	}
    public function view($id){
		$data  = array(
			'ingresos' => $this->Registros_financieros_model->getProgramIngreso($id), 
		);
		$this->load->view("admin/proingreso/viewproingreso",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Registros_financieros_model->updateProgramIngreso($id,$data);
		echo "registro/programaingreso";
	}
}