<?php include '../config/constant.php'; ?>

<!DOCTYPE html>
<!--<html>-->
<head>
    <title>RNS Service</title>
    <link rel="icon" type="image/x-icon" href="../../Images/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <link rel="stylesheet" href="./CSS/pagination.css"/>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">

    <!--        JS Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <!--        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">-->

    <!--Alertify Js-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat');
        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }

        .notification .badge {
            position: relative;
            top: -12px;
            left: -10px;
            border-radius: 50%;
        }
    </style>
</head>
<!--    <body>-->

<!-- bg-primary, bg-success, bg-warning, bg-info, bg-danger, bg-light, bg-dark-->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">

    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapse_target">
        <a class="navbar-brand" href="index.php">
<!--                    <img src="#">-->
            <span class="navbar-text"><img src="../imgs/RNS_white.png" width="30px" height="30px"><span style="color: whitesmoke;"> RNS</span></span> 
            <!--<i class="fa fa-home"></i>-->
        </a>

        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" a href="product.php"><i class="fa fa-archive"></i> Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.php"><i class="fa fa-cubes"></i> Collections</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="aboutUs.php"><i class="fa fa-building"></i> About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contactUs.php"><i class="fa fa-fw fa-envelope"></i> Contact Us</a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link notification" href="pendingDelivery.php"><i class="fas fa-shipping-fast"></i> Pending Delivery <span class="badge badge-pill badge-danger"></span></a>
            </li>   -->
             <!-- <li class="nav-item">
                <a class="nav-link notification" href="orders.php"><i class="fas fa-shopping-bag"></i> Orders History <span class="badge badge-pill badge-danger"></span></a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Log out</a>
            </li>





        </ul>
    </div>
</nav>

