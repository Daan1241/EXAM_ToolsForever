<?php
// Needs to be set before checkLoggedIn.php gets required.
$loggedIn = false;

require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";

$sanitized_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_MAGIC_QUOTES);

if ($loggedIn == true) {
    // User is logged in.
} else {
    // If user is not logged in, redirect to login page.
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
    <script src="dependencies/js/page_locations.js"></script>
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
            <div class="topbar_container">MANAGEMENT</div>
        </a>
        <a href="locations.php">
            <div class="topbar_container"><b>LOCATIONS</b></div>
        </a>
        <a href="orders.php">
            <div class="topbar_container">ORDERS</div>
        </a>
        <?php
        // Checks if user is logged in as administrator, and if so, adds the admin page to the navigation bar.
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
            <form action="dependencies/php/management_addlocation.php" method="post">
                <b style="font-size: 200%;">Add a location</b><br><br>
                <table>
                    <tr>
                        <th>City</th>
                        <th>Adress</th>
                        <th>Zipcode</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><input type="text" maxlength="64" name="input_name" id="input_name"
                                   placeholder="City (e.g. Amsterdam)" class="add_location_input"></td>
                        <td><input type="text" maxlength="256" name="input_adress" id="input_name"
                                   placeholder="Adress (e.g. Buikslotermeerplein 264)" class="add_location_input"></td>
                        <td><input type="text" maxlength="7" name="input_zipcode" id="input_name" placeholder="1234AB"
                                   class="add_location_input"></td>
                        <td><input type="submit" value="Add" class="add_location_input"></td>
                    </tr>
                </table>
            </form>
        </div>


        <div class="management_details_container">

            <div class="management_existing_products">
                <b style="font-size: 200%;">Locations</b><br><br>
                <table>
                    <tr>
                        <th width="5%" style="display:none">ID</th>
                        <th width="5%">Location</th>
                        <th width="10%">Zipcode</th>
                        <th width="35%">Adress</th>
                    </tr>
                    <?php
                    // Gets all data from all locations and prints them to a table.
                    $sql = "SELECT DISTINCT * FROM locations";
                    $run = $connection->prepare($sql);
                    $run->execute();
                    $result_locations = $run->fetchAll();

                    foreach ($result_locations as $locationinfo) {
                        echo "<tr>";
                        echo "<td style='display:none'>" . $locationinfo['locationID'] . "</td>";
                        echo "<td onclick='modify_location(this)'>" . $locationinfo['locationname'] . "</td>";
                        echo "<td onclick='modify_location(this)'>" . $locationinfo['zipcode_numbers'] . $locationinfo['zipcode_letters'] . "</td>";
                        echo "<td onclick='modify_location(this)'>" . $locationinfo['locationadress'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
    </div>
</div>
</body>
</html>