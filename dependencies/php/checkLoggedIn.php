<?php
session_start();
if (!isset($_SESSION)) { // Session not yet started.
    // New session started
    echo 'New session started.'; // Still empty, asking for username or sessionID will result in an error.
} else {
    if ($_SESSION != null) { // Session has variables in it.
        if (checkLogin($_SESSION['username'], $_SESSION['sessionID']) == true) { 
            $loggedIn = true;
            $sanitized = $_SESSION;
        }
    } else {
        $loggedIn = false;
    }
}


function checkLogin($username_raw, $sessionID_raw)
{
    require "pdo.php";
    $sanitized_username = filter_var($username_raw, FILTER_SANITIZE_MAGIC_QUOTES); // could return false
    $sanitized_sessionID = filter_var($sessionID_raw, FILTER_SANITIZE_MAGIC_QUOTES); // could return false


    $sql = "SELECT DISTINCT * FROM users WHERE username=? AND sessionID=?";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized_username, $sanitized_sessionID]);
    $database_result = $run->fetchAll();

    if ($database_result != null || $database_result == "") {
        if ($sanitized_username == $database_result[0]['username'] && $sanitized_sessionID == $database_result[0]['sessionID']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
