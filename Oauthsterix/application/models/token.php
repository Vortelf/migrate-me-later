<?php

	Class Token extends CI_Model {

		protected $Token;

		public function generate()
		{

			$Token = array(
				'timestamp' => time(),
				'require_once' 	=> md5(mt_rand())
				);

			return $Token;
		}

		public function post_token_db() {
			$this->db->insert('users', $tokeninfo);
		}
	}

?>