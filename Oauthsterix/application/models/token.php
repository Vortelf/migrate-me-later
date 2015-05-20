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
	}

?>