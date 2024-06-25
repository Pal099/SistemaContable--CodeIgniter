<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		$this->load->model("Funcionarios_model");
		$this->load->model("Usuarios_model");
		$this->load->library('session');
		$this->load->model("Unidad_academica_model");
		
	}


	//----------------------Index Fuente--------------------------------------------------------

	public function index()
	{
		//Con la libreria Session traemos los datos del usuario
		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario'); 

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);


		$data  = array(
			'funcionarios' => $this->Funcionarios_model->getFuncionarios($id_uni_respon_usu),
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/funcionarios/list",$data);
		$this->load->view("layouts/footer");

	}
    public function add(){
        $nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        $data  = array(
			'funcionarios' => $this->Funcionarios_model->getFuncionarios($id_uni_respon_usu),
			'unidad' => $this->Unidad_academica_model->obtener_unidades_academicas($id_uni_respon_usu),
			'dependencia' => $this->Funcionarios_model->getDependencias(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/funcionarios/add",$data);
		$this->load->view("layouts/footer");
	}
    public function store(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$unidad = $this->input->post("id_Unidad");
		$depedencia = $this->input->post("id_Dependencia");
		$funcionario = $this->input->post("Funcionario");

		

		if ($id_uni_respon_usu) {

			$data  = array(
				'unidad_id' => $unidad, 
				'dependencia_id' => $depedencia,
				'funcionario'=>$funcionario,
				'id_uni_respon_usu' => $id_uni_respon_usu,
				'estado' => "1",
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Funcionarios_model->save($data)) {
				redirect(base_url()."funcionario/funcionario");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."admin/funcionario/add");
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