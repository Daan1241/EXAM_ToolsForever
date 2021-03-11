<?php
require "pdo.php";
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
echo "deleting location with locationID: " . $sanitized['delete_id'] . "\n";


$sql = "SELECT DISTINCT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE locationID = ?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['delete_id']]);
$result_products_at_location = $run->fetchAll();

foreach ($result_products_at_location as $product) {
    echo "Deleting products products with locations_has_products ID: ". $product['ID']."\n";

    $sql = "DELETE FROM locations_has_products WHERE ID = ?";
    $run = $connection->prepare($sql);
    $run->execute([$product['ID']]);
    $result_products_at_location = $run->fetchAll();

}


$sql = "DELETE FROM locations WHERE locationID = ?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['delete_id']]);
$result_products_at_location = $run->fetchAll();



?>