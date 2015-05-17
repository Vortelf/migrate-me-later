<?php

	Class application extends CI_Model {

		public function generateRandomString($length = 32) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}


		public function registration($appnfo) {



			$application_info = array(
				'application_name' => $appnfo['application_name'],
				'client_id' => $this->generateRandomString(),
				'client_secret' => $this->generateRandomString(),
				'redirect_uri'  => $appnfo['redirect_uri']
				);


			$this->db->insert('applications', $application_info);

			return $application_info;
		}

		public function get_application_name($client_id)
		{
			$condition = "CLIENT_ID = '" . $client_id . "'";
			$this->db->select('application_name');
			$this->db->from('applications');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				return $query->result()[0];
			} else {
				return false;
			}
		}


		// VERY IMPORTANT FUNCTION
		//
		// ACCESSING CONTROLLERS FUNCTIONS INSIDE A MODEL

		function getController()
		{
			$controllerInstance = & get_instance();
			$controllerData = $controllerInstance->getData();
		}


	}

?>