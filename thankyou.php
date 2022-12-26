<?php 
include './config/constant.php';

if(isset($_GET['email']))
    $email = $_GET['email'];

    $conn->query("UPDATE users SET verifiedEmail = '1' WHERE email = '$email'");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Thank You</title>
        <link rel="stylesheet" href="./CSS/bootstrap-4.0.0/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="./CSS/bootstrap-4.0.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <div class="jumbotron text-center">
        <h1 class="display-3">Thank You!</h1>
        <p class="lead"><strong>Successfully Registered.</strong> Please login to your account.</p>
        <hr>
        <p>
            Having trouble? <a href="./User/contactUs.php">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="./index.php" role="button">Login</a>
        </p>
    </div>
    </body>
</html>
