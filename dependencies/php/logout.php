<?php
error_reporting(1000);
require "pdo.php";
session_start();

$sanitized = $_SESSION;
$sanitized['username'] = null;

$sql = "UPDATE users SET sessionID=null WHERE username=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['username']]);
$_SESSION = [];
header('Location: ../../login.php?alert=logout_success');
$loggedIn = false;
echo "Aan het uitloggen";
session_destroy();


?>