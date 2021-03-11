<?php
require "pdo.php";
$sanitized = json_decode($_POST['modify_data']);

print_r($sanitized);
//echo $sanitized['modify_data'][0];
$sql = "UPDATE users SET email=?, username=?, privileges=? WHERE UUID = ?";
$run = $connection->prepare($sql);
$run->execute([$sanitized[2], $sanitized[1], strtolower($sanitized[3]), $sanitized[0]]);
$dbdata_privileges = $run->fetchAll();

?>
