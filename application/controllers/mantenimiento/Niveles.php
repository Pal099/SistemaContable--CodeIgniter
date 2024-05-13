<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveles extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("Niveles_model");
        $this->load->library('session');
        $this->load->model("Usuarios_model");
    }

    public function index()
    {
        // Obtener los niveles
        $data  = array(
            'niveles' => $this->Niveles_model->getNiveles(),
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/niveles/list", $data);
        $this->load->view("layouts/footer");
    }

    public function add(){
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/niveles/add");
        $this->load->view("layouts/footer");
    }

    public function store() {
        // Recibir datos del formulario
        $nombre_nivel = $this->input->post("nombre_nivel");
        
        // Validar campos
        $this->form_validation->set_rules("nombre_nivel", "Nombre del nivel", "required");

        if ($this->form_validation->run() == TRUE) {
            // Preparar datos para guardar
            $data = array(
                'nombre_nivel' => $nombre_nivel,
                'estado' => "1",
            );

            // Guardar en la base de datos
            if ($this->Niveles_model->save($data)) {
                redirect(base_url() . "mantenimiento/niveles");
            } else {
                $this->session->set_flashdata("error", "No se pudo guardar la información");
                redirect(base_url() . "mantenimiento/niveles/add");
            }
        } else {
            $this->add();
        }
    }

    public function edit($id){
        // Obtener datos del nivel a editar
        $data  = array(
            'nivel' => $this->Niveles_model->getNivel($id), 
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/sideBar");
        $this->load->view("admin/niveles/edit",$data);
        $this->load->view("layouts/footer");
    }

    public function update(){
        // Recibir datos del formulario
        $id_nivel = $this->input->post("id_nivel");
        $nombre_nivel = $this->input->post("nombre_nivel");

        // Validar campos
        $this->form_validation->set_rules("nombre_nivel","Nombre del nivel","required");

        if ($this->form_validation->run()==TRUE) {
            // Preparar datos para actualizar
            $data = array(
                'nombre_nivel' => $nombre_nivel, 
            );

            // Actualizar en la base de datos
            if ($this->Niveles_model->update($id_nivel, $data)) {
                redirect(base_url()."mantenimiento/niveles");
            } else {
                $this->session->set_flashdata("error","No se pudo actualizar la informacion");
                redirect(base_url()."mantenimiento/niveles/edit/".$id_nivel);
            }
        } else {
            $this->edit($id_nivel);
        }
    }
    
    public function delete($id){
        // Cambiar estado a 0 para "eliminar" lógicamente
        $data  = array(
            'estado' => "0", 
        );
        $this->Niveles_model->update($id, $data);
        redirect(base_url() . "mantenimiento/niveles");
    }
}
