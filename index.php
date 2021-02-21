<?php
//error_reporting (10000);
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
        <?php
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
        <div class="home_personal_details">
            <?php
            if ($loggedIn == true) {
                echo "<b style='font-size: 150%;'>Welcome " . $_SESSION['username'] . "</b><br>";

                $sql = "SELECT DISTINCT * FROM users WHERE username=? AND sessionID=?";
                $run = $connection->prepare($sql);
                $run->execute([$sanitized['username'], $sanitized['sessionID']]);
                $database_result = $run->fetchAll();

                echo "<table>";
                echo "<tr><td><b>username:</b></td><td>" . $database_result[0]['username'] . "</td></tr>";
                echo "<tr><td><b>Privileges:</b></td><td>" . $database_result[0]['privileges'] . "</td></tr>";
                echo "<tr><td><b>User ID:</b></td><td>" . $database_result[0]['UUID'] . "</td></tr>";
                echo "</table>";
            }
            ?>
        </div>

        <div class="home_city_details_container">
            <b style="font-size: 200%;">Almere</b>
            <table>
                <tr>
                    <th>Totaal producten</th>
                    <th>Waarde inkoop</th>
                    <th>Waarde verkoop</th>
                </tr>
                <tr>
                    <td>42</td>
                    <td>€2145,95</td>
                    <td>€3057,89</td>
                </tr>
            </table>
        </div>

        <div class="home_city_details_container">
            <b style="font-size: 200%;">Eindhoven</b>
            <table>
                <tr>
                    <th>Totaal producten</th>
                    <th>Waarde inkoop</th>
                    <th>Waarde verkoop</th>
                </tr>
                <tr>
                    <td>42</td>
                    <td>€2145,95</td>
                    <td>€3057,89</td>
                </tr>
            </table>
        </div>

        <div class="home_city_details_container">
            <b style="font-size: 200%;">Rotterdam</b>
            <table>
                <tr>
                    <th>Totaal producten</th>
                    <th>Waarde inkoop</th>
                    <th>Waarde verkoop</th>
                </tr>
                <tr>
                    <td>42</td>
                    <td>€2145,95</td>
                    <td>€3057,89</td>
                </tr>
            </table>
        </div>
    </div>
    <div id="side_menu">
        <b style='font-size: 150%;'>Beheer</b><br>
        <ul style="list-style: square;">
            <li><a class="side_menu_quicklink" href="management.php?action=print">Print voorraad</a></li>
        </ul>

    </div>
</div>
</body>
</html>