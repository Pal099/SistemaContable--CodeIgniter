<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programa extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Programa_model");
		
	}

	//----------------------Index Fuente--------------------------------------------------------

	public function index()
	{
		$data  = array(
			'gastos' => $this->Programa_model->getProgramGastos(), 
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

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[programa.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'estado' => "1"
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Programa_model->save($data)) {
				redirect(base_url()."registro/programa");
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
			'gastos' => $this->Programa_model->getProgramGasto($id), 
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
	
		$ProgramGastoactual = $this->Programa_model->getProgramGasto($idProgramGasto);
	
		if ($codigo == $ProgramGastoactual->codigo) {
			$is_unique = "";
		} else {
			$is_unique = "|is_unique[programa.codigo]";
		}
	
		$this->form_validation->set_rules("codigo", "Codigo", "required" . $is_unique);
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nombre' => $nombre,
				'codigo' => $codigo,
			);
	
			if ($this->Programa_model->update($idProgramGasto, $data)) {
				redirect(base_url()."registro/programa");
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
			'gastos' => $this->Programa_model->getProgramGasto($id), 
		);
		$this->load->view("admin/progasto/viewprogasto",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Programa_model->update($id,$data);
		echo "registro/programa";
	}
}