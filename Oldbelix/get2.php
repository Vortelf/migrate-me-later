<?php
$json = $_POST['json'];

$new = json_decode($json);

$arr2 = str_split($new->DATE_OF_BIRTH, 4);
$year = (int)$arr2[0];
echo '<h1>Hello '. $new->FIRSTNAME.' ' .$new->LASTNAME. ' you are ' . (int) (2015 - $year).' years old</h1>';
?>