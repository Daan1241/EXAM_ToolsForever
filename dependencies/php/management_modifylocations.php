<?php
include "pdo.php";
$modify_data = json_decode($_POST['modify_data']);
echo "Received data: \n";
print_r($modify_data);

// "ABCD12" = $modify_data[2]

$zipcode_raw = str_replace(' ', '', $modify_data[2]);
$zipcode = str_split($zipcode_raw, 4);

$zipcode_numbers = $zipcode[0];
$zipcode_letters = strtoupper($zipcode[1]);

$sql = "UPDATE locations SET locationname=?, locationdescription=?, locationadress=?, zipcode_numbers=?, zipcode_letters=? WHERE locationID=?;";
$run = $connection->prepare($sql);
$run->execute([$modify_data[1], $modify_data[4], $modify_data[3], $zipcode_numbers, $zipcode_letters, $modify_data[0]]);
$result = $run->fetchAll();

?>