<?php
// Check for login before loading page

// €
?>

<html>
<head>
    <title>ToolsForEver - Home</title>
    <link rel="stylesheet" href="dependencies/css/variables.css">
    <link rel="stylesheet" href="dependencies/css/style.css">
</head>
<body>
<div id="topbar">
    <a href="index.php"><div class="topbar_container">HOME</div></a>
    <a href="management.php"><div class="topbar_container">MANAGEMENT</div></a>
    <a href="login.php"><div class="topbar_container"><b>LOGIN</b></div></a>
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
        <b class="password_forgotten">Forgot password?</b><br>
    </div>



</div>
</body>
</html>