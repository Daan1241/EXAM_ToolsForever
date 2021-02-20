<?php
//error_reporting (10000);
require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";
if (!isset($_SESSION)) { // Session not yet started.
    session_start();
    echo 'New session started.'; // Still empty, asking for username or sessionID will result in an error.
} else {
    if (!$_SESSION == null) { // Session has variables in it.
        if (checkLogin($_SESSION['username'], $_SESSION['sessionID']) == "true") {
            echo "log in succesvol!";
        }
    } else {
        echo "Not logged in lol.";
    }
}
?>

<html>
<head>
    <title>ToolsForEver - Home</title>
    <link rel="stylesheet" href="dependencies/css/variables.css">
    <link rel="stylesheet" href="dependencies/css/style.css">
</head>
<body>
<div id="topbar">
    <a href="index.php">
        <div class="topbar_container"><b>HOME</b></div>
    </a>
    <a href="management.php">
        <div class="topbar_container">MANAGEMENT</div>
    </a>
    <?php
    if (checkLogin($_SESSION['username'], $_SESSION['sessionID']) == "true") {
        echo "<a href=\"logout.php\">
              <div class=\"topbar_container\">LOGOUT</div>
              </a>";
    } else {
        echo "<a href=\"login.php\">
              <div class=\"topbar_container\">LOGIN</div>
              </a>";
    }


    ?>

</div>

<div id="wrapper">
    <?php
    if (checkLogin($_SESSION['username'], $_SESSION['sessionID']) == true) {
        echo "Welkom " . $_SESSION['username'];
    }
    ?>
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
</body>
</html>