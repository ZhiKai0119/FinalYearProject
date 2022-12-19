<?php

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
} else {
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './mail/Exception.php';
require './mail/PHPMailer.php';
require './mail/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "fyp.rnsservice@gmail.com";
    $mail->Password = 'gvwkiyvkdtlevhdc';
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";

    $mail->isHTML(true);
    $mail->setFrom($email);
    $mail->addAddress($email);
    $mail->Subject = "R&S - Reset Password";
    $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);
    $mail->Body = 'To reset your password click <a href="http://localhost/jensen/change_password.php?code=' . $code . '">here </a>. </br>Reset your password in a day.';

    $conn = new mySqli('localhost:3306', 'root', '', 'r_s');

    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }

    $verifyQuery = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($verifyQuery->num_rows) {
        $codeQuery = $conn->query("UPDATE users SET code = '$code' WHERE email = '$email'");

        $mail->send();
        echo 'Message has been sent, check your email';
    }
    $conn->close();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>