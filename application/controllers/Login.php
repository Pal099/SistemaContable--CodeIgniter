<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model');
        $this->load->library('form_validation');
        

    }
	public function index()
	{

		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules("username",'Username','required');
			$this->form_validation->set_rules("contraseña",'Contraseña','required');
			$this->form_validation->set_rules('unidad_academica', 'Unidad_academica', 'required');

			if($this->form_validation->run()==TRUE)
			{
				$username = $this->input->post('username');
				$password = $this->input->post('contraseña');
				$unidad_academica = $this->input->post('unidad_academica');
				$id_user=$this->session->userdata('id_user');
				$encrypPassword = sha1($password);
				$this->load->model('Usuarios_model');
				$nombre_unidad_academica = $this->Usuarios_model->getNombreUnidadAcademica($unidad_academica);

				$status = $this->Usuarios_model->checkUser($username,$encrypPassword,$unidad_academica,$id_user,$nombre_unidad_academica);
				if($status!=false)
				{

					$data = array(
						'Nombre_usuario'=>$status->Nombre_usuario,
						'contraseña'=>$status->contraseña,
						'id_unidad' =>$status->id_unidad,
						'id_user'=>$status->id_user,
						'unidad' => $status->unidad, // Añadir el nombre de la unidad académica
					);
					$this->session->set_userdata('Nombre_usuario', $username);
              		$this->session->set_userdata('unidad_academica', $unidad_academica);
					$this->session->set_userdata('id_user',$id_user);
					$this->session->set_userdata('unidad', $nombre_unidad_academica); // Agregar el nombre de la unidad académica a la sesión

					$this->session->set_userdata('LoginSession',$data);
					redirect(base_url('principal'));

				}
			
				else
				{
					$this->session->set_flashdata('error','Las credenciales no son correctas');
					redirect(base_url('login'));
				}


			}
			else
			{
				$this->load->view('admin/usuarios/login_view');
			}
		}
		else
		{
			$this->load->view('admin/usuarios/login_view');
		}
		
	}

	function logout()
	{
		session_unset();
		session_destroy();
		redirect(base_url('login'));
	}
}