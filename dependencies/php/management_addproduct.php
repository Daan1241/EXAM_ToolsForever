<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

echo "Warehouse location: ".$sanitized['location']."<br>";
echo "Product: ".$sanitized['input_name']."<br>";
echo "Brand: ".$sanitized['input_brand']."<br>";
echo "Type: ".$sanitized['input_type']."<br>";
echo "Buy price: ".$sanitized['input_buyprice']."<br>";
echo "Sell price:" .$sanitized['input_sellprice']."<br>";
echo "Stock: ".$sanitized['input_stock']."<br>";
echo "Min. stock: ".$sanitized['input_minstock']."<br>";


// First, create product
$sql = "INSERT INTO products (productName, productbrand, producttype, buyprice, sellprice) VALUES (?, ?, ?, ?, ?)";
$run = $connection->prepare($sql);
$run->execute([$sanitized['input_name'], $sanitized['input_brand'], $sanitized['input_type'], $sanitized['input_buyprice'], $sanitized['input_sellprice']]);
$result = $run->fetchAll();

// Then, add to the conector table with the correct information.

// INSERT INTO locations_has_products (locations_locationID, locations_locationname, stock, min_stock, products_productID, products_productname) VALUES (0, , 45, 10, 1, "Accuboorhamer");
$sql = "INSERT INTO locations_has_products (locations_locationname, products_productname, stock, min_stock) VALUES (?, ?, ?, ?);";
$run = $connection->prepare($sql);
$run->execute([$sanitized['location'], $sanitized['input_name'], $sanitized['input_stock'], $sanitized['input_minstock']]);
$result = $run->fetchAll();

// INSERT INTO table_name (column1, column2, column3, ...)
// VALUES (value1, value2, value3, ...);
?>