<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
include "pdo.php";
//echo $sanitized['getlocation'];


$sql = "SELECT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE locationname=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['getlocation']]);
$result_products_at_location = $run->fetchAll();

//print_r($result_products_at_location);
$returned_products_ID = [];
$returned_products_name = [];
foreach($result_products_at_location as $product){;
    array_push($returned_products_ID, $product['ID']);
    array_push($returned_products_name, $product['productname']);
}

$combined = [];

foreach($returned_products_name as $index => $name){
$combined[$name] = $returned_products_ID[$index];
}


echo json_encode($combined);
?>
