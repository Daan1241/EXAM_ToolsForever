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
    <br>
    <div class="login_form_wrapper">
        <b style="font-size: 200%;">Log-in</b>
        <form method="POST" action="dependencies/php/loginhandler.php" class="login_form">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" class="input_field"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input name="password" class="input_field"></td>
                </tr>
                <tr>
                    <td colspan="2"><br><input type="submit" value="Log-in" class="input_submit"></td>
                </tr>
            </table>
        </form>
        <script>
            if (urlParams.get('login') == "fail") {
                document.write("<div id='password_fail'>Login failed, please check credentials again.</div>");
            }
        </script>
        <br>
        <b class="password_forgotten">Forgot password?</b><br>
    </div>


</div>
</body>
</html>