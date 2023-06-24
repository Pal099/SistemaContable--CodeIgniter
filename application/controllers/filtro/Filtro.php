<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Productos_model");
	}
	public function index()
	{
		$data  = array(
			'proveedores' => $this->Productos_model->getProveedores(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/proveedores/list",$data);
		$this->load->view("layouts/footer");

	}

}
