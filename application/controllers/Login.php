<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->model('Unidad_academica_model');
        $this->load->library('form_validation');
    }

    public function index() {

		//Obtenemos las unidades academicas para el dropdown de la vista login
        $data['unidades'] = $this->Unidad_academica_model->obtener_unidades_academicas();

        //Comprobando si los datos llegan a nuestro controlador
        if ($this->input->post()) {
            $this->form_validation->set_rules("username", 'Username', 'required');
            $this->form_validation->set_rules("contraseña", 'Contraseña', 'required');
            $this->form_validation->set_rules('unidad_academica', 'Unidad académica', 'required');

            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $password = $this->input->post('contraseña');
                $unidad_academica = $this->input->post('unidad_academica');
                $id_user = $this->session->userdata('id_user');
                $encrypPassword = sha1($password);

                $nombre_unidad_academica = $this->Usuarios_model->getNombreUnidadAcademica($unidad_academica);
                $status = $this->Usuarios_model->checkUser($username, $encrypPassword, $unidad_academica, $id_user, $nombre_unidad_academica);

                if ($status != false) {
                    $data = array(
                        'Nombre_usuario' => $status->Nombre_usuario,
                        'contraseña' => $status->contraseña,
                        'id_unidad' => $status->id_unidad,
                        'id_user' => $status->id_user,
                        'unidad' => $status->unidad, // Añadir el nombre de la unidad académica
                    );
                    $this->session->set_userdata('Nombre_usuario', $username);
                    $this->session->set_userdata('unidad_academica', $unidad_academica);
                    $this->session->set_userdata('id_user', $id_user);
                    $this->session->set_userdata('unidad', $nombre_unidad_academica); // Agregar el nombre de la unidad académica a la sesión

                    $this->session->set_userdata('LoginSession', $data);
                    redirect(base_url('principal'));
                } else {
                    $this->session->set_flashdata('error', 'Las credenciales no son correctas');
                    redirect(base_url('/'));
                }
            }
        }

        $this->load->view('admin/usuarios/login_view', $data);
    }

    public function logout() {
        $this->session->unset_userdata('LoginSession');
        $this->session->sess_destroy();
        redirect(base_url('/'));
    }
}
?>
