<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
include "pdo.php";
//echo $sanitized['getlocation'];


$sql = "select DISTINCT locationname from locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE productname=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['getproduct']]);
$result_products_at_location = $run->fetchAll();

//print_r($result_products_at_location);
$returned_products = [];
foreach ($result_products_at_location as $product) {
    if (in_array($product[0], $returned_products)) {
        // Do nothing
    } else {
        array_push($returned_products, $product[0]);
    }
}

echo json_encode($returned_products);
?>