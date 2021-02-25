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
            <div class=\"topbar_container\"><b>ADMIN</b></div>
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
                <td><b>Gebruiker:</b></td>
                <td><b>Privilege:</b></td>
            </tr>
            <tr>
                <td><input type="text" id="admin_search_user_name"></td>
                <td><select id="admin_search_user_privilege">
                        <option name=""></option>
                        <option name="admin">Admin</option>
                        <option name="employee">Employee</option>
                        <option name="client">Client</option>
                    </select></td>
            </tr>
        </table>


        <div class="management_details_container">
            <b style="font-size: 200%;">Results</b>
            <table style="text-align: left;">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Password</th>
                </tr>
                <tr>
                    <td>42</td>
                    <td>€2145,95</td>
                    <td>meel@meel.com</td>
                    <td><input type="button" value="reset"></td>
                </tr>
            </table>
        </div>


    </div>


</div>
</body>
</html>