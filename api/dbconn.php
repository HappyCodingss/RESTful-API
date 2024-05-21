<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "sound_nexus";

$conn = new mysqli($host, $user, $pass, $db) or die("Can't Conneect to the Database!");
return $conn;

?>