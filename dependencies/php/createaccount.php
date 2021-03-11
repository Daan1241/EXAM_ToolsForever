<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);

require 'php_mailer/Exception.php';
require 'php_mailer/PHPMailer.php';
require 'php_mailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "pdo.php";
if ($sanitized['username'] == "" || $sanitized['username'] == null || $sanitized['email'] == "" || $sanitized['email'] == null) {
    header("Location: ../../login.php?alert=not_all_info");
} else {

    // Instantiate E-mail and create an activation key for single-time use.
    $mail = new PHPMailer(true);
    $activationkey = bin2hex(random_bytes(64));

    // Check database for already existing users with this username
    $sql = "SELECT * FROM users WHERE username=?";
    $run = $connection->prepare($sql);
    $run->execute([$sanitized['username']]);
    $result = $run->fetchAll();

    // If result back equals NULL (meaning no user has been found), proceed with creating account.
    if ($result == null) {
        $salt = rand(1, 2122122); // Generate random salt for password encryption
        $password_encrypted = sha1(random_bytes(16) . $salt); // Encrypt password with salt
        $sql = "INSERT INTO users (email, username, password, privileges, salt, activationkey) VALUES (?, ?, ?, 'client', ?, ?)";
        $run = $connection->prepare($sql);
        $run->execute([$sanitized['email'], $sanitized['username'], $password_encrypted, $salt, $activationkey]);
        $result = $run->fetchAll();
        // Create account without randomized password


        // Send E-mail to user
        try {
            // Under-the-hood mail settings
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // Define SMTP server to send trough
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'ElysiumManagementSystems@gmail.com'; //SMTP username
            $mail->Password = './EMS!2122122'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to

            // Visible mail settings
            $mail->setFrom('management@toolsforever.com', 'ToolsForever Management (NOREPLY)');
            $mail->addAddress($sanitized['email']); // Define where to send the mail to
            $mail->isHTML(true); // Tells whether the body of the mail uses HTML.
            $mail->Subject = 'Complete your registration at ToolsForever';
            $mail->Body = '<h2>Welcome '.$sanitized['username'].' to <b>ToolsForever</b>!</h2><br><br>In order to start using your account you first need to set a password. To do so, please click the following link:<br><br><a href="http://daanklein.nl/school/ToolsForever/activateaccount.php?user='.$sanitized['username'].'&token=' . $activationkey . '">Activate my account</a><br><br>Did you not create an account? In that case, feel free to ignore and delete this E-mail.';
            $mail->AltBody = 'Please use a more modern browser to view this E-mail. To activate your account anyway, use the following link: http://daanklein.nl/school/ToolsForever/activateaccount.php?user='.$sanitized['username'].'&token=' . $activationkey;

            $mail->send();
            // Message has been sent
            header("Location: ../../login.php?alert=check_email");
        } catch (Exception $e) {
            // Message could not be sent due to an error.
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //header("Location: ../../login.php?alert=error_critical");
        }


    } else {
        header("Location: ../../login.php?alert=already_exists");
    }
}

?>