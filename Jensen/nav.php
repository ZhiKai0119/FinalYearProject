<?php 
include './config/constant.php'; 

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
    $fullName = $userInfo['fullName'];
    $picture = '<img class="rounded-circle" src="../Images/'. $userInfo['picture'] .'" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    
    $dropItem1 = '<a class="dropdown-item" href="./userProfile.php">Profile</a>';
    $dropItem2 = '<a class="dropdown-item" href="../logout.php">Logout</a>';

    $count_cart = $conn->query("SELECT * FROM cart WHERE email = '$email' AND status = 'Pending'");
    if(mysqli_num_rows($count_cart) > 0) {
        $rows = mysqli_num_rows($count_cart);
    } else {
        $rows = "";
    }
} else {
    $fullName = "Profile";
    $picture = '<i class="fa fa-user-circle"></i>';
    //$picture = '<img class="rounded-circle" src="../Images/profile.png" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    $dropItem1 = '<a class="dropdown-item" href="../index.php">Login</a>';
    $dropItem2 = '<a class="dropdown-item" href="../registration.php">Sign Up</a>';
    $rows = "";
    $fine = "";
}
?>

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
        <a class="navbar-brand" href="home.php">
            <span class="navbar-text"><img src="./imgs/RNS_white.png" width="30px" height="30px"><span style="color: whitesmoke;"> RNS</span></span> 
        </a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" a href="product_list.php"><i class="fa fa-archive"></i> Products</a>
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
                <a class="nav-link notification" href="pendingDelivery.php"><i class="fa fa-shipping-fast"></i> Pending Delivery</a>
            </li>   -->
             <li class="nav-item">
                <a class="nav-link notification" href="order_history.php"><i class="fa fa-shopping-bag"></i> Orders History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shopping_cart.php"><i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-pill badge-danger"><?php echo $rows; ?></span></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="dropdown_target" href="#" aria-haspopup="true" data-display="static">
                    <?php echo $fullName ?> <?php echo $picture; ?>
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-light" aria-labelledby="dropdown_target">
                    <a class="dropdown-item" href="../Owner/main.php?dashboard" target="_self">Admin</a>
                    <a class="dropdown-item" href="../User/main.php" target="_self">Rental</a>
                    <?php echo $dropItem1; ?>
                    <?php echo $dropItem2; ?>
                </div>
            </li>
        </ul>
    </div>
</nav>

<?php 
if(isset($_GET['admin'])) {
    $userRole = $userInfo['role'];
    if($userRole != 'Admin') {
        echo "<script>alert('You have not permission to access the admin page.');</script>";
        echo "<script>window.open('http://localhost/FinalYearProject/Jensen/home.php','_self');</script>";
    } else {
        echo "<script>window.open('http://localhost/FinalYearProject/Owner/main.php?dashboard','_self');</script>";
    }
}
?>

<!--Alertify Js-->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    alertify.set('notifier','position', 'top-right');
    <?php if(isset($_COOKIE['status'])) { ?>
        alertify.success('<?php echo $_COOKIE['status']; ?>'); 
    <?php } elseif(isset($_COOKIE['failureStatus'])) { ?>
        alertify.error('<?php echo $_COOKIE['failureStatus']; ?>'); 
    <?php } ?>
</script>