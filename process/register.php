<?php
include '../config/constant.php';
require '../phpmailer/PHPMailerAutoload.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$cPassword = $_POST['cPassword'];
$userImg = $_POST['userImg'];

if(isset($_FILES["image"]["name"])) {
    $image = $_FILES['image']['name'];
    $path = "../Images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;
} else {
    $filename = "user.png";
}

$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if($fname == null || $lname == null || $email == null || $password == null || $cPassword == null) {
    echo "blank";
} else {
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        echo "invalid";
    } else {
        if($password != $cPassword) {
            echo "nMatch";
        } else {
            $check_exist = $conn->query("SELECT * FROM users WHERE email = '$email' LIMIT 1");
            if(mysqli_num_rows($check_exist) > 0) {
                echo "exist"; 
            } else {
                $newPwd = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                $generate_token = openssl_random_pseudo_bytes(11);
                $converted_token = bin2hex($generate_token);
                $register = $conn->query("INSERT INTO users (fname, lname, fullname, picture, email, password, verifiedEmail, token, role) 
                VALUES ('$fname', '$lname', '$fullname', '$filename', '$email', '$newPwd', '0', '$converted_token', 'User')");
                
                if($register) {
                    move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);

                    $message = "<a href='http://localhost/FinalYearProject/thankyou.php?email=$email'>Verify Email</a></a>";
                    $headers = "From: fyp.rnsservice@gmail.com<br>";
                    $headers .= "MIME-Version: 1.0<br>";
                    $headers .= "Content-type:text/html;charset=UTF-8<br>";
                
                    $mail = new PHPMailer();
                
                    $mail->isSMTP();
                    $mail->Host="smtp.gmail.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = "fyp.rnsservice@gmail.com";
                    $mail->Password = 'gvwkiyvkdtlevhdc';    
                    $mail->Port = 587;
                    $mail->SMTPSecure = "tls";
                
                    $mail->isHTML(true);
                    $mail->setFrom($email);
                    $mail->addAddress($email);
                    $mail->Subject = "R&S - Verify Email";
                    $mail->Body = "$headers<br><br>"
                                . "<br>Please click here to verify your email address: "
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
                    echo 'error';
                }
            } 
        }
    }
}




?>