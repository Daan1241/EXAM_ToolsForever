<?php
require "pdo.php";

require 'php_mailer/Exception.php';
require 'php_mailer/PHPMailer.php';
require 'php_mailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);

// Database request
$sql = "SELECT * FROM users WHERE UUID=?";
$run = $connection->prepare($sql);
$run->execute([$sanitized['userID']]);
$result = $run->fetchAll();
// --

$token = sha1($result[0]['username']."1241");
$mail = new PHPMailer(true);

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
    $mail->addAddress($result[0]['email']); // Define where to send the mail to
    $mail->isHTML(true); // Tells whether the body of the mail uses HTML.
    $mail->Subject = 'Reset your ToolsForever password';
    $mail->Body = '<h2>Message from <b>ToolsForever</b>!</h2><br><br>Hi! An administrator has reset your password, and you can now choose a new one by clicking the following link.<br><br><a href="http://daanklein.nl/school/ToolsForever/changepassword.php?user='.$result[0]['username'].'&token=' . $token . '">Change my password</a><br><br>Did you not request a password reset? In that case, feel free to ignore and delete this E-mail. No changes will be made until you click this link.';
    $mail->AltBody = 'Please use a more modern browser to view this E-mail.';

    $mail->send();
    // Message has been sent
    echo "E-mail to change password has been sent to user";
} catch (Exception $e) {
    // Message could not be sent due to an error.
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    //header("Location: ../../login.php?alert=error_critical");
}


?>