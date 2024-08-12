<?php defined('BASEPATH') or exit('');
class Dashboard extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('dashboard');
	}

	function changePassword()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->set_rules('currentPassword','Current Password','required');
			$this->form_validation->set_rules('password','New Password','required');
			$this->form_validation->set_rules('cpassword','Confirm New Password','required|matches[password]');
			if($this->form_validation->run()==TRUE)
			{
				 $currentPassword = $this->input->post('currentPassword');
				 $encryptCurrentPassword = sha1($currentPassword);
				 $this->load->model('user_model');
				 $check = $this->user_model->checkCurrentPassword($encryptCurrentPassword);
				 if($check==true)
				 {
				 	$newPassword = $this->input->post('password');
				 	$encryptPassword = sha1($newPassword);
				 	$this->user_model->updatePassword($encryptPassword);

				 	$this->session->set_flashdata('success','Password changed Successfully');
				 	redirect(base_url('admin/dashboard/changePassword'));
				 }
				 else
				 {
				 	$this->session->set_flashdata('error','Current Password is wrong');
				 	redirect(base_url('admin/dashboard/changePassword'));
				 }
			}
			else
			{
				$this->load->view('change_password');
			}
		}
		else
		{
			$this->load->view('change_password');
		}
	}
}