<?php
$sanitized = filter_input_array(INPUT_GET, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

$sql = "SELECT activationkey FROM users WHERE activationkey=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['token']]);
$result = $run->fetchAll();


if ($sanitized['token'] == $result[0]['activationkey']) {
    $sql = "UPDATE users SET activationkey = '' WHERE activationkey=?;";
    $run = $connection->prepare($sql);
    $run->execute([$result[0]['activationkey']]);
    $result = $run->fetchAll();
    header("Location: ../../login.php?alert=account_activated");

} else {
    header("Location: ../../login.php");
}