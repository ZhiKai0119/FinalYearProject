<?php
include '../../config/constant.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

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
    $mail = new PHPMailer(true);

    try {
        // $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lacccarrental@gmail.com';                 // SMTP username
        $mail->Password = 'hzfmqbwoqqisdbls';    
        // $mail->Username = 'fyp.rnsservice@gmail.com';
        // $mail->Password = 'gvwkiyvkdtlevhdc';
        $mail->SMTPSecure = 'tsl';
        $mail->Port = 587;

        $mail->setFrom($email, 'RNS Service');
        $mail->addAddress($email2);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;
        $mail->send();
        echo 'true';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }












//     $mail = new PHPMailer(true);                         

//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com'; 
//     $mail->SMTPAuth = true;     
// //    $mail->Username = 'lacccarrental@gmail.com';                 // SMTP username
// //    $mail->Password = 'hzfmqbwoqqisdbls';                           // SMTP password
//     $mail->Username = "fyp.rnsservice@gmail.com";
//     $mail->Password = 'gvwkiyvkdtlevhdc';
//     $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//     $mail->Port = '25';        
//     $mail->setFrom($email2);


//     $mail->AddReplyTo($email);
//     $mail->From = $email2;
//     $mail->FromName = $fname;
//     $mail->addAddress('fyp.rnsservice@gmail.com');     // Add a recipient

//     // $mail->isHTML(true);                                  // Set email format to HTML

//     $mail->Subject = $subject;
//     $mail->Body = $message;
//     // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     if (!$mail->send()) {
//         echo 'Message could not be sent.';
//         echo 'Mailer Error: ' . $mail->ErrorInfo;
//     } else {
//         echo 'true';
//     }
}
?>