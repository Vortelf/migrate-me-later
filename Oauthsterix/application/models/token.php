<?php

	Class Token extends CI_Model {

		protected $Token;

		public function create()
		{

			$date = new DateTime(date("Y-m-d h:i:s"));
			$date->modify('+1 hour');
			

			$Token = array(
				'token' 	=> bin2hex(openssl_random_pseudo_bytes(32)),
				'timestamp' => $date->format('Y-m-d h:i:s')
				);

			return $Token;
		}


		public function token_bundle($refresh)
		{

			$bundle['access_token'] = $this->create();
			if($refresh)
			{
				$bundle['refresh_token'] = $this->create();
			} else {
				$bundle['refresh_token'] = "N/A";
			}
		}

	}

?>