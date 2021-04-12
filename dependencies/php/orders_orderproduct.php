<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
include "pdo.php";
//echo $sanitized['product_name'];
//echo $sanitized['from_location'];
//echo $sanitized['amount'];

// 1. locationID from from_location
// 2. productID from product_name

$sql = "select DISTINCT locationID from locations_has_products JOIN locations on locations_locationID=locationID WHERE locationname=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['from_location']]);
$result_locationID = $run->fetchAll();

echo $result_locationID[0][0];




$sql = "select DISTINCT products_productID from locations_has_products JOIN products ON products_productID=productID WHERE productname=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['product_name']]);
$result_productID = $run->fetchAll();

echo $result_productID[0][0];


$sql = "UPDATE locations_has_products SET stock=stock-? WHERE products_productID=? AND locations_locationID=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['amount'], $result_productID[0][0], $result_locationID[0][0]]);
$result_productID = $run->fetchAll();


header('location: ../../orders.php?message=order_complete');
?>
