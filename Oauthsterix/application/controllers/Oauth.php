<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Oauth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('user_model');
	}

	public function index()
	{	
		
		$data['title'] = 'Oauthsterix';
		$this->load->view('fragments/menu.html',$data);
		
		$this->load->view('fragments/footer.html',$data);
	}
	
	public function register()
	{	
		$data['title'] = 'Register - Oauthsterix';
		$this->load->view('fragments/menu.html',$data);

		$this->load->view('fragments/footer.html',$data);		


		$this->load->helper(array('form', 'url'));
		$this->load->library('javascript');

		$this->load->library('form_validation');
		
		
		// $this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('validation_check', 'Validation', 'callback_validation_check');


		if ($this->form_validation->run() == FALSE)
		{
			// set_value('validation_check');
			$this->load->view('registration_view.php');
		}
		else
		{
			$this->success();
		}
	}

	public function validation_check($str)
	{

		if($str == md5($_POST['user_name']))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('validation_check', 'The field validation failed. Please check the entered information and if it matches the criterium and try again.');
			return FALSE;
		}
	}

	public function success()
	{
		$data['title']= 'Registration Successful!';
		
		$this->load->view('success.php', $data);

	}

	public function login()
	{
		$data['title']= 'Login! - Oauthsterix';
		$this->load->view('fragments/menu.html',$data);
		$this->load->view('login_view.php', $data);
		$this->load->view('fragments/footer.html',$data);
	}

}