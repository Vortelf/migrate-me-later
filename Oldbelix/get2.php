<?php
$json = $_POST['json'];

$new = json_decode($json);
echo 'Hello '. $new->FIRSTNAME.' ' .$new->LASTNAME. ' you were born ' .$new->DATE_OF_BIRTH;
//echo $json;
?>