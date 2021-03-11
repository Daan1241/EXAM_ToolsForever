<?php
$loggedIn = false; // Needs to be before checkLoggedIn.php requires.
require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";
$sanitized_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_MAGIC_QUOTES);


if ($loggedIn == true) {
    // User is logged in.
} else {
    header("Location: login.php?alert=no_access");
}


?>

<html>
<head>
    <title>ToolsForEver - Home</title>
    <script src="dependencies/js/main.js"></script>
    <link rel="stylesheet" href="dependencies/css/variables.css">
    <link rel="stylesheet" href="dependencies/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap"
          rel="stylesheet">
    <script src="dependencies/js/page_management.js"></script>
    <script src="dependencies/js/ajax.js"></script>
</head>
<body>
<div id="topbar">
    <div id="topbar_mobile" onClick="mobile_opentopbar();">
        <img src="dependencies/img/hamburger.svg"
             style="display: inline-block; vertical-align: middle; filter: invert(100%); transition: 1s;">
    </div>

    <div id="topbar_others">
        <a href="index.php">
            <div class="topbar_container">HOME</div>
        </a>
        <a href="management.php">
            <div class="topbar_container"><b>MANAGEMENT</b></div>
        </a>
        <a href="locations.php">
            <div class="topbar_container">LOCATIONS</div>
        </a>
        <?php
        if (isset($sanitized)) {
            $sql = "SELECT privileges FROM users WHERE username=? AND sessionID=?";
            $run = $connection->prepare($sql);
            $run->execute([$sanitized['username'], $sanitized['sessionID']]);
            $dbdata_privileges = $run->fetchAll();

            if (strtolower($dbdata_privileges[0][0]) == 'admin') {
                echo "<a href=\"admin.php\">
            <div class=\"topbar_container\">ADMIN</div>
            </a>";
            }
        }

        if ($loggedIn == true) {
            echo "<a href=\"dependencies/php/logout.php\">
              <div class=\"topbar_container\">LOGOUT</div>
              </a>";
        } else {
            echo "<a href=\"login.php\">
              <div class=\"topbar_container\">LOGIN</div>
              </a>";
        }
        ?>
    </div>
</div>

