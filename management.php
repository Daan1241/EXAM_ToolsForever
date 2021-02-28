<?php
require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";

$loggedIn = false;

if (!isset($_SESSION)) { // Session not yet started.
    session_start();
    echo 'New session started.'; // Still empty, asking for username or sessionID will result in an error.
} else {
    if (!$_SESSION == null) { // Session has variables in it.
        if (checkLogin($_SESSION['username'], $_SESSION['sessionID']) == "true") {
            $loggedIn = true;
            $sanitized = $_SESSION;

            $action = filter_input_array(INPUT_GET, FILTER_SANITIZE_MAGIC_QUOTES);
        }
    } else {
        $loggedIn = false;
    }
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
    <script src="dependencies/js/page_login.js"></script>
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
        <table>
            <tr>
                <td><b>Locatie:</b></td>
                <td><b>Product:</b></td>
            </tr>
            <tr>
                <td><select id='management_select_city'>
                        <option id="almere">Almere</option>
                        <option id="eindhoven">eindhoven</option>
                        <option id="rotterdam">Rotterdam</option>
                    </select>
                </td>
                <td>
                    <input type="text" placeholder="zoek op product">
                </td>
                <td>
                    <input type="button" class="button_default" value="zoek">
                </td>
            </tr>
        </table>

        <div class="management_details_container">
            <form action="dependencies/php/management_addproduct.php" method="post">
                <b style="font-size: 200%;">Add a product</b><br><br>
                Location:
                <select name="location">
                    <?php
                        $sql = "SELECT * FROM locations";
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

                <input type="text" name="input_name" id="input_name" placeholder="Product name" class="add_product_input">
                <input type="text" name="input_brand" id="input_brand" placeholder="Brand" class="add_product_input">
                <input type="text" name="input_type" id="input_type" placeholder="Type" class="add_product_input">
                <input type="number" step="0.01" placeholder="0,00" name="input_buyprice" id="input_buyprice" class="add_product_input">
                <input type="number" step="0.01" placeholder="0,00" name="input_sellprice" id="input_sellprice" placeholder="Sell price" class="add_product_input">
                <input type="number" name="input_stock" id="input_stock" placeholder="Stock" class="add_product_input">
                <input type="number" name="input_minstock" id="input_minstock" placeholder="Stock" class="add_product_input">
                <input type="file" name="input_file" id="input_file" placeholder="Stock" class="add_product_input">
                <input type="submit" value="Add" class="add_product_input">

            </form>
        </div>

        <div class="management_details_container">
            <form action="dependencies/php/management_addlocation.php" method="post">
                <b style="font-size: 200%;">Add a location</b><br><br>
                <table>
                    <tr>
                        <th>City</th>
                        <th>Adress</th>
                        <th>Zipcode</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><input type="text" maxlength="64" name="input_name" id="input_name" placeholder="City (e.g. Amsterdam)" class="add_location_input"></td>
                        <td><input type="text" maxlength="256" name="input_adress" id="input_name" placeholder="Adress (e.g. Buikslotermeerplein 264)" class="add_location_input"></td>
                        <td><input type="text" maxlength="6" name="input_zipcode" id="input_name" placeholder="1234AB" class="add_location_input"></td>
                        <td><input type="text" maxlength="128" name="input_description" id="input_name" placeholder="Location description" class="add_location_input"></td>
                        <td><input type="submit" value="Add" class="add_location_input"></td>
                    </tr>
                </table>
            </form>

            <div class="management_existing_products">
                <table>
                    <tr>
                        <th>Location</th>
                        <th>Adress</th>
                        <th>Zipcode</th>
                        <th>Description</th>
                    </tr>
                        <?php
                            $sql = "SELECT DISTINCT * FROM locations";
                            $run = $connection->prepare($sql);
                            $run->execute();
                            $result_locations = $run->fetchAll();

                            foreach($result_locations as $locationinfo){
                                echo "<tr>";
                                echo "<td>".$locationinfo['locationname']."</td>";
                                echo "<td>".$locationinfo['locationadress']."</td>";
                                echo "<td>".$locationinfo['zipcode_numbers'].$locationinfo['zipcode_letters']."</td>";
                                echo "<td>".$locationinfo['locationdescription']."</td>";
                                echo "</tr>";
                            }
                        ?>
                </table>
            </div>
        </div>
        <div class="management_details_container">
            <b style="font-size: 200%;">Products at locations: </b><br><br>
            <div class="management_existing_products">
                <?php
                $sql = "SELECT DISTINCT * FROM locations";
                $run = $connection->prepare($sql);
                $run->execute();
                $result_locations = $run->fetchAll();

                foreach ($result_locations as $locationinfo) {

                    $sql = "SELECT * FROM locations_has_products JOIN products ON products_productname=productname WHERE locations_locationname = ?";
                    $run = $connection->prepare($sql);
                    $run->execute([$locationinfo['locationname']]);
                    $result_stock = $run->fetchAll();

                    if (isset($result_stock[0])) {
                        echo "<table>";
                        echo "<tr>";
                        echo "<th style='width: 10%'>" . $locationinfo['locationname'] . "</th>";
                        echo "<th style='width: 1%;'>Image</th>";
                        echo "<th style='width: 10%'>Name</th>";
                        echo "<th style='width: 10%'>Brand</th>";
                        echo "<th style='width: 10%'>Type</th>";
                        echo "<th style='width: 10%'>Buy Price</th>";
                        echo "<th style='width: 10%'>Sell Price</th>";
                        echo "<th style='width: 10%'>Stock</th>";
                        echo "<th style='width: 10%'>Stock worth</th>";
                        echo "</tr>";

                        foreach ($result_stock as $index => $product) {
                            echo "<tr>";
                            echo "<td><input type=\"checkbox\"></td>";
                            echo "<td><img src=\"dependencies/img/products/worx_accuboorhamer.jpg\" class=\"management_existing_products_image\"></td>";
                            echo "<td>" . $product['productname'] . "</td>";
                            echo "<td>" . $product['productbrand'] . "</td>";
                            echo "<td>" . $product['producttype'] . "</td>";
                            echo "<td>€" . $product['buyprice'] . "</td>";
                            echo "<td>€" . $product['sellprice'] . "</td>";
                            echo "<td>" . $product['stock'] . "</td>";
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
            <input type="button" value="Delete selected" style="border: 0px; padding: 5px; background-color: red">

        </div>

    <br>
    <br>
    <br>
    <br>
    </div>


</div>
</body>
</html>