<?php
// Needs to be set before checkLoggedIn.php gets required.
$loggedIn = false;

require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";

// Sanitizes received GET variables.
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
            <div class="topbar_container">MANAGEMENT</div>
        </a>
        <a href="locations.php">
            <div class="topbar_container">LOCATIONS</div>
        </a>
        <a href="orders.php">
            <div class="topbar_container"><b>ORDERS</b></div>
        </a>
        <?php
        // Checks if logged in user is an administrator and if so, adds a link to the admin page to the navigation bar
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
        <div class="management_details_container">
            <b style="font-size: 200%;">Place an order: </b><br>
            <form action="dependencies/php/orders_orderproduct.php" method="POST">
                <table>
                    <tr>
                        <td><b>Product</b></td>
                        <td><b>from location:</b></td>
                        <td><b>Amount:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><select id='management_select_city_from' name="product_name" onchange="getlocations_ID_list(this);" required>
                                <option disabled selected>product</option>
                                <?php
                                $sql = "SELECT DISTINCT productname FROM locations_has_products JOIN products ON products_productID=productID";
                                $run = $connection->prepare($sql);
                                $run->execute();
                                $result_all_productlocations = $run->fetchAll();


                                foreach ($result_all_productlocations as $item) {

                                    echo "<option id=\"" . $item['productname'] . "\">" . $item['productname'] . "</option>";

                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select id="products_select_list_from" onchange="getProductID(this.value)" name="from_location" required>
                                <option disabled selected>location</option>
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
                        <td>
                            <input type="number" name="amount">
                        </td>
                        <td>
                            <input type="submit" class="button_default" value="Place order">
                        </td>
                    </tr>
                </table>
            </form>
            <span id="message" class="message"></span>
        </div>
        <br>
        <br>
        <br>
        <br>
    </div>
</div>
</body>
<script src="dependencies/js/page_login.js"></script>
<script src="dependencies/js/page_orders.js"></script>
</html>