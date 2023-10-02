<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Carga el modelo de usuarios si es necesario
        $this->load->model('Usuarios_model');
    }

    public function login() {
        // Verifica si el usuario ya está autenticado, si lo está, redirige a la página de inicio.
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('principal')); // Utiliza base_url() para generar la URL
        }
    
        // Carga la librería de form_validation de CodeIgniter.
        $this->load->library('form_validation');
    
        // Define las reglas de validación para el formulario de inicio de sesión.
        $this->form_validation->set_rules('username', 'Nombre de Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_rules('unidad_academica', 'unidad_academica', 'required'); // Agrega esta regla
    
        // Si el formulario no se envió o no pasó las reglas de validación, muestra la vista de inicio de sesión.
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/usuarios/login_view');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $unidad_academica = $this->input->post('unidad_academica');
    

            $authenticated = $this->Usuarios_model->validar_credenciales_y_unidad($username, $password, $unidad_academica);
    
            if ($authenticated) {

                $this->session->set_userdata('logged_in', TRUE);
                 // Guarda el nombre de usuario y la unidad académica en variables de sesión
                $this->session->set_userdata('nombre_usuario', $username);
                $this->session->set_userdata('unidad_academica', $unidad_academica);
                redirect(base_url('principal'));
            } else {

                $data['error'] = 'Datos incorrectos o no tiene acceso a esta unidad académica';
                $this->load->view('admin/usuarios/login_view', $data);
            }
        }
    }
    

    public function logout() {
        // Cierra la sesión del usuario y redirige a la página de inicio de sesión.
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect(base_url('Login/index'));
    }
}
