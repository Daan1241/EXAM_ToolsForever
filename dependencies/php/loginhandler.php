<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";
$salt = sha1(rand(1, 1000000000));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($sanitized['password'] != "" || $sanitized['password'] != null) {
// 1. Check if username exists in database
    $sql = "SELECT * FROM users WHERE username=?";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized['username']]);
    $result = $run->fetchAll();

// 2. If result is NULL, this user is not found.
    if (!$result == null) {
        if ($result[0]['activationkey'] == null) {
            if ($result[0]['password'] == sha1($sanitized['password'] . $result[0]['salt'])) {
                //echo "inloggen gelukt! Gebruiker ".$result[0]['username']." met wachtwoord ".$result[0]['password'];
                $_SESSION['sessionID'] = sha1($result[0]['password'] . $salt);
                $_SESSION['username'] = $result[0]['username'];

                $sql = "UPDATE users SET sessionID=? WHERE username=?";
                $run = $connection->prepare($sql);
                $run->execute([sha1($result[0]['password'] . $salt), $sanitized['username']]);
                header("Location: ../../index.php");
            } else {
                header("Location: ../../login.php?alert=login_fail");
            }
        } else {
            header("Location: ../../login.php?alert=not_activated");
        }
    } else {
        header("Location: ../../login.php?alert=login_fail");
    }
} else { // username OR password was empty, do not compare to database (because that will result in the user logging in on a ghost account).
    header("Location: ../../login.php?alert=no_info");
}
?>