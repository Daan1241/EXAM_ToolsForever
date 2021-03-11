<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

echo "Warehouse location: " . $sanitized['location'] . "<br>";
echo "Product: " . $sanitized['input_name'] . "<br>";
echo "Brand: " . $sanitized['input_brand'] . "<br>";
echo "Type: " . $sanitized['input_type'] . "<br>";
echo "Buy price: " . $sanitized['input_buyprice'] . "<br>";
echo "Sell price:" . $sanitized['input_sellprice'] . "<br>";
echo "Stock: " . $sanitized['input_stock'] . "<br>";
echo "Min. stock: " . $sanitized['input_minstock'] . "<br>";

// Steps:
// - Check if product with name, brand, type, buyprice and sellprice already exists
// no? -> create create 1 product and add to locations_has_products (with NEW ID)
// yes? -> just add to locations_has_products as well

// Count amount of existing product (To use as replacement of auto_increment).
$sql = "SELECT COUNT(*) FROM products";
$run = $connection->prepare($sql);
$run->execute();
$rowcount_result = $run->fetchAll();
$productcount = $rowcount_result[0][0];
// --


// Checks if there already are products with the EXACT same inputted information
$sql = "SELECT COUNT(*) FROM products WHERE productname=? AND productbrand=? AND producttype=? AND buyprice=? AND sellprice=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['input_name'], $sanitized['input_brand'], $sanitized['input_type'], $sanitized['input_buyprice'], $sanitized['input_sellprice']]);
$rowcount_productcopies = $run->fetchAll();
$duplicates = $rowcount_productcopies[0][0];
ECHO "duplicates = ".$duplicates;


echo $sanitized['input_name']," ", $sanitized['input_brand'], " ",$sanitized['input_type'], " ",$sanitized['input_buyprice'], " ",$sanitized['input_sellprice'];
if ($duplicates == 0) { // If 0 duplicate products, create new products
    $sql = "INSERT INTO products (productname, productbrand, producttype, buyprice, sellprice) VALUES (?, ?, ?, ?, ?)";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized['input_name'], $sanitized['input_brand'], $sanitized['input_type'], $sanitized['input_buyprice'], $sanitized['input_sellprice']]);
    $result = $run->fetchAll();
    print_r($result);
    echo "NEW product added";
} else {
    echo "product with this configuration already found. Skipped adding:<br>";
    $productcount -= 3;
}

// Get productID from (just newly added OR already existing) product
$sql = "SELECT productID FROM products WHERE productname=? AND productbrand=? AND producttype=? AND buyprice=? AND sellprice=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['input_name'], $sanitized['input_brand'], $sanitized['input_type'], $sanitized['input_buyprice'], $sanitized['input_sellprice']]);
$productID_result = $run->fetchAll();
print_r($productID_result[0]['productID']);
$productID = $productID_result[0]['productID'];

echo "<br><br>";


// Get locationID from inputted locationname
$sql = "SELECT locationID FROM locations WHERE locationname=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['location']]);
$result = $run->fetchAll();
print_r($result[0]['locationID']);

$locationID = $result[0]['locationID'];


// The following 2 vars now include the productID and the designated locationID that need to be added to the locations_has_products table
// $productID
// $locationID

echo $locationID, $productID, $sanitized['input_stock'], $sanitized['input_minstock'];
//// Then, add to the connector table with the correct information.
$sql = "INSERT INTO locations_has_products (locations_locationID, products_productID, stock, min_stock) VALUES (?, ?, ?, ?);";
$run = $connection->prepare($sql);
$run->execute([$locationID, $productID, $sanitized['input_stock'], $sanitized['input_minstock']]);
$result = $run->fetchAll();
//print_r($result);

header('Location: ../../management.php');


// PROBLEM!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Connector table only looks at the name of a product, so when 2 products with the same name have a different type, this will cause errors. Product ID is needed for linking with connector table.
?>