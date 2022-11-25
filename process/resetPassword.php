<?php
include '../config/constant.php';

$nPwd = $_POST['nPwd'];
$comfirmPwd = $_POST['comfirmPwd'];
$email = $_POST['email'];

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $nPwd);
$lowercase = preg_match('@[a-z]@', $nPwd);
$number    = preg_match('@[0-9]@', $nPwd);
$specialChars = preg_match('@[^\w]@', $nPwd);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($nPwd) < 8) {
    echo 'invalid';
} else if ($nPwd != $comfirmPwd) {
    echo 'nMatch';
}else{
    $sPwd = password_hash($nPwd, PASSWORD_BCRYPT, array('cost' => 12));
    
    $update = $conn->query("UPDATE users SET password = '$sPwd' WHERE email = '$email'");
    if($update) {
        echo 'true';
    } else {
        echo 'false';
    }
}
?>