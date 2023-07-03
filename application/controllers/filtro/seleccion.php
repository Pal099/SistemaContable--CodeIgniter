<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleccion extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("Productos_model");		
    }

    public function index()
    {
        $data = array(
            'productos' => $this->Productos_model->getProductos(), //Con la variable productos (que se utiliza en la vista view/admin/filtros/filtrar) sirve para mostrar la tabla de productos con sus relaciones.
			'proveedor' => $this->Productos_model->getProveedores(),
			'categorias' => $this->Productos_model->getCategorias()//Con la variable categorias (también en la vista view/admin/filtros/filtrar) traemos en el dropdown (box list) las categorias existentes.
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/filtros/filtrar", $data);
        $this->load->view("layouts/footer");
    }

    public function filtrar()
    {
        $categoria = $this->input->get('categorias'); //Se almacena lo que se consiguió de la bd en la variable categoria.
		$proveedor = $this->input->get('proveedor');
		$data = array(
            'productos' => $this->Productos_model->filtrar_productos_por_categoria($categoria), //En la variable productos mostramos los productos de acuerdo a su categoria.
            'productoprov' => $this->Productos_model->filtrar_productos_por_proveedor($proveedor),
			'proveedor' => $this->Productos_model->getProveedores(),
			'categorias' => $this->Productos_model->getCategorias() //Se utiliza para el filtro correspondiente. 
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/filtros/filtrar", $data);
        $this->load->view("layouts/footer");
    }

	public function view($id)
	{
		$data = array(
			'producto' => $this->Productos_model->getProducto($id) //Para la vista view/admin/filtros/view
		);
		$this->load->view("admin/filtros/view", $data);
	}
}
