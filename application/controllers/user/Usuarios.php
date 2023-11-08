<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->library('form_validation');
        

    }

    public function login() {
        $this->load->view("layouts/header");
        $this->load->view("layouts/footer");
        if ($this->session->userdata('logged_in')) {
            redirect('principal');
        }

        $this->form_validation->set_rules('username', 'Nombre de Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_rules('unidad_academica', 'Unidad Académica', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view("layouts/header");
            $this->load->view('admin/usuarios/login_view');
            $this->load->view("layouts/footer");
        } else {
            $username = trim($this->input->post('username'));
            $password = $this->input->post('password');
            $unidad_academica = $this->input->post('unidad_academica');

            $contraseña_hash = $this->Usuarios_model->obtener_contraseña_por_usuario($username);

            if ($contraseña_hash && password_verify($password, $contraseña_hash)) {
                // Las contraseñas coinciden
                $authenticated = $this->Usuarios_model->validar_credenciales_y_unidad($username, $contraseña_hash, $unidad_academica);
            } else {
                $authenticated = false;
            }

            if ($authenticated) {
                // Establecer la sesión para el usuario autenticado
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('Nombre_usuario', $username);
                $this->session->set_userdata('unidad_academica', $unidad_academica);

                // Recupera el ID del usuario recién autenticado
                $usuario = $this->Usuarios_model->obtener_usuario_por_nombre($username);
                $this->session->set_userdata('id_user', $usuario->id_user);

                redirect('principal');
            } else {
                $data['error'] = 'Datos incorrectos o no tiene acceso a esta unidad académica';
                $this->load->view('admin/usuarios/login_view', $data);
            }
        }
    }


    
    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('Nombre_usuario');
        $this->session->unset_userdata('unidad_academica');
        $this->session->unset_userdata('id_user');
        session_destroy();
        redirect('/');
    }
}
