<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules("email",'Email','required');
			$this->form_validation->set_rules("password",'Password','required');
			if($this->form_validation->run()==TRUE)
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$encrypPassword = sha1($password);
				$this->load->model('user_model');
				$status = $this->user_model->checkUser($email,$encrypPassword);
				if($status!=false)
				{
					$data = array(
						'username'=>$status->user_name,
						'email'=>$status->email,
						'id'=>$status->id,
					);
					$this->session->set_userdata('LoginSession',$data);
					redirect(base_url('admin/dashboard/index'));

				}
				else
				{
					$this->session->set_flashdata('error','Email Id or Password is Wrong');
					redirect(base_url('login/index'));
				}


			}
			else
			{
				$this->load->view('login');
			}
		}
		else
		{
			$this->load->view('login');
		}
		
	}

	function logout()
	{
		session_unset();
		session_destroy();
		redirect(base_url('login/index'));
	}
}
