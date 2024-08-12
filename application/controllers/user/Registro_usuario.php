<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model'); 
        $this->load->model('Unidad_academica_model'); 
    }

    public function registrar() {
        //Traemos las unidades académicas
        $data['unidades_academicas'] = $this->Usuarios_model->obtener_unidades_academicas();
        $this->load->view('admin/registros/regislist', $data); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $this->input->post('username');
            $contrasena = $this->input->post('password');
            $unidad_academica = $this->input->post('unidad_academica');

            $registro_exitoso = $this->Usuarios_model->registrar_usuario($nombre, $contrasena, $unidad_academica);
            if ($registro_exitoso) {
             
                redirect(base_url('principal')); 
            } else {
                $data['error'] = 'Error al registrar el usuario.';
                $this->load->view('admin/registros/regislist', $data); 
            }
        }
    }
}
