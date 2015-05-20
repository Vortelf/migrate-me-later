<?php

	Class Token extends CI_Model {

		protected $Token;

		public function create($type)
		{

			$date = new DateTime(date("Y-m-d h:i:s"));
			$date->modify('+1 hour');
			$live_until = new DateTime(date("Y-m-d h:i:s"));
			$live_until->modify('+1 hour');
			$live_until->modify('+300 seconds');

			$Token = array(
				'type'			=> $type,
				'token' 		=> bin2hex(openssl_random_pseudo_bytes(32)),
				'timestamp' 	=> $date->format('Y-m-d h:i:s'),
				'live_until'	=> $live_until->format('Y-m-d h:i:s')
				);

			return $Token;
		}


		public function token_bundle($refresh)
		{

			$bundle['access_token'] = $this->create("access");
			if($refresh)
			{
				$bundle['refresh_token'] = $this->create("refresh");
			}
			// } else {
			// 	$bundle['refresh_token'] = "N/A";
			// }

			return $bundle;
		}


		public function save_token($token_info)
		{
			unset($token_info['grant_type']);
			unset($token_info['redirect_uri']);
			$token_info['TTL'] = $token_info['live_until'];
			unset($token_info['live_until']);
			$token_info['created_on'] = $token_info['timestamp'];
			unset($token_info['timestamp']);
			$this->db->insert('tokens', $token_info);
		}

		public function auth_code_used($auth_code)
		{
			$condition = "auth_code = '" . $auth_code . "'";
			$this->db->select('auth_code');
			$this->db->from('tokens');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				return true;
			} else {
				return false;
			}
		}

		public function auth_code_expired($auth_code)
		{
			$condition = "auth_code = '" . $auth_code . "'";
			$this->db->select('TTL');
			$this->db->from('access_requests');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				$result = $query->result()[0]->TTL;
			} else {
				return false;
			}

			$date = new DateTime(date("Y-m-d h:i:s"));
			$date->modify('+1 hour');

			$result = new DateTime($result);

			$this->db->select('TTL');
			$this->db->from('access_requests');
			$this->db->where($condition);
			$this->db->delete();

			if( strtotime($result->format('Y-m-d h:i:s')) <= strtotime($date->format('Y-m-d h:i:s')) ) 
				return true; 
			else
				return false;

		}

		public function token_expired($token)
		{
			$condition = "token = '" . $token . "'";
			$this->db->select('TTL');
			$this->db->from('tokens');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				$result = $query->result()[0]->TTL;
			} else {
				return false;
			}

			$date = new DateTime(date("Y-m-d h:i:s"));
			$date->modify('+1 hour');

			$result = new DateTime($result);


			if( strtotime($result->format('Y-m-d h:i:s')) <= strtotime($date->format('Y-m-d h:i:s')) ) 
				return true; 
			else
				return false;

		}


		public function get_scopes($token)
		{
			$condition = "token = '" . $token . "'";
			$this->db->select('scope');
			$this->db->from('tokens');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				return $query->result()[0]->scope;
			} else {
				return false;
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