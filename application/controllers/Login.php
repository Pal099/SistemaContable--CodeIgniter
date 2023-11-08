<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index()
	{
		$this->load->view("layouts/header");
		$this->load->view("admin/usuarios/login_view");
        $this->load->view("layouts/footer");
		

	}
}
