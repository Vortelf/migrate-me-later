<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Oauth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');

		// Load database
		$this->load->model('login_database');
		$this->load->model('token');

		$this->load->library('form_validation');

		$this->load->helper(array('form', 'url'));
		$this->load->library('javascript');
		$this->load->library('javascript/jquery');
		$this->load->view('fragments/icon.html');
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
				redirect("/oauth/personalinfo/");

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
		print_r($this->input->get('redirect_uri'));

		$client['redirect_uri'] = $this->input->get('redirect_uri')? $this->input->get('redirect_uri') : "NA";



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


		// $GETREQUEST = "" .  (isset($client['client_id'])? "client_id=" . $client['client_id'] . "&" : "") . 
		// (isset($client['scope'])? "scope=" . $client['scope'] . "&" : "");

		// $client['GETREQUEST'] = $GETREQUEST;


		$date = new DateTime(date("Y-m-d h:i:s"));
		$date->modify('+1 hour');
		$client['created_on'] = $date->format('Y-m-d h:i:s');

		
		$client['TTL'] = new DateTime(date("Y-m-d h:i:s"));
		$client['TTL']->modify('+1 hour');
		$client['TTL']->modify('+300 seconds');
		$client['TTL'] = $client['TTL']->format('Y-m-d h:i:s');


		$this->application->make_access_request($client);

		// redirect("/oauth/authorization/".$client['application_name']."?".$GETREQUEST);
		// $this->Authorization($client);

		// http://localhost/oauthsterix/oauth/access_request?consumer_id=Ru19lQzS1hpAuwTLQLSoFKHU3GbiBhH2&scope=read:name,email:update:phone_number
	}



	public function Authorization()
	{
		$this->load->model('application');
		$this->load->view('fragments/style.html');

		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<div class="ERROR_" id="VALIDATION_ERROR_"/>', '</div>');

		$data = $this->session->all_userdata();

		if(isset($_GET['auth_code'])){
			$auth_code = $_GET['auth_code'];
		} else {
			$error_args = array(
				'title' => 'Authorization Error',
				'message' => "Authorization Failure </br>
								Authentication Code is missing.",
				'action' => FALSE
			);

			$this->session->set_flashdata('error_args',$error_args);
			redirect("/oauth/error");
		}


		if(!$this->application->get_request_info($auth_code))
		{
			$error_args = array(
				'title' => 'Authorization Error',
				'message' => "Authorization Failure </br>
								Invalid Authorization Code.",
				'action' => FALSE
			);

			$this->session->set_flashdata('error_args',$error_args);
			redirect("/oauth/error");
		} else {
			$data = array_merge($data,$this->application->get_request_info($auth_code));
			$data['auth'] = $auth_code;
		}
		

		$data['title'] = 'Authorization Request - Oauthsterix';

		$data['application_name'] = $this->application->get_application_name($data['client_id'])->application_name;

		if($this->session->flashdata('scope'))
		{
			$oldscope = $this->session->flashdata('scope');
			$this->session->keep_flashdata('scope');

		} else { 
			$oldscope = $data['scope'];
			$this->session->set_flashdata('scope',$oldscope);
		}
		
		$scope = $this->application->get_scopes($data['scope']);


		$data['scope_description'] = $this->application->get_scope_description_array($data['scope']);

		unset($data['scope']);

		$data['scope'] = $scope;






		$data['session_exists'] = FALSE;
		$form_submit = $this->input->post('formsubmit');
		if($form_submit == "cancel")
		{
			redirect('/oauth/access_denied');
		}

		if($this->session->userdata('logged_in'))
		{
			$data['session_exists'] = TRUE;
			$this->load->view("authorization.php",$data);
			
			if($form_submit == "submit")
			{

				$GETREQUEST = "grant_type=authorization_code" . "&" . "auth_code=". $data['auth'] . "&" .
								"client_id=" . $data['client_id'] . "&" . "redirect_uri=" . $data['redirect_uri'];

				redirect('/oauth/collect_tokens?'.$GETREQUEST);
			} else if($form_submit == "cancel") {
				redirect('/oauth/access_denied');
			}
		} else {
			if ($this->form_validation->run() == FALSE) 
			{
				$this->load->view("authorization.php",$data);
			} else {
				$data['GETREQUEST'] = "grant_type=authorization_code" . "&" . "auth_code=". $data['auth'] . "&" .
								"client_id=" . $data['client_id'] . "&" . "redirect_uri=" . $data['redirect_uri'];
 				$this->application->authorization_login($data);
			}
		}
				
	}

	public function collect_tokens()
	{
		$this->load->model('application');
		$this->load->model('token');

		$get_info = array(
			'grant_type' => $this->input->get('grant_type'),
			'redirect_uri' => $this->input->get('redirect_uri'),
			'client_id' => $this->input->get('client_id'),
			// 'client_secret' => $this->input->get('client_secret'),
			 );

		if($get_info['grant_type'] == "authorization_code")
		{
			$get_info['auth_code'] = $this->input->get('auth_code');
			if($this->token->auth_code_used($get_info['auth_code']))
			{
				$error_args = array(
					'title' => 'Authorization Error',
					'message' => "Authorization Failure </br>
									Authorization Code is already used.",
					'action' => FALSE
				);

				$this->session->set_flashdata('error_args',$error_args);
				redirect("/oauth/error");
			}
			if($this->token->auth_code_expired($get_info['auth_code']))
			{
				$error_args = array(
					'title' => 'Authorization Error',
					'message' => "Authorization Failure </br>
									Authorization Code is expired.",
					'action' => FALSE
				);

				$this->session->set_flashdata('error_args',$error_args);
				redirect("/oauth/error");
			}
		}
		else 
		// if($get_info['grant_type'] == "password")
		// {
		// 			$get_indo['username'] == $this->input->get('username');
		// 			$get_indo['password'] == $this->input->get('password');
		// }
		// else
		if($get_info['grant_type'] == "refresh_token")
			$get_info['refresh_token'] = $this->input->get('refresh_token');



		$token = $this->token->token_bundle(true);


		print_r(json_encode($token));
		
		$access_token = array_merge($get_info,$token['access_token']);
		$access_token['scope'] = $this->session->flashdata('scope');
		$this->token->save_token($access_token);

		if($token['refresh_token'])
		{
			$refresh_token = array_merge($get_info,$token['refresh_token']);
			$refresh_token['scope'] = $this->session->flashdata('scope');
			$this->token->save_token($refresh_token);
		}


	}


	public function request_information()
	{
		$this->load->model('application');
		$this->load->model('token');
		$this->load->model('scope');

		$data = array(
			'access_token' => $this->input->get('access_token'), 
			);

		if($this->token->token_expired($data['access_token']))
		{
			$error_args = array(
				'title' => 'Authorization Error',
				'message' => "Authorization Failure </br>
								Access Token is expired.",
				'action' => FALSE
			);

			$this->session->set_flashdata('error_args',$error_args);
			redirect("/oauth/error");
		}

		
		$scopes = $this->token->get_scopes($data['access_token']);

		// if(!$scopes)
		// {
		// 	$error_args = array(
		// 		'title' => 'Authorization Error',
		// 		'message' => "Total Failure. </br>
		// 						Nor even we can explain what happened.",
		// 		'action' => FALSE
		// 	);

		// 	$this->session->set_flashdata('error_args',$error_args);
		// 	redirect("/oauth/error");
		// }

		$scope_array = $this->application->get_scopes($scopes);
		$read = $scope_array['read'];

		print_r( json_encode($this->scope->get_scope_information($read)) );
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




	public function access_denied($value='')
	{
		$error = array(
			'error' => 'access denied' );
		echo json_encode($error);
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
		
		if(isset($_SESSION['error_args']))
		{
					$error_args = $_SESSION['error_args'];
					$this->load->view('fragments/error.php',$error_args);
		}
		else
			$this->load->view('fragments/errorception.php');

	}

}