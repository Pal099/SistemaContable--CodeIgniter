<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaGasto extends CI_Controller {

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
			'gasto' => $this->Registros_financieros_model->getProgramGastos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/progasto/listprogasto",$data);
		$this->load->view("layouts/footer");

	}
    public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/progasto/addprogasto");
		$this->load->view("layouts/footer");
	}
    public function store(){

		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[programa_de_gastos.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'estado' => "1"
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Registros_financieros_model->save($data)) {
				redirect(base_url()."registro/programagasto");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."admin/progasto/addprogasto");
			}
		}
		else{
			$this->add();  
		}
	}
	public function edit($id){
		$data  = array(
			'gastos' => $this->Registros_financieros_model->getProgramGasto($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/progasto/editprogasto",$data);
		$this->load->view("layouts/footer");
	}
    public function update(){
		$idProgramGasto = $this->input->post("idProgramGasto");
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");
	
		$ProgramGastoactual = $this->Registros_financieros_model->getProgramGasto($idProgramGasto);
	
		if ($codigo == $ProgramGastoactual->codigo) {
			$is_unique = "";
		} else {
			$is_unique = "|is_unique[programa_de_gastos.codigo]";
		}
	
		$this->form_validation->set_rules("codigo", "Codigo", "required" . $is_unique);
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nombre' => $nombre,
				'codigo' => $codigo,
			);
	
			if ($this->Registros_financieros_model->updateProgramGasto($idProgramGasto, $data)) {
				redirect(base_url()."registro/programagasto");
			} else {
				$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
				redirect(base_url()."admin/progasto/editprogasto/".$idProgramGasto);
			}
		} else {
			$this->edit($idProgramGasto);
		}
	}
    public function view($id){
		$data  = array(
			'gastos' => $this->Registros_financieros_model->getProgramGasto($id), 
		);
		$this->load->view("admin/progasto/viewprogasto",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Registros_financieros_model->updateProgramGasto($id,$data);
		echo "registro/programagasto";
	}
}