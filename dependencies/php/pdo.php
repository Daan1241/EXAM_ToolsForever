<?php
$dbservername = "localhost";
$dbusername = "forevertools";
$dbpassword = "forevertools_password"; // Sensitive data, do not commit to Github
$connection = new PDO("mysql:host=$dbservername;dbname=toolsforever", $dbusername, $dbpassword);

?>