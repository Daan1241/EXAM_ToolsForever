<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

echo "Warehouse location: ".$sanitized['input_name']."<br>";
echo "Warehouse location: ".$sanitized['input_adress']."<br>";
echo "Warehouse location: ".$sanitized['input_zipcode']."<br>";
echo "Warehouse location: ".$sanitized['input_description']."<br>";


// First, create product
$sql = "INSERT INTO locations (locationname, locationadress, locationdescription) VALUES (?, ?, ?)";
$run = $connection->prepare($sql);
$run->execute([$sanitized['input_name'], $sanitized['input_adress'], $sanitized['input_description']]);
$result = $run->fetchAll();

header('Location: ../../management.php?action=success');
?>