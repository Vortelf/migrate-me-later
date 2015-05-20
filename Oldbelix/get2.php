<?php
$json = $_POST['json'];

$new = json_decode($json);
echo '<h1>Hello '. $new->FIRSTNAME.' ' .$new->LASTNAME. ' you were born ' .$new->DATE_OF_BIRTH.'</h1>';
//echo $json;
?>