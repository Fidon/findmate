<?php

date_default_timezone_set('Africa/Dar_es_Salaam');
$config = mysqli_connect('localhost','root','','findmates');
if (!$config) {
  die("Failed to connect to database");
}

?>
