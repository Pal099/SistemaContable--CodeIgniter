<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Principal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Presupuesto_model");
        $this->load->model('Usuarios_model');   
        $this->load->model('Principal_model');   
        $this->load->model('CuentaContable_model');
    }

    public function index()
    {
        // Con la libreria Session traemos los datos del usuario
        // Obtenemos el nombre que nos va servir para obtener su id
        $nombre = $this->session->userdata('Nombre_usuario');

        // Con el método getUserIdByUserName en el modelo del usuario, nos devuelve el id
        // id conseguido mediante el nombre del usuario
        $id_user = $this->Usuarios_model->getUserIdByUserName($nombre);
        
        // Y finalmente, con el método getUserIdUniResponByUserId traemos el id_uni_respon_usu
        // esa id es importante para hacer las relaciones y registros por usuario
        $id_uni_respon_usu = $this->Usuarios_model->getUserIdUniResponByUserId($id_user);
        
        // Obtener el conteo de obligados en el mes desde el modelo
        $data['total_obligados_mes'] = $this->Principal_model->getCountObligadosMes($id_uni_respon_usu);
        // Obtener el conteo de Pagados en el mes desde el modelo
        $data['total_pagados_mes'] = $this->Principal_model->getCountPagadosMes($id_uni_respon_usu);

        // Obtener el nombre del mes en español
        $currentMonth = date('n'); // Obtener el mes actual en formato numérico (sin ceros a la izquierda)
        $data['monthInSpanish'] = $this->Principal_model->getMonthInSpanish($currentMonth);

        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/principal", $data);
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
        $this->load->view("layouts/sideBar");
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
        $data = array(
            'estado' => "0",
        );
        // Aquí realiza la eliminación si es necesario
        // ...
        echo "principal";
    }
}
