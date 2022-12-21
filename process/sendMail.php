<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendMail($senderEmail, $receiveEmail, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lacccarrental@gmail.com';                 // SMTP username
        $mail->Password = 'hzfmqbwoqqisdbls';    
        // $mail->Username = 'fyp.rnsservice@gmail.com';
        // $mail->Password = 'gvwkiyvkdtlevhdc';
        $mail->SMTPSecure = 'tsl';
        $mail->Port = 587;

        $mail->setFrom($senderEmail, 'RNS Service');
        $mail->addAddress($receiveEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;
        $mail->send();
        echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>