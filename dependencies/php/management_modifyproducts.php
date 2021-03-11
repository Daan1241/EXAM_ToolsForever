<?php
// Include PDO connection
include "pdo.php";

// Put received data in a variable as array
$modify_data = json_decode($_POST['modify_data']);

// Get product ID using locations_has_products' row ID
$sql = "SELECT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE ID=?";
$run = $connection->prepare($sql);
$run->execute([$modify_data[0]]);
$result_productsearch = $run->fetchAll();

// Remove euro sign from original price.
$buyprice = str_replace('€', '', $modify_data[4]);
$sellprice = str_replace('€', '', $modify_data[5]);

// DEBUG: print received data
echo "\nReceived data:";
print_r($modify_data);
echo "\nproduct ID: " . $result_productsearch[0]['productID'];
echo "\nlocation ID: " . $result_productsearch[0]['locations_locationID'];
echo "\nBuyprice: ".$buyprice;
echo "\nSellprice: ".$sellprice;
// DEBUG --------------------




$sql = "UPDATE products SET productname=?, productbrand=?, producttype=?, buyprice=?, sellprice=? WHERE productID = ?";
$run = $connection->prepare($sql);
$run->execute([$modify_data[1], $modify_data[2], $modify_data[3], $buyprice, $sellprice, $result_productsearch[0]['productID']]);
$result = $run->fetchAll();


$sql = "UPDATE locations_has_products SET stock=?, min_stock=? WHERE products_productID = ? AND locations_locationID = ?";
$run = $connection->prepare($sql);
$run->execute([$modify_data[6], $modify_data[7], $result_productsearch[0]['productID'], $result_productsearch[0]['locations_locationID']]);
$result = $run->fetchAll();

echo "product ID: " . $result_productsearch[0]['productID'] . " modified.";

?>