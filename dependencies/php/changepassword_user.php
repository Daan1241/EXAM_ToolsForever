<?php
require "pdo.php";
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);

//$sanitized['password'];
//$sanitized['user'];
//$sanitized['token'];

//echo "username: ".$sanitized['username'];

$sql = "SELECT * FROM users WHERE username=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['username']]);
$result = $run->fetchAll();
//print_r($result);

//echo "username: ".$result['username'];

$receivedtoken = $sanitized['token']; // received POST token
$comparetoken = sha1($result[0]['username']."1241");
echo "<br>token: ".$receivedtoken."<br>database:".$comparetoken;


if($receivedtoken == $comparetoken){
    echo "<br>changing password...";
    $sql = "UPDATE users SET password=? WHERE username=?";
    $run = $connection->prepare($sql);
    $run->execute([sha1($sanitized['password'].$result[0]['salt']), $sanitized['username']]);
    $result = $run->fetchAll();
}

header('Location: ../../login.php?password_changed');

?>