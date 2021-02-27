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
        header("Location: index.php");
    }
}

?>

<html>
<head>
    <title>ToolsForEver - Admin</title>
    <script src="dependencies/js/main.js"></script>
    <link rel="stylesheet" href="dependencies/css/variables.css">
    <link rel="stylesheet" href="dependencies/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap"
          rel="stylesheet">
    <script src="dependencies/js/admin.js"></script>
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
        <form action="#" method="POST">
            <table>
                <tr>
                    <td><b>User:</b></td>
                    <td><b>Privilege:</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="text" name="admin_search_user_name" id="admin_search_user_name"></td>
                    <td><select name="admin_search_user_privilege" id="admin_search_user_privilege">
                            <option name=""></option>
                            <option name="admin">admin</option>
                            <option name="employee">employee</option>
                            <option name="client">client</option>
                        </select>
                    </td>
                    <td><input type="submit" class="button_default" value="search"></td>
                </tr>
            </table>
        </form>


        <div class="management_details_container">
            <b style="font-size: 200%;">Results</b>

            <table style="text-align: left;" class="admin_table">
                <tr>
                    <th>UUID</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Password</th>
                    <th>Salt</th>
                    <th>Reset</th>
                    <th>Verwijder</th>
                </tr>
                <?php
                $sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
                if (isset($sanitized['admin_search_user_name']) || isset($sanitized['admin_search_user_privilege'])) {
                    echo "Searching for '<b>".$sanitized['admin_search_user_name']."</b>'<a href='admin.php'>(cancel search)</a>.";

                    if ($sanitized['admin_search_user_privilege'] == "" || $sanitized['admin_search_user_privilege'] == null) {
                        $sql = "SELECT * FROM users WHERE username=?";
                        $run = $connection->prepare($sql);
                        $run->execute([$sanitized['admin_search_user_name']]);
                        $result = $run->fetchAll();
                    } else {
                        $sql = "SELECT * FROM users WHERE username=? AND privileges=?";
                        $run = $connection->prepare($sql);
                        $run->execute([$sanitized['admin_search_user_name'], $sanitized['admin_search_user_privilege']]);
                        $result = $run->fetchAll();
                    }

                    // Finally, print out result
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UUID'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td class='admin_information_password'>" . $row['password'] . "</td>";
                        echo "<td>" . $row['salt'] . "</td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"reset\"></td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"delete\"></td>";
                    }
                } else {
                    $sql = "SELECT * FROM users";
                    $run = $connection->prepare($sql);
                    $run->execute();
                    $result = $run->fetchAll();

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UUID'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td class='admin_information_password'>" . $row['password'] . "</td>";
                        echo "<td>" . $row['salt'] . "</td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"reset\"></td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"delete\"></td>";
                    }
                }
                ?>
            </table>


        </div>


    </div>


</div>
</body>
</html>