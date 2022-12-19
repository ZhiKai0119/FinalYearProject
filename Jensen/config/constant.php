<?php

//Connect to database
$hostname = "localhost:3306";
$username = "root";
$password = "root";
$database = "r_s";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Error Connection: " . $conn -> connection_error);
}
date_default_timezone_set('Asia/Karachi');

$error = ""
?>