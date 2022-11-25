<?php
include '../../config/constant.php';

$fname = $_POST['fname'];
$email = $_POST['email'];
$message= $_POST['message'];

$email2 = "lacccarrental@gmail.com";
$subject = "Test Message";

if (strlen($fname) > 50) {
    echo 'fname_long';

} elseif (strlen($fname) < 2) {
    echo 'fname_short';

} elseif (strlen($email) > 50) {
    echo 'email_long';

} elseif (strlen($email) < 2) {
    echo 'email_short';

} elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo 'eformat';

} elseif (strlen($message) > 500) {
    echo 'message_long';

} elseif (strlen($message) < 3) {
    echo 'message_short';

} else {
    require '../../phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
//    $mail->Username = 'lacccarrental@gmail.com';                 // SMTP username
//    $mail->Password = 'hzfmqbwoqqisdbls';                           // SMTP password
    $mail->Username = "fyp.rnsservice@gmail.com";
    $mail->Password = 'gvwkiyvkdtlevhdc';
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->AddReplyTo($email);
    $mail->From = $email2;
    $mail->FromName = $fname;
    $mail->addAddress('fyp.rnsservice@gmail.com', 'Admin');     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'true';
    }
}
?>