<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certific_disp_presu extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Proveedores_model");
		$this->load->model("ProgramGasto_model");
		$this->load->model("Cdp_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Presupuesto_model");
		$this->load->model("EjecucionP_model");
		$this->load->model("EjecucionP_model");
		$this->load->model("LibroMayor_model");
		$this->load->library('form_validation');

	}
	public function index() {
        $numero_asiento = $this->input->get('numero_asiento');
        $this->mostrar_vista($numero_asiento);
    }

	public function pdfs($numero_asiento)
	{
		// Puedes usar $numero_asiento en tu lógica de la vista
		$data['numero_asiento'] = $numero_asiento;
	
		$this->load->view("Pdf_cdp/generarPDF_cdp/", $data);
	}
	

    public function busqueda_por_asiento() {
        $numero_asiento = $this->input->get('numero_asiento');
        $this->mostrar_vista($numero_asiento);
    }

    private function mostrar_vista($numero_asiento) {

		//Obtenemos el nombre que nos va servir para obtener su id
		$nombre=$this->session->userdata('Nombre_usuario');

		//Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
		//id conseguido mediante el nombre del usuario
		$id_user=$this->Usuarios_model->getUserIdByUserName($nombre);
		
		//Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
		//esa id es importante para hacer las relaciones y registros por usuario
		$id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);

        $data['datos_vista'] = $this->Cdp_model->obtener_datos_asiento_por_busqueda( $id_uni_respon_usu, $numero_asiento, );

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/cdp/list", $data);
        $this->load->view("layouts/footer");
    }
	
}