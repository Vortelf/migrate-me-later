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

		public function get_scopes($scope_arr)
		{

			$scopes = array(
						'read' => '',
						'update' => '',
					);

			$exploded = (explode(":", $scope_arr));

			foreach (explode(",", $exploded[1]) as $shrap) {
				$scopes[$exploded[0]][] .= $shrap;
			}
			if(isset($exploded[3]))
			{
				foreach (explode(",", $exploded[3]) as $shrap) {
					$scopes[$exploded[2]][] .= $shrap;
				}

			}

			return $scopes;

		}

		public function get_scope_description($type, $scope)
		{
			$condition = "scope = '" . $scope . "'" . " AND " . "type = '" . $type . "'" ;
			$this->db->select('description');
			$this->db->from('scopes');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				return $query->result()[0];
			} else {
				return false;
			}
		}

		public function get_scope_description_array($scope_arr) {

			$scopes = array(
						'read' => '',
						'update' => '',
					);

			$exploded = (explode(":", $scope_arr));

			// read:name,email:update:phone_number
			//
			//  [scope] => Array ( 
			// 						[read] => Array ( 
								// 						[0] => name [1] => email 
								// 					) 
								// 	[update] => Array ( 
								// 						[0] => phone_number )
								// 					)
								// )


			foreach (explode(",", $exploded[1]) as $shrap) {
				$scopes[$exploded[0]][] .= $this->get_scope_description($exploded[0],$shrap)->description;
			}
			if(isset($exploded[3]))
			{
				foreach (explode(",", $exploded[3]) as $shrap) {
					$scopes[$exploded[2]][] .= $this->get_scope_description($exploded[2],$shrap)->description;
				}

			}

			return $scopes;
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