<div id="wrapper">
    <br>
    <div id="management_container">


        <div class="management_details_container"><span id="addproducts"></span>
            <form action="dependencies/php/management_addproduct.php" method="post">
                <b style="font-size: 200%;">Add a product</b><br><br>
                Location:
                <select name="location">
                    <?php
                    $sql = "SELECT DISTINCT * FROM locations";
                    $run = $connection->prepare($sql);
                    $run->execute();
                    $result_getlocations = $run->fetchAll();
                    print_r($result_getlocations);

                    foreach ($result_getlocations as $getlocationinfo) {
                        echo "<option>" . $getlocationinfo['locationname'] . "</option>";
                    }
                    ?>
                </select>
                <br><br>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Type</th>
                        <th>Buy Price</th>
                        <th>Sell Price</th>
                        <th>Stock</th>
                        <th>Min. Stock</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="input_name" id="input_name" placeholder="Product name"
                                   class="add_location_input"></td>
                        <td><input type="text" name="input_brand" id="input_brand" placeholder="Brand"
                                   class="add_location_input"></td>
                        <td><input type="text" name="input_type" id="input_type" placeholder="Type"
                                   class="add_location_input"></td>
                        <td><input type="number" step="0.01" placeholder="Buy Price: 0,00" name="input_buyprice"
                                   id="input_buyprice"
                                   class="add_location_input"></td>
                        <td><input type="number" step="0.01" placeholder="Sell Price: 0,00" name="input_sellprice"
                                   id="input_sellprice" placeholder="Sell price" class="add_location_input"></td>
                        <td><input type="number" name="input_stock" id="input_stock" placeholder="Stock"
                                   class="add_location_input"></td>
                        <td><input type="number" name="input_minstock" id="input_minstock" placeholder="Min. Stock"
                                   class="add_location_input"></td>
                        <td><input type="submit" value="Add" class="add_location_input"></td>
                    </tr>
                </table>
            </form>
            <br><br>

            Add an existing product?
            <form action="dependencies/php/management_addproductfrom.php" method="POST">
                <table>
                    <tr>
                        <td><b>From location: </b></td>
                        <td><b>add product:</b></td>
                        <td><b>to location:</b></td>
                        <td><b>with stock:</b></td>
                        <td><b>minimum stock:</b></td>
                    </tr>
                    <tr>
                        <td><select id='management_select_city_from' name="select_location" onclick="getproducts_ID_list(this);" required>
                                <option disabled selected>From Location</option>
                                <?php
                                $sql = "SELECT DISTINCT locationname FROM locations_has_products JOIN locations ON locations_locationID=locationID";
                                $run = $connection->prepare($sql);
                                $run->execute();
                                $result_all_productlocations = $run->fetchAll();


                                foreach ($result_all_productlocations as $item) {

                                    echo "<option id=\"" . $item['locationname'] . "\">" . $item['locationname'] . "</option>";

                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select id="products_select_list_from" onchange="getProductID(this.value)" name="select_product" required>
                                <option disabled selected>add Product</option>
                                <?php

                                $sql = "SELECT DISTINCT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE locationname=?";
                                $run = $connection->prepare($sql);
                                $run->execute([$sanitized_GET['location']]);
                                $result_products_at_location = $run->fetchAll();
                                foreach ($result_products_at_location as $product) {
                                    echo "<option id=\"" . $product['products_productID'] . "\">" . $product['productname'] . "</option>";
                                }

                                ?>
                            </select>
                        </td>
                        <td><select id='management_select_city' name="to_location" required>
                                <option disabled selected>to Location</option>
                                <?php
                                $sql = "SELECT DISTINCT locationname FROM locations_has_products JOIN locations ON locations_locationID=locationID";
                                $run = $connection->prepare($sql);
                                $run->execute();
                                $result_all_productlocations = $run->fetchAll();


                                foreach ($result_all_productlocations as $item) {

                                    echo "<option id=\"" . $item['locationname'] . "\">" . $item['locationname'] . "</option>";

                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" id="from_stock" name="from_stock" required>
                        </td>
                        <td>
                            <input type="number" id="from_min_stock" name="from_min_stock" required>
                        </td>
                        <td>
                            <input type="submit" class="button_default" value="Search">
                        </td>
                    </tr>
                </table>
                <input type="text" id="add_from_id" name="add_from_id" value="" style="display: none;">
            </form>
        </div>

        <div class="management_details_container"><span id="products"></span>
            <b style="font-size: 200%;">Products at locations: </b><br>
            Click a value to edit it<br><br>
            <div class="management_existing_products" id="products_container">
                <?php
                $sql = "SELECT DISTINCT * FROM locations";
                $run = $connection->prepare($sql);
                $run->execute();
                $result_locations = $run->fetchAll();

                foreach ($result_locations as $locationinfo) {

                    $sql = "SELECT DISTINCT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE locationname = ?";
                    $run = $connection->prepare($sql);
                    $run->execute([$locationinfo['locationname']]);
                    $result_stock = $run->fetchAll();
//                    print("<pre>".print_r($result_stock,true)."</pre>");

                    if (isset($result_stock[0])) {
                        echo "<table>";
                        echo "<tr>";
                        echo "<th style='width: 8%'>" . $locationinfo['locationname'] . "</th>";
                        echo "<th style='width: 8%; display: none'>ID</th>";
                        echo "<th style='width: 8%'>Name</th>";
                        echo "<th style='width: 8%'>Brand</th>";
                        echo "<th style='width: 8%'>Type</th>";
                        echo "<th style='width: 8%'>Buy Price</th>";
                        echo "<th style='width: 8%'>Sell Price</th>";
                        echo "<th style='width: 8%'>Stock</th>";
                        echo "<th style='width: 8%'>Min. stock</th>";
                        echo "<th style='width: 8%'>Stock worth</th>";
                        echo "</tr>";

                        foreach ($result_stock as $index => $product) {
                            echo "<tr>";
                            echo "<td><input type=\"checkbox\" class='checkbox_product' id='" . $locationinfo['locationname'] . "_" . $product['ID'] . "'></td>";
                            echo "<td style='display: none'>" . $product['ID'] . "</td>";
                            echo "<td onclick='modify(this)'>" . $product['productname'] . "</td>";
                            echo "<td onclick='modify(this)'>" . $product['productbrand'] . "</td>";
                            echo "<td onclick='modify(this)'>" . $product['producttype'] . "</td>";
                            echo "<td onclick='modify(this)'>€" . $product['buyprice'] . "</td>";
                            echo "<td onclick='modify(this)'>€" . $product['sellprice'] . "</td>";
                            echo "<td onclick='modify(this)'>" . $product['stock'] . "</td>";
                            echo "<td onclick='modify(this)'>" . $product['min_stock'] . "</td>";
                            echo "<td>€" . $product['stock'] * $product['sellprice'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</td></table><br><br>";
                    }

                }
                ?>
                </table>
            </div>
            Actions:<br>
            <input type="button" value="Delete selected" onclick="deleteall();">

        </div>

        <!-- search product -->
        <div class="management_details_container"><span id="searchproducts"></span>
            <b style="font-size: 200%;">Search products: </b><br><br>
            <form action="" method="GET">
                <table>
                    <tr>
                        <td><b>Location:</b></td>
                        <td><b>Product:</b></td>
                    </tr>
                    <tr>
                        <td><select id='management_select_city' name="location" onclick="getproducts_list(this);">
                                <option disabled selected>Select Location</option>
                                <?php
                                $sql = "SELECT DISTINCT locationname FROM locations_has_products JOIN locations ON locations_locationID=locationID";
                                $run = $connection->prepare($sql);
                                $run->execute();
                                $result_all_productlocations = $run->fetchAll();


                                foreach ($result_all_productlocations as $item) {

                                    echo "<option id=\"" . $item['locationname'] . "\">" . $item['locationname'] . "</option>";

                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select id="products_select_list" name="productsearch">
                                <option disabled selected>Select Product</option>
                                <?php

                                $sql = "SELECT DISTINCT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE locationname=?";
                                $run = $connection->prepare($sql);
                                $run->execute([$sanitized_GET['location']]);
                                $result_products_at_location = $run->fetchAll();
                                foreach ($result_products_at_location as $product) {
                                    echo "<option id=\"" . $product['productname'] . "\">" . $product['productname'] . "</option>";
                                }

                                ?>
                            </select>
                        </td>

                        <td>
                            <input type="submit" class="button_default" value="Search">
                        </td>
                    </tr>
                </table>

            </form>

            <div class="management_existing_products" id="products_container">
                <?php
                if ($loggedIn == true) {
                    if ($sanitized_GET['productsearch'] != null) {

                        // First get all locations with actual products in them
                        $sql = "SELECT DISTINCT locationname FROM locations_has_products JOIN locations ON locations_locationID=locationID JOIN products ON products_productID=productID WHERE productname=? AND locationname=?;";
                        $run = $connection->prepare($sql);
                        $run->execute([$sanitized_GET['productsearch'], $sanitized_GET['location']]);
                        $result_search_locations = $run->fetchAll();

                        foreach ($result_search_locations as $locationinfo) {
                            $sql = "SELECT * FROM locations_has_products JOIN products ON products_productID=productID JOIN locations ON locations_locationID=locationID WHERE productname=? AND locationname=?";
                            $run = $connection->prepare($sql);
                            $run->execute([$sanitized_GET['productsearch'], $sanitized_GET['location']]);
                            $result_productsearch = $run->fetchAll();


                            if (isset($result_productsearch[0])) {
                                echo "<table>";
                                echo "<tr>";
                                echo "<th style='width: 8%'>Name</th>";
                                echo "<th style='width: 8%'>Brand</th>";
                                echo "<th style='width: 8%'>Type</th>";
                                echo "<th style='width: 8%'>Buy Price</th>";
                                echo "<th style='width: 8%'>Sell Price</th>";
                                echo "<th style='width: 8%'>Stock</th>";
                                echo "<th style='width: 8%'>Min stock</th>";
                                echo "<th style='width: 8%'>Stock worth</th>";
                                echo "</tr>";

                                foreach ($result_productsearch as $index => $product) {
                                    echo "<tr>";
                                    echo "<td>" . $product['productname'] . "</td>";
                                    echo "<td>" . $product['productbrand'] . "</td>";
                                    echo "<td>" . $product['producttype'] . "</td>";
                                    echo "<td>€" . $product['buyprice'] . "</td>";
                                    echo "<td>€" . $product['sellprice'] . "</td>";
                                    echo "<td>" . $product['stock'] . "</td>";
                                    echo "<td>" . $product['min_stock'] . "</td>";
                                    echo "<td>€" . $product['stock'] * $product['sellprice'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</td></table><br><br>";

                            }

                        }
                    }
                }
                ?>
            </div>
        </div>
        <!-- end of search product -->

        <br>
        <br>
        <br>
        <br>
    </div>


</div>
</body>
</html>