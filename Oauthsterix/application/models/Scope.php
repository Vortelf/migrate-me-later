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

		function getController()
		{
			$controllerInstance = & get_instance();
			// Calling Controller Method
			// $controllerData = $controllerInstance->ControllerMethod();
			return $controllerInstance;
		}
	}
?>