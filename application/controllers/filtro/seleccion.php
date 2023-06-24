<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleccion extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Productos_model");
	}
	public function index()
	{
		$data  = array(
			'producto' => $this->Productos_model->getProductos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/list",$data);
		$this->load->view("layouts/footer");

	}

	public function view($id){
		$data  = array(
			'producto' => $this->Productos_models->getProducto($id), 
		);
		$this->load->view("admin/filtrar/view",$data);
	}

}
