<?php
include '../config/constant.php';

$inputEmail = $_POST['inputEmail'];
$inputPassword = $_POST['inputPassword'];

$query = "SELECT * FROM users WHERE email = '$inputEmail'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($inputPassword, $row['password'])) {
        if($row['verifiedEmail'] == 1) {
            if($row['role'] == 'Owner') {
                setcookie("id", $row['id'], time()+60*60*24*30, "/", NULL);
                setcookie("token", $row['token'], time()+60*60*24*30, "/", NULL);
                $_SESSION['user_token'] = $row['token'];
                echo 'owner';   
            } else if($row['role'] == 'User') {
                setcookie("id", $row['id'], time()+60*60*24*30, "/", NULL);
                setcookie("token", $row['token'], time()+60*60*24*30, "/", NULL);
                $_SESSION['user_token'] = $row['token'];
                echo 'user';
            } else {
                echo 'false';
            }    
        } else {
            echo 'verify';
        }     
    } else {
        echo 'false';
    }
} else {
    echo 'invalidEmail';
}
?>