<?php

	Class Scope extends CI_Model {



		public function get_scope_information($scopes)
		{
			$scope_info = [];
			foreach ($scopes as $scope) {
				$scope_info = array_merge($scope_info, $this->fetch_from_db($scope));
			}

			return $scope_info;
		}


		function fetch_from_db($scope)
		{
			$data = $this->getController()->session->all_userdata();
			if(!isset($data['logged_in']))
			{
				$error_args = array(
					'title' => 'Authorization Error',
					'message' => "No Session Found </br>
									Not Logged In.",
					'action' => FALSE
				);

				$this->getController()->session->set_flashdata('error_args',$error_args);
				redirect("/oauth/error");
			}
			$condition = "USERNAME = '" . $data['logged_in']['username'] . "'";
			$this->db->select($this->scope_to_db($scope));
			$this->db->from('users');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				// print_r($query->result()[0]);
				return get_object_vars($query->result()[0]);
			} else {
				return false;
			}
		}

		function scope_to_db($scope)
		{
			switch ($scope) {
				case "name": return "FIRSTNAME,LASTNAME"; break;
				case "email": return "EMAIL"; break;
				case "phone_number": return "PHONENUMBER"; break;
				case "date_of_birth": case "age": return "DATE_OF_BIRTH"; break;
				case "username": return "USERNAME"; break;
				default: return "*";
			}
		}

		public function scope_parse($scope_arr)
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
		

		function getController()
		{
			$controllerInstance = & get_instance();
			// Calling Controller Method
			// $controllerData = $controllerInstance->ControllerMethod();
			return $controllerInstance;
		}
	}
?>