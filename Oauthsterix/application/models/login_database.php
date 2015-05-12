<?php

	Class Login_Database extends CI_Model {


	public function registering($userinfo) {
		$this->db->insert('users', $userinfo);
	}

	// Read data using username and password
	public function login($data) {

		$condition = "EMAIL =" . "'" . $data['EMAIL'] . "' AND " . "PASSWORD =" . "'" . $data['PASSWORD'] . "'";
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function build_session($session_data) {

		$this->session->set_userdata('logged_in', $session_data);
		$result = $this->login_database->read_user_information($session_data);
		if($result != false)
		{
			$data = array(
				// 'name' =>$result[0]->name,
				'username' =>$result[0]->USERNAME,
				'email' =>$result[0]->EMAIL,
				'password' =>$result[0]->PASSWORD
			);


			$data['logged_in'] = TRUE;
			$session_data = $data;
			$this->session->set_userdata('logged_in', $session_data);
			
			redirect("/oauth/personalinfo/");

			$this->load->view('admin_page', $data);

		}

	}

	// Read data from database to show data in admin page
	public function read_user_information($sess_array) {

		$condition = "EMAIL =" . "'" . $sess_array['email'] . "'";
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}



}

?>