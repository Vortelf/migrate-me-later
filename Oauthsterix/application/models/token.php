<?php

	Class Token extends CI_Model {

		public function generate() {

			$token = array(
				'timestamp' 	=> time(),
				'require_once' 	=> md5(mt_rand())
				);

			return $token;
		}


	}



?>