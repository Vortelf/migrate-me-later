<?php
$json = $_POST['json'];

json_decode($json);
echo $json->FIRSTNAME;

?>