<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Origen extends CI_Controller {

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
			'origen' => $this->Registros_financieros_model->getOrigenes(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/origen/listorigen",$data);
		$this->load->view("layouts/footer");

	}
    public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/origen/addorigen");
		$this->load->view("layouts/footer");
	}
    public function store(){

		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[origen_de_financiamiento.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'estado' => "1"
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Registros_financieros_model->save($data)) {
				redirect(base_url()."registro/origen");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."admin/origen/addorigen");
			}
		}
		else{
			$this->add();  
		}
	}
	public function edit($id){
		$data  = array(
			'origenes' => $this->Registros_financieros_model->getOrigen($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/origen/editorigen",$data);
		$this->load->view("layouts/footer");
	}
    public function update(){
		$idOrigen = $this->input->post("idOrigen");
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");
	
		$Origenactual = $this->Registros_financieros_model->getOrigen($idOrigen);
	
		if ($codigo == $Origenactual->codigo) {
			$is_unique = "";
		} else {
			$is_unique = "|is_unique[origen_de_financiamiento.codigo]";
		}
	
		$this->form_validation->set_rules("codigo", "Codigo", "required" . $is_unique);
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nombre' => $nombre,
				'codigo' => $codigo,
			);
	
			if ($this->Registros_financieros_model->updateOrigen($idOrigen, $data)) {
				redirect(base_url()."registro/origen");
			} else {
				$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
				redirect(base_url()."admin/origen/editorigen/".$idOrigen);
			}
		} else {
			$this->edit($idOrigen);
		}
	}
    public function view($id){
		$data  = array(
			'origenes' => $this->Registros_financieros_model->getOrigen($id), 
		);
		$this->load->view("admin/origen/vieworigen",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Registros_financieros_model->updateOrigen($id,$data);
		echo "registro/origen";
	}
}