<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";
$salt = sha1(rand(1, 1000000000));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$sql = "SELECT * FROM users WHERE username=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['username']]);
$result = $run->fetchAll();

if ($result == null) {
    header("Location: ../../login.php?login=fail");
} else {
    if($result[0]['password'] == $sanitized['password']){
        echo "inloggen gelukt! Gebruiker ".$result[0]['username']." met wachtwoord ".$result[0]['password'];
        $_SESSION['sessionID'] = sha1($result[0]['password'].$salt);
        $_SESSION['username'] = $result[0]['username'];

        $sql = "UPDATE users SET sessionID=? WHERE username=?";
        $run = $connection->prepare($sql);
        $run->execute([sha1($result[0]['password'].$salt), $sanitized['username']]);
        header("Location: ../../index.php");
    } else {
        header("Location: ../../login.php?login=fail");
    }
}
?>