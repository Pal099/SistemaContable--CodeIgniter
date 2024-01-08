<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Origen extends MY_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
    $this->load->database();
		$this->load->model("Origen_model");
		$this->load->model("Usuarios_model");
	}

	protected function middleware()
    {
        return ['Sesion'];
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
			'origenes' => $this->Origen_model->getOrigenes($id_uni_respon_usu), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/origen/listorigen",$data);
		$this->load->view("layouts/footer");

	}
    public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/origen/addorigen");
		$this->load->view("layouts/footer");
	}
    public function store(){
		$nombre=$this->session->userdata('Nombre_usuario');
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");

		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[origen_de_financiamiento.codigo]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'codigo' => $codigo,
				'id_uni_respon_usu'=>$id_uni_respon_usu,
				'estado' => "1"
			);

            //----------------------Fuente--------------------------------------------------------

			if ($this->Origen_model->save($data)) {
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
			'origenes' => $this->Origen_model->getOrigen($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/sideBar");
		$this->load->view("admin/origen/editorigen",$data);
		$this->load->view("layouts/footer");
	}
    public function update(){
		$idOrigen = $this->input->post("idOrigen");
		$nombre = $this->input->post("nombre");
		$codigo = $this->input->post("codigo");
	
		$Origenactual = $this->Origen_model->getOrigen($idOrigen);
	
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
	
			if ($this->Origen_model->updateOrigen($idOrigen, $data)) {
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
			'origenes' => $this->Origen_model->getOrigen($id), 
		);
		$this->load->view("admin/origen/vieworigen",$data);
	}
    public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Origen_model->updateOrigen($id,$data);
		echo "registro/origen";
	}
}