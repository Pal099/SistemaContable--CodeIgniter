<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
	//	$this->permisos= $this->backend_lib->control();
		$this->load->model("Productos_model");
	}

	
	public function index()
	{
		$data  = array(
			'productos' => $this->Productos_model->getProductos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/list",$data);
		$this->load->view("layouts/footer");

	}

	public function add(){

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/add");
		$this->load->view("layouts/footer");
	}

	public function store(){

		$codigo = $this->input->post("codigo");
		$nombre = $this->input->post("nombre");
		$precio_venta = $this->input->post("precio_venta");
		$precio_compra= $this->input->post("precio_compra");
		$iva= $this->input->post("iva");
		$existencia= $this->input->post("existencia");
		$stock_minimo = $this->input->post("stock_minimo");
		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[productos.codigo]");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'codigo' => $codigo, 
				'nombre' => $nombre, 
				'precio_venta' => $precio_venta,
				'precio_compra' => $precio_compra,
				'iva' => $iva,
				'existencia' => $existencia,
				'stock_minimo' => $stock_minimo,
				'estado' => "1"
			);

			if ($this->Productos_model->save($data)) {
				redirect(base_url()."mantenimiento/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."mantenimiento/productos/add");
			}
		}
		else{
			$this->add();
		}

		
	}

	public function edit($id){
		$data  = array(
			'pducto' => $this->Productos_model->getProducto($id), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/productos/edit",$data);
		$this->load->view("layouts/footer");
	}

	public function update(){
				$codigo = $this->input->post("codigo");
		$nombre = $this->input->post("nombre");
		$precio_venta = $this->input->post("precio_venta");
		$precio_compra= $this->input->post("precio_compra");
		$iva= $this->input->post("iva");
		$existencia= $this->input->post("existencia");
		$stock_minimo = $this->input->post("stock_minimo");
		$this->form_validation->set_rules("codigo","Codigo","required|is_unique[productos.codigo]");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		$pductoactual = $this->Productos_model->getProducto($idProductos);

		if ($codigo == $pductoactual->codigo) {
			$is_unique = "";
		}else{
			$is_unique = "|is_unique[productos.codigo]";

		}

		if ($nombre == $pductoactual->nombre) {
			$is_unique = "";
		}else{
			$is_unique = "|is_unique[productos.nombre]";

		}
		
		$this->form_validation->set_rules("ruc","Ruc","required".$is_unique);
		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'codigo' => $codigo, 
				'nombre' => $nombre, 
				'precio_venta' => $precio_venta,
				'precio_compra' => $precio_compra,
				'iva' => $iva,
				'existencia' => $existencia,
				'stock_minimo' => $stock_minimo,
			);

			if ($this->Productos_model->update($idProductos,$data)) {
				redirect(base_url()."mantenimiento/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."mantenimiento/productos/edit/".$idProductos);
			}
		}else{
			$this->edit($idProductos);
		}

		
	}

	public function view($id){
		$data  = array(
			'pducto' => $this->Productos_model->getProducto($id), 
		);
		$this->load->view("admin/productos/view",$data);
	}

	public function delete($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Productos_model->update($id,$data);
		echo "mantenimiento/productos";
	}
}
