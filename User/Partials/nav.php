<?php 
include '../config/constant.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
    $fullName = $userInfo['fullName'];
    $picture = '<img class="rounded-circle" src="../Images/'. $userInfo['picture'] .'" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    
    $dropItem1 = '<a class="dropdown-item" href="./userProfile.php">Profile</a>';
    $dropItem2 = '<a class="dropdown-item" href="../logout.php">Logout</a>';

    $count_rent = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND confirmRent = 0 AND status = 'Pending'");
    if(mysqli_num_rows($count_rent) > 0) {
        $rows = mysqli_num_rows($count_rent);
    } else {
        $rows = "";
    }

    $pending_fine = $conn->query("SELECT * FROM fine WHERE email = '$email' AND pay_status = 'Pending'");
    if(mysqli_num_rows($pending_fine) > 0) {
        $fine = mysqli_num_rows($pending_fine);
    } else {
        $fine = "";
    }
} else {
    $fullName = "Profile";
    $picture = '<i class="fa fa-user-circle"></i>';
    //$picture = '<img class="rounded-circle" src="../Images/profile.png" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    $dropItem1 = '<a class="dropdown-item" href="../index.php">Login</a>';
    $dropItem2 = '<a class="dropdown-item" href="../registration.php">Sign Up</a>';
    $rows = "";
    $fine = "";
//    header("Location: ../index.php");
//    exit();
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
        <link rel="stylesheet" href="CSS/pagination.css"/>
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
                <a class="navbar-brand" href="main.php">
<!--                    <img src="#">-->
                    <span class="navbar-text"><img src="../Images/RNS_white.png" width="30px" height="30px"><span style="color: whitesmoke;"> RNS</span></span> 
                    <!--<i class="fa fa-home"></i>-->
                </a>

                <ul class="navbar-nav">
<!--                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="dropdown_target" href="#">
                            Dropdown
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown_target">
                            <ul class="navbar-nav">
                                <a class="dropdown-item" href="#">PHP Videos</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">CSS Videos</a>
                                <a class="dropdown-item" href="#">HTML Videos</a>
                            </ul>
                        </div>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="./products.php"><i class="fa fa-archive"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./categories.php"><i class="fa fa-cubes"></i> Collections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./wishlist.php"><i class="fa fa-heart"></i> Wishlist</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link notification" href="./pendingRental.php"><i class="fa fa-shopping-bag"></i> Rental <span class="badge badge-pill badge-danger"><?php echo $rows; ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link notification" href="./fine_list.php"><i class="fa fa-dollar"></i> Fine <span class="badge badge-pill badge-danger"><?php echo $fine; ?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./aboutUs.php"><i class="fa fa-building"></i> About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contactUs.php"><i class="fa fa-fw fa-envelope"></i> Contact Us</a>
                    </li>
                </ul>                

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="dropdown_target" href="#" aria-haspopup="true" data-display="static">
                            <?php echo $fullName ?> <?php echo $picture; ?>
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right bg-light" aria-labelledby="dropdown_target">
                            <a class="dropdown-item" href="main.php?admin" target="_self">Admin</a>
                            <a class="dropdown-item" href="../Jensen/home.php" target="_self">Selling</a>
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
        echo "<script>window.open('http://localhost/FinalYearProject/User/main.php','_self');</script>";
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
<!--    </body>-->
<!--</html>-->
