<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	//public function __construct(){
		//parent::__construct();
		//if (!$this->session->userdata("login")) {
		//	redirect(base_url());
		//}
		//$this->load->model("Entradas_model");
		//$this->load->model("Productos_model");
		//$this->load->model("Consulta_model");
	
	//}
	public function index()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/principal");
		$this->load->view("layouts/footer");
	}

}
