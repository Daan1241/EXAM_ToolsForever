<?php
include "pdo.php";
//print_r($_POST);

// Get From location
// Get products_productID at From location
// add to locations_has_products
print("<pre>".print_r($_POST, true)."</pre>");

$fromlocation = $_POST['select_location'];
$tolocation = $_POST['to_location'];
$productID = $_POST['add_from_id'];
$stock = $_POST['from_stock'];
$min_stock = $_POST['from_min_stock'];
echo "Adding the following existing product to ".$fromlocation;

$sql = "SELECT locationID FROM locations WHERE locationname=?";
$run = $connection->prepare($sql);
$run->execute([$tolocation]);
$result_get_locationID = $run->fetchAll();

echo $result_get_locationID[0][0];


$sql = "SELECT * FROM locations_has_products JOIN products ON productID=products_productID WHERE ID=?";
$run = $connection->prepare($sql);
$run->execute([$productID]);
$result_all_products = $run->fetchAll();
print("<pre>".print_r($result_all_products, true)."</pre>");

//echo $result_all_products[0]['products_productID'];

$sql = "INSERT INTO locations_has_products (locations_locationID, products_productID, stock, min_stock) VALUES (".$result_get_locationID[0][0].", ".$result_all_products[0]['products_productID'].", ".$stock.", ".$min_stock.")";
$run = $connection->prepare($sql);
$run->execute([$result_all_products[0]['locations_locationID'], $result_all_products[0]['products_productID'], $stock, $min_stock]);
$result_all = $run->fetchAll();

echo "INSERT INTO locations_has_products (locations_locationID, products_productID, stock, min_stock) VALUES (".$result_get_locationID[0][0].", ".$result_all_products[0]['products_productID'].", ".$stock.", ".$min_stock.")";
echo "product copied to new location";
header("Location: ../../management.php")

?>
