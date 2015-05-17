<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Oauth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('user_model');
		$this->load->library('session');

		// Load database
		$this->load->model('login_database');
		$this->load->model('token');

		$this->load->library('form_validation');

		$this->load->helper(array('form', 'url'));
		$this->load->library('javascript');
		$this->load->library('javascript/jquery');
	}


	public function index()
	{	
		
		$data['title'] = 'Oauthsterix';
		$this->load->view('fragments/style.html');
		$this->load->view('fragments/menu.html');
		$this->load->view('index.php');
		$this->load->view('fragments/footer.html');
	}

	
	public function registration()
	{	
		$this->load->view('fragments/style.html');
		$this->load->view('fragments/menu.html');


		// $this->load->helper(array('form', 'url'));
		// $this->load->library('javascript');
		

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('user_name', 'Username', 'trim|is_unique[users.username]');
		$this->form_validation->set_rules('validation_check', 'Validation', 'callback_validation_check');
		$this->form_validation->set_error_delimiters('<div class="ERROR_" id="VALIDATION_ERROR_"/>', '</div>');

		$this->form_validation->set_message('is_unique', 'This %s is already in use.');

		if ($this->form_validation->run() == FALSE)
		{
			// set_value('validation_check');
			$this->load->view('registration_view.php');
		}
		else
		{
			$userinfo = '';
			$userinfo['USERNAME'] = $_POST['user_name'];
			$userinfo['EMAIL'] = $_POST['email'];
			$userinfo['PASSWORD'] = md5($_POST['password']);
			$userinfo['FIRSTNAME'] = $_POST['first_name'];
			$userinfo['LASTNAME'] = $_POST['last_name'];
			$userinfo['PHONENUMBER'] = $_POST['phone'];
			$userinfo['DATE_OF_BIRTH'] = $_POST['ageyear']."-".$_POST['agemonth']."-".$_POST['ageday'];

			$this->login_database->registering($userinfo);

			$this->success();
		}

		$this->load->view('fragments/footer.html');
	}


	public function validation_check($str)
	{

		// if($str == md5($_POST['user_name']))
		if($str == 1)
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
		// $query = $this->db->query('SELECT * FROM users');
		// if ($query->num_rows()) {
		// 	foreach ($query->result() as $row)
		// 	{
		// 		echo $row->USERNAME . ' ' . $row->EMAIL . '<br>';
		// 	}
		// 	return true;
		// }

	}

	public function personalinfo() {
		$data = $this->session->all_userdata();
		$this->load->view('fragments/style.html');
		$this->load->view('fragments/menu.html');

		if(!isset($data['logged_in']['logged_in'])) {
			$error = array(
					'title' => "Oauthsterix - Error: Not Logged In",
					'message' => "You have to be logged in to access your Personal Info.",
					'action' => "Login",
					'url' => "/oauthsterix/oauth/login"
				);
			$this->load->view('fragments/error.php',$error);
		} else {

			$this->load->view('admin_page', $data['logged_in']);

			// print_r( $data['logged_in']);
		}
		$this->load->view('fragments/footer.html');
	}



	public function login()
	{

		$this->load->view('fragments/style.html');
		$this->load->view('fragments/menu.html');
		
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<div class="ERROR_" id="VALIDATION_ERROR_"/>', '</div>');


		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login_view.php');
		} else {

			$logincredentials = '';
			$logincredentials['EMAIL'] = $_POST['email'];
			$logincredentials['PASSWORD'] = md5($_POST['password']);


			$result = $this->login_database->login($logincredentials);

			if($result == TRUE)
			{
				$session_data = array(
					'email' => $_POST['email']
				);
				$this->login_database->build_session($session_data);

			} else {
				$data = array(
				'error_message' => 'Invalid Email/Username or Password'
				);
				$this->load->view('login_view.php', $data);
			}
		}


		$this->load->view('fragments/footer.html');

	}

	public function logout() {

		// Removing session data
		$session_data = array(
			'email' => ''
		);
		$this->session->unset_userdata('logged_in', $session_data);
		// $data['message_display'] = 'Successfully Logout';
		// $this->login();
		redirect("/");
	}



	public function access_request()
	{
		$this->load->model('application');

		$client = array(
			'client_id' => (isset($_GET['consumer_id'])? $_GET['consumer_id'] : NULL ),
			'scope' => (isset($_GET['scope'])? $_GET['scope'] : NULL),
			);

		$client['application_name'] = $this->application->get_application_name($client['client_id'])->application_name;

		$throw_error = FALSE;

		if(!$client['application_name'])
		{
			$error_args = array(
				'title' => 'Authorization Error',
				'message' => "Your application credentials doesn't match any registered application. </br>
									Please check your application information and try again. </br>
									In case you hadn't registered your applicatino, visit the following link.",
				'action' => "Application Registration",
				'url' => "/oauth/application_registration/"
			);

			$throw_error = TRUE;

		} else if(!$client['scope']) {
			$error_args = array(
				'title' => 'Authorization Error',
				'message' => "The scope of your request is missing. </br>
									Please check your application information and try again.",
				'action' => FALSE
			);

			$throw_error = TRUE;
		}

		if($throw_error)
		{
			$this->session->set_flashdata('error_args',$error_args);
			redirect("/oauth/error");
		}

		// print_r($client);
		$GETREQUEST = "" .  (isset($client['client_id'])? "client_id=" . $client['client_id'] . "&" : "") . 
		(isset($client['scope'])? "scope=" . $client['scope'] . "&" : "");

		redirect("/oauth/authorization/".$client['application_name']."?".$GETREQUEST);
		// $this->Authorization($client);

		// http://localhost/oauthsterix/oauth/access_request?consumer_id=Ru19lQzS1hpAuwTLQLSoFKHU3GbiBhH2&scope=read:name,email:update:phone_number
	}



	public function Authorization($client)
	{
		$this->load->model('application');

		$data = $this->session->all_userdata();
		$data['title'] = 'Authorization Request - Oauthsterix';
		// echo $client;
		$data['application_name'] = (isset($client['application_name'])? $client['application_name']: $client);
		$data['scope'] = (isset($client['scope'])? $client['scope']: $_GET['scope']);
		
		$scope = $this->application->get_scopes($data['scope']);

		$data['scope_description'] = $this->application->get_scope_description_array($data['scope']);

		unset($data['scope']);

		$data['scope'] = $scope;

		// print_r($data);


		$token = $this->token->generate();
		// print_r($token);
		$data['token'] = $token['require_once'];
		// print_r($data);
		$this->load->view('fragments/style.html');
		$this->load->view('authorization.php',$data);
	}


	public function application_registration()
	{

		$this->load->model('application');
		$this->load->view('fragments/style.html');

		$this->form_validation->set_rules('application_name', 'Application Name', 'trim|is_unique[applications.application_name]|required');
		$this->form_validation->set_error_delimiters('<div class="ERROR_" id="VALIDATION_ERROR_"/>', '</div>');
		$this->form_validation->set_message('is_unique', 'This %s is already registered.');
		$this->form_validation->set_message('required', 'You must enter %s.');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('application_registration');
		}
		else
		{
			$application_info = array(
								'application_name' => $_POST['application_name'],
								'redirect_uri' => ''
							);

			$registration_info = $this->application->registration($application_info);

			$this->application_registration_completed($registration_info);
		}
	}




	public function application_registration_completed($registration_info)
	{
		$this->load->view('fragments/style.html');
		$data = $registration_info;
		$data['json'] = json_encode($data);
		$data['title']= 'Registration Successful! Application Needs to be Approved.';
		$this->load->view('application_registration_completed',$data);
		// print_r($registration_info);
	}

		public function error()
	{
		
		$this->load->view('fragments/style.html');
		// $error_args = array(
		// 		'title' => $error['title'],
		// 		'message' => $error['message'],
		// 		'action' => $error['action'],
		// 		'url' => $error['url']
		// 	);
		$error_args = $_SESSION['error_args'];
		$this->load->view('fragments/error.php',$error_args);

	}

}