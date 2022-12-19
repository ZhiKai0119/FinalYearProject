<?php

session_start();
if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}


include 'functions.php';
$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';

include $page . '.php';
?>
