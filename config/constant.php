<?php
session_start();

//Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "r&s";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Error Connection: ". mysqli_error($conn));
}
?>