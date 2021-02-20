<?php


function checkLogin($username_raw, $sessionID_raw)
{
    include "pdo.php";
    $sanitized_username = filter_var($username_raw, FILTER_SANITIZE_MAGIC_QUOTES);
    $sanitized_sessionID = filter_var($sessionID_raw, FILTER_SANITIZE_MAGIC_QUOTES);


    $sql = "SELECT DISTINCT * FROM users WHERE username=? AND sessionID=?";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized_username, $sanitized_sessionID]);
    $database_result = $run->fetchAll();

    if (!$database_result == null || $database_result == "") {
        if ($sanitized_username == $database_result[0]['username'] && $sanitized_sessionID == $database_result[0]['sessionID']) {
//            echo "succesvol ingelogd als " . $database_result[0]['username'];
            return "true";
        } else {
            return "false";
        }
    } else {
        return "false";
    }


}

?>