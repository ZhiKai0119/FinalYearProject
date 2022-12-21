<?php
include '../config/constant.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$fgtEmail = $_POST['fgtEmail'];

if (strlen($fgtEmail) < 2) {
    echo 'eshort';
} else if (filter_var($fgtEmail, FILTER_VALIDATE_EMAIL) === false) {
    echo 'eformat';
} else {
    $sql = "SELECT * FROM users WHERE email = '$fgtEmail'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
//        $vkey = $row['vkey'];
        $email = $row['email'];

        $message = "<a href='http://localhost/FinalYearProject/resetPwd.php?email=$email'>Reset Password</a>";
        $headers = "From: fyp.rnsservice@gmail.com<br>";
        $headers .= "MIME-Version: 1.0<br>";
        $headers .= "Content-type:text/html;charset=UTF-8<br>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'lacccarrental@gmail.com';                 // SMTP username
        $mail->Password = 'hzfmqbwoqqisdbls';  
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";

        $mail->isHTML(true);
        $mail->setFrom("lacccarrental@gmail.com", "R&S Service");
        $mail->addAddress($email);
        $mail->Subject = "R&S - Reset Password";
        $mail->Body = "$headers<br><br>"
                    . "<br>Please click here: "
                    . "$message <br><br>"
                    . "-- <br> This e-mail was sent from a registered company, R&S Service (http://localhost/FinalYearProject/User/contactUs.php)";

        if($mail->send()){
            $status = "success";
            $response = "Email is sent";
            echo 'true';
        }else{
            $status = "failed";
            $response = "Something is wrong <br>".$mail->ErrorInfo;
            echo 'false';
        }
    } else {
        echo 'invalid';
    }
}

?>