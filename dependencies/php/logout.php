<?php
error_reporting(0);
require "pdo.php";

$sanitized['username'] = null;
$sanitized = $_SESSION;
if ($sanitized['username'] == null) {
    echo "je bent al uitgelogd.";
} else {



    $sql = "UPDATE users SET sessionID=null WHERE username=?";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized['username']]);

    session_destroy();
}
header('Location: ../../login.php?logout=success');
?>