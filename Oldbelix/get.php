<?php
	$json = $_POST['json'];
	$json_data = get_object_vars(json_decode($json));
	$arr = [];
	foreach ($json_data as $key ) {
		$tmp = get_object_vars($key);
		$arr[$tmp['type']] = $tmp;
	};
	$token = $arr['access']['token'];
	echo $token;
	$url = 'http://91.139.244.8/oauthsterix/oauth/request_information?access_token='.$token.'&redirect_uri=http://158.58.239.182/migrate-me-later/oldbelix/get2.php';
	header("Location: ". $url);
?>