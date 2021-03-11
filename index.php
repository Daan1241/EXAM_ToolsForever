<?php
//error_reporting (10000);
$loggedIn = false; // Needs to be before checkLoggedIn.php requires.
require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";


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
            <div class="topbar_container"><b>HOME</b></div>
        </a>
        <a href="management.php">
            <div class="topbar_container">MANAGEMENT</div>
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
    <div id="page_content">
        <div class="home_banner">
            <img src="dependencies/img/banner.jpg" style="width: 100%">
        </div>

        <?php
        if ($loggedIn == true) {
            echo "<div class=\"home_personal_details\">";
            echo "<b style='font-size: 200%;'>Welkom " . $_SESSION['username'] . "</b><br>";

            $sql = "SELECT DISTINCT * FROM users WHERE username=? AND sessionID=?";
            $run = $connection->prepare($sql);
            $run->execute([$sanitized['username'], $sanitized['sessionID']]);
            $database_result = $run->fetchAll();

            echo "<table>";
            echo "<tr><td><b>username:</b></td><td>" . $database_result[0]['username'] . "</td></tr>";
            echo "<tr><td><b>Privileges:</b></td><td>" . $database_result[0]['privileges'] . "</td></tr>";
            echo "<tr><td><b>User ID:</b></td><td>" . $database_result[0]['UUID'] . "</td></tr>";
            echo "</table>";
            echo "</div>";
        }
        ?>


        <div class="home_city_details_container" onClick="window.location.href = 'management.php?city=almere';">
            <b style="font-size: 200%;">ToolsForever Management System</b><br><br>
            <br>
        </div>
    </div>
    <div id="side_menu">
        <b style='font-size: 150%;'>Beheer (<font color="red">!</font>)</b><br>

        <ul>
            <div class="side_menu_list_item">
                - <b>Stock</b>
                <ul style="list-style: square;">
                    <li><a class="side_menu_quicklink" href="management.php?action=look">View stock</a></li>
                </ul>
            </div>
            <div class="side_menu_list_item">
                - <b>Products</b>
                <ul style="list-style: square;">
                    <li><a class="side_menu_quicklink" href="management.php#products">Manage products</a></li>
                    <li><a class="side_menu_quicklink" href="management.php#addproducts">Add products</a></li>
                    <li><a class="side_menu_quicklink" href="management.php#searchproducts">Search products</a></li>
                </ul>
            </div>
            <div class="side_menu_list_item">
                - <b>Locations</b>
                <ul style="list-style: square;">
                    <li><a class="side_menu_quicklink" href="locations.php#locations">View locations</a></li>
                    <li><a class="side_menu_quicklink" href="locations.php#addlocations">Add locations</a></li>
                    <li><a class="side_menu_quicklink" href="locations.php#modifylocations">Modify locations</a></li>
                </ul>
            </div>

            <div class="side_menu_list_item">
                - <b>Users</b>
                <ul style="list-style: square;">
                    <li><a class="side_menu_quicklink" href="admin.php">View users</a></li>
                    <li><a class="side_menu_quicklink" href="admin.php">Add users</a></li>
                    <li><a class="side_menu_quicklink" href="admin.php">Modify users</a>
                    </li>
                </ul>
            </div>

        </ul>

    </div>
</div>
</body>
</html>