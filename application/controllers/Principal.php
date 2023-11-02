<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_CONTROLLER {

    public function index()
    {
        $data = array(
		);
		$dato = array(


		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/principal", $data);
		$this->load->view("layouts/footer",$dato);
    }

    public function calcularTotalVentas()
    {
        // Aquí realiza el cálculo del total de ventas si es necesario
        // ...
        return $totalVentas;
    }



    public function getProductos()
    {
        $this->db->where('estado', '1'); // Solo obtener productos con estado igual a 1
        $resultados = $this->db->get('productos');
        return $resultados->result();
    }

    protected function middleware()
    {
        return ['Sesion'];
    }

    public function filtrar()
    {
        // Aquí realiza el filtrado si es necesario
        // ...
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/carrito/micarrito", $dato);
        $this->load->view("layouts/footer");
    }

    public function store()
    {
        // Aquí realiza el almacenamiento si es necesario
        // ...
    }

    public function add()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/categorias/add");
        $this->load->view("layouts/footer");
    }

    public function save($data)
    {
        // Aquí realiza el guardado si es necesario
        // ...
    }

    public function delete($id)
    {
        $data  = array(
            'estado' => "0", 
        );
        // Aquí realiza la eliminación si es necesario
        // ...
        echo "principal";
    }

}
