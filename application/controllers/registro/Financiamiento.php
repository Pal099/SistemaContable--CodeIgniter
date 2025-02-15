<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financiamiento extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
    $this->load->database();
		$this->load->model("Registros_financieros_model");
		$this->load->model("Usuarios_model");
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
			'fuentes' => $this->Registros_financieros_model->getFuentes($id_uni_respon_usu), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/fuente/listfuente",$data);
		$this->load->view("layouts/footer");
		
	}
    public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/fuente/addfuente");
		$this->load->view("layouts/footer");
	}
    public function store(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[fuente_de_financiamiento.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'id_uni_respon_usu'=>$id_uni_respon_usu,
				'estado' => "1",
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Registros_financieros_model->save($data)) {
				redirect(base_url()."registro/financiamiento");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."registro/financiamiento/addfuente");
			}
		}
		else{
			$this->add();  
		}
	}
	public function edit($id){
		$data  = array(
			'fuente' => $this->Registros_financieros_model->getFuente($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/fuente/editfuente",$data);
		$this->load->view("layouts/footer");
	}
    public function update(){
		$idFuente = $this->input->post("idFuente");
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");
	
		$fuenteactual = $this->Registros_financieros_model->getFuente($idFuente);
	
		if ($codigo == $fuenteactual->codigo) {
			$is_unique = "";
		} else {
			$is_unique = "|is_unique[fuente_de_financiamiento.codigo]";
		}
	
		$this->form_validation->set_rules("codigo", "Codigo", "required" . $is_unique);
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'nombre' => $nombre,
				'codigo' => $codigo,
			);
	
			if ($this->Registros_financieros_model->update($idFuente, $data)) {
				redirect(base_url()."registro/financiamiento");
			} else {
				$this->session->set_flashdata("error", "No se pudo actualizar la informacion");
				redirect(base_url()."registro/financiamiento/editfuente/".$idFuente);
			}
		} else {
			$this->edit($idFuente);
		}
	}
    public function view($id){
		$data  = array(
			'fuente' => $this->Registros_financieros_model->getFuente($id), 
		);
		$this->load->view("admin/fuente/viewfuente",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Registros_financieros_model->update($id,$data);
		redirect(base_url() . "registro/financiamiento");
	}
}