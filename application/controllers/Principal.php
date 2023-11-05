<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends MY_Controller {

    public function index()
    {
       
        
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/principal");
        $this->load->view("layouts/footer");
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
