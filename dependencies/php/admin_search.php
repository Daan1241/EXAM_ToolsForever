<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
include "pdo.php";

$search_username = $sanitized['admin_search_user_name'];
$search_type = $sanitized['admin_search_user_privilege'];
echo "Searching " . $search_username . " as " . $search_type;



$sql = "SELECT * FROM users WHERE username=? AND sessionID=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['admin_search_user_name'], $sanitized['admin_search_user_privilege']]);
$result = $run->fetchAll();
?>