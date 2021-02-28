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
              <div class=\"topbar_container\"><b>LOGIN</b></div>
              </a>";
        }
        ?>
    </div>
</div>

<div id="wrapper">
    <br>
    <div class="login_form_wrapper">
        <b style="font-size: 200%;">Log-in</b>
        <form method="POST" action="dependencies/php/loginhandler.php" class="login_form">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" class="input_field" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="text" name="password" class="input_field" required></td>
                </tr>
                <tr>
                    <td colspan="2"><br><input type="submit" value="Log-in" class="input_submit"></td>
                </tr>
            </table>
        </form>
        <br>
        <b class="password_forgotten">Forgot password?</b><br>

        <br><br><br><br>
        Or, create a new account
        <form method="POST" action="dependencies/php/createaccount.php" class="login_form">
            <table>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="email" name="email" id="CA_email" class="input_field" required></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" id="CA_username" class="input_field" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="CA_password" class="input_field" required></td>
                </tr>
                <tr>
                    <td>Repeat password:</td>
                    <td><input type="password" name="password_repeat" id="CA_password_repeat"
                               onfocusout="checkPassword();"
                               class="input_field" required></td>
                </tr>
                <tr>
                    <td colspan="2"><br><input type="submit" value="Log-in" class="input_submit"></td>
                </tr>
            </table>
        </form>
        <p class="alert" id="alert"></p>
    </div>


</div>
</body>
<script src="dependencies/js/page_login.js"></script>
</html>