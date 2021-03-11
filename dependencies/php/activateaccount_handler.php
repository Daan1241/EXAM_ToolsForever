<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
include "pdo.php";
$token = $_POST['token'];
$user = $_POST['user'];
$newpassword = $_POST['password'];
echo $token . $user . $newpassword;


$sql = "SELECT * FROM users WHERE username=? AND activationkey=?";
$run = $connection->prepare($sql);
$run->execute([$user, $token]);
$dbdata = $run->fetchAll();
print_r($dbdata);

if ($dbdata[0]['activationkey'] != null || $dbdata[0]['activationkey'] != "") {
    echo "<br><br><br>";
    $encryptedpassword = sha1($newpassword . $dbdata[0]['salt']);
    echo $encryptedpassword;

    if ($dbdata[0]['email'] != NULL) {
        $sql = "UPDATE users SET activationkey='', password=? WHERE activationkey=?";
        $run = $connection->prepare($sql);
        $run->execute([$encryptedpassword, $_POST['token']]);
        $dbdata = $run->fetchAll();
    }
}
header("location: ../../login.php");
?>
