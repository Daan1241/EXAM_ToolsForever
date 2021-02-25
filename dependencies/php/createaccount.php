<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

$sql = "SELECT * FROM users WHERE username=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['username']]);
$result = $run->fetchAll();

if ($result == null) { // Username does not exist yet, add to database.
    $salt = rand(1, 2122122);
    $password_encrypted = sha1($sanitized['password'].$salt);
    $sql = "INSERT INTO users (email, username, password, privileges, salt) VALUES (?, ?, ?, 'admin', ?)";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized['email'], $sanitized['username'], $password_encrypted, $salt]);
    $result = $run->fetchAll();
    echo "Creating account...";
    header("Location: ../../index.php");
} else {
    header("Location: ../../login.php?login=ERR_ALREADY_EXISTS");
}


?>