<?php
// Needs to be set before checkLoggedIn.php gets required.
$loggedIn = false;

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
            <div class="topbar_container">HOME</div>
        </a>
        <a href="management.php">
            <div class="topbar_container">MANAGEMENT</div>
        </a>
        <a href="locations.php">
            <div class="topbar_container">LOCATIONS</div>
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
              <div class=\"topbar_container\"><b>LOGIN</b></div>
              </a>";
        }
        ?>
    </div>
</div>

<div id="wrapper">
    <br>
    <div class="login_form_wrapper">
        <b style="font-size: 200%;" id="Login_title">Log-in</b>
        <form method="POST" action="dependencies/php/loginhandler.php" class="login_form">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" class="input_field" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" class="input_field" required></td>
                </tr>
                <tr>
                    <td colspan="2"><br><input type="submit" value="Log-in" class="input_submit"></td>
                </tr>
            </table>
        </form>
        <br>
        <b class="password_forgotten">Forgot password?</b><br>
        <p class="alert" id="alert"></p>
    </div>


</div>
</body>
<script src="dependencies/js/page_login.js"></script>
</html>