<?php
$loggedIn = false; // Needs to be before checkLoggedIn.php requires.
require "dependencies/php/pdo.php";
require "dependencies/php/checkLoggedIn.php";

if ($loggedIn == false) {
    header("Location: login.php?alert=no_access");
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
        <a href="locations.php">
            <div class="topbar_container">LOCATIONS</div>
        </a>
        <a href="orders.php">
            <div class="topbar_container">ORDERS</div>
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
        <div class="management_details_container">
            <b style="font-size: 200%;">Create account</b><br><br>
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

                        <td colspan="2"><br><input type="submit" value="Create account" class="input_submit"></td>
                    </tr>
                </table>
            </form>
        </div>


        <div class="management_details_container">
            <b style="font-size: 200%;">Search user</b><br><br>
            <form action="#" method="POST">
                <table>
                    <tr>
                        <td><b>User:</b></td>
                        <td><b>Privilege:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="admin_search_user_name" id="admin_search_user_name" value="<?php
                            $sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
                            if (isset($sanitized['admin_search_user_privilege'])) {
                                echo "SF: " . $sanitized['admin_search_user_privilege'];
                            }
                            ?>"></td>
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
        </div>


        <div class="management_details_container">
            <b style="font-size: 200%;">All users</b><br><br>

            <table style="text-align: left;" class="admin_table">
                <tr>
                    <th width="5%">UUID</th>
                    <th width="10%">Username</th>
                    <th width="15%">E-mail</th>
                    <th width="20%">Password (Hashed & encrypted)</th>
                    <th>Salt</th>
                    <th>Role</th>
                    <th>Password</th>
                    <th>Verwijder</th>
                </tr>
                <?php
                if (isset($sanitized['admin_search_user_name']) || isset($sanitized['admin_search_user_privilege'])) {
                    echo "Searching for '<b>" . $sanitized['admin_search_user_name'] . "</b>'<a href='admin.php'>(cancel search)</a>.";

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
                        echo "<td onclick='admin_modify(this)'>" . $row['username'] . "</td>";
                        echo "<td onclick='admin_modify(this)'>" . $row['email'] . "</td>";
                        echo "<td class='admin_information_password'>" . $row['password'] . "</td>";
                        echo "<td>" . $row['salt'] . "</td>";
                        if ($row['privileges'] == 'admin') {
                            echo "<td><select><option name='admin' selected='selected'>Admin</option><option name='employee'>Employee</option><option name='client'>Client</option></select></td>";
                        } else if ($row['privileges'] == 'employee') {
                            echo "<td><select><option name='admin'>Admin</option><option name='employee' selected='selected'>Employee</option><option name='client'>Client</option></select></td>";
                        } else if ($row['privileges'] == 'client') {
                            echo "<td><select><option name='admin'>Admin</option><option name='employee'>Employee</option><option name='client' selected='selected'>Client</option></select></td>";
                        }
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"reset\" onclick=\"resetpassword('" . $row['UUID'] . "')\"></td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"delete\" onclick=\"deleteuser('" . $row['UUID'] . "')\"></td>";
                    }
                } else {
                    $sql = "SELECT * FROM users";
                    $run = $connection->prepare($sql);
                    $run->execute();
                    $result = $run->fetchAll();

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UUID'] . "</td>";
                        echo "<td onclick='admin_modify(this)'>" . $row['username'] . "</td>";
                        echo "<td onclick='admin_modify(this)'>" . $row['email'] . "</td>";
                        echo "<td class='admin_information_password'>" . $row['password'] . "</td>";
                        echo "<td>" . $row['salt'] . "</td>";
                        if ($row['privileges'] == 'admin') {
                            echo "<td><select><option name='admin' selected='selected'>Admin</option><option name='employee'>Employee</option><option name='client'>Client</option></select></td>";
                        } else if ($row['privileges'] == 'employee') {
                            echo "<td><select><option name='admin'>Admin</option><option name='employee' selected='selected'>Employee</option><option name='client'>Client</option></select></td>";
                        } else if ($row['privileges'] == 'client') {
                            echo "<td><select><option name='admin'>Admin</option><option name='employee'>Employee</option><option name='client' selected='selected'>Client</option></select></td>";
                        }

                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"reset\" onclick=\"resetpassword('" . $row['UUID'] . "')\"></td>";
                        echo "<td><input type=\"button\" class=\"admin_resetpassword\" value=\"delete\" onclick=\"deleteuser('" . $row['UUID'] . "')\"></td>";
                    }
                }
                ?>
            </table>


        </div>


    </div>


</div>
</body>
</html>