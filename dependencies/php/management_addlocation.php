<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

echo "Warehouse name: " . $sanitized['input_name'] . "<br>";
echo "Warehouse adress: " . $sanitized['input_adress'] . "<br>";
echo "Warehouse zipcode: " . $sanitized['input_zipcode'] . "<br>";
echo "Warehouse description: " . $sanitized['input_description'] . "<br>";


$zipcode_raw = str_replace(' ', '', $sanitized['input_zipcode']);
$zipcode = str_split($zipcode_raw, 4);

$zipcode_numbers = $zipcode[0];
$zipcode_letters = strtoupper($zipcode[1]);

// Add location to database
$sql = "INSERT INTO locations (locationname, locationadress, locationdescription, zipcode_numbers, zipcode_letters) VALUES (?, ?, ?, ?, ?)";
$run = $connection->prepare($sql);
$run->execute([$sanitized['input_name'], $sanitized['input_adress'], $sanitized['input_description'], $zipcode_numbers, $zipcode_letters]);
$result = $run->fetchAll();
//
header('Location: ../../locations.php');
?>