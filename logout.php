<?php
session_start();

include 'config/constant.php';

if (isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $fullName = $userInfo['fullName'];
    
    $loginSQL = "SELECT * FROM login WHERE username = '{$fullName}' AND logoutDateTime = '0000-00-00 00:00:00'";
    $loginResult = mysqli_query($conn, $loginSQL);
    $loginInfo = mysqli_fetch_assoc($loginResult);
    $loginId = $loginInfo['id'];
    
    $updateLogin = $conn->query("UPDATE login SET logoutDateTime = now() WHERE id = '{$loginId}'");
} else {
    $loginSQL = "SELECT * FROM login WHERE logoutDateTime = '0000-00-00 00:00:00'";
    $loginResult = mysqli_query($conn, $loginSQL);
    $loginInfo = mysqli_fetch_assoc($loginResult);
    $loginId = $loginInfo['id'];
    $updateLogin = $conn->query("UPDATE login SET logoutDateTime = now() WHERE id = '{$loginId}'");
    header("Location: ../index.php");
    exit();
}


setcookie('id', '', time()-60*60*24*30, '/');
setcookie('token', '', time()-60*60*24*30, '/');
//setcookie('sess', '', time()-60*60*24*30, '/');

session_unset();
session_destroy();

//header("Location: index.php");
header("Location: User/main.php");
die();
?>