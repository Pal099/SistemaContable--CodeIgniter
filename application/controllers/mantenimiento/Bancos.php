<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bancos extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Bancos_model");
	}

	
	public function index()
	{
		$data  = array(
			'bancos' => $this->Bancos_model->getBancos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/bancos/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/bancos/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$ban_descri = $this->input->post("ban_descri");
		$ban_agente = $this->input->post("ban_agente");
		$ban_telefono = $this->input->post("ban_telefono");
			$data  = array(
				'ban_descri' => $ban_descri, 
				'ban_agente' => $ban_agente,
				'ban_telefono' => $ban_telefono,
				'estado' => "1"
			);

			if ($this->Bancos_model->save($data)) {
				redirect(base_url()."mantenimiento/bancos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/bancos/add");
			}
	}

	public function edit($id){
		$data  = array(
			'bancos' => $this->Bancos_model->getBanco($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/bancos/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
		$idBancos = $this->input->post("idBancos");
		$ban_descri = $this->input->post("ban_descri");
		$ban_agente = $this->input->post("ban_agente");
		$ban_telefono = $this->input->post("ban_telefono");
			$data  = array(
				'ban_descri' => $ban_descri, 
				'ban_agente' => $ban_agente,
				'ban_telefono' => $ban_telefono,
				'estado' => "1"
			);

			if ($this->Bancos_model->update($idBancos,$data)) {
				redirect(base_url()."mantenimiento/bancos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/bancos/edit/".$idBancos);
			}
		
	}

	public function view($id){
		$data  = array(
			'bancos' => $this->Bancos_model->getBanco($id), 
		);
		$this->load->view("admin/bancos/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Bancos_model->update($id,$data);
		echo "mantenimiento/bancos";
	}
}
