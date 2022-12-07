<?php 

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
    $fullName = $userInfo['fullName'];
    //$picture = '<i class="fa fa-user"></i>';
    $picture = '<img class="rounded-circle" src="../Images/'. $userInfo['picture'] .'" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    // $picture = '<img class="rounded-circle" src="../Images/whiteProfile.png" alt="" width="25px" height="25px" style="margin-bottom: 3px;">';
    $role = $userInfo['role'];
} else {
    header("Location: ../index.php");
    exit();
}

function getProfilePicture($name) {
    $name_slice = explode(' ', $name);
    $name_slice = array_filter($name_slice);
    $initials = '';
    $initials .= (isset($name_slice[0][0]))?strtoupper($name_slice[0][0]):'';
    //$initials .= (isset($name_slice[count($name_slice)-1][0]))?strtoupper($name_slice[count($name_slice)-1][0]):'';
    return '<div class="profile-pic">'. $initials .'</div>';
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">
<div class="sidebar close">
    <div class="logo-details">
        <a href="main.php?dashboard" style="text-decoration: none; color: white;"><img src="../Images/RNS_white.png" width="30px" height="30px" class="ml-4" onclick="main.php?dashboard"></a>
        <span class="logo_name"><a href="main.php?dashboard" style="text-decoration: none; color: white;">R&S Service</a></span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="main.php?dashboard"><i class='bx bx-grid-alt' ></i><span class="link_name">Dashboard</span></a>
            <ul class="sub-menu">
                <li><a class="link_name" href="main.php?dashboard">Dashboard</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="main.php?categories"><i class='bx bx-collection' ></i><span class="link_name">Category</span></a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="main.php?categories">Category</a></li>
                <li><a href="main.php?add-category">Add Category</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="main.php?view-product"><i class='bx bx-package' ></i><span class="link_name">Products</span></a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="main.php?view-product">Product</a></li>
                <li><a href="main.php?add-product">Add Product</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="main.php?view-rental"><i class='bx bxs-layer-plus'></i><span class="link_name">Rental</span></a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="main.php?view-rental">Rental</a></li>
                <!-- <li><a href="main.php?add-product">Add Product</a></li> -->
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#"><i class='bx bxs-user-account'></i><span class="link_name" style="font-size: 16px;">User Accounts</span></a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">User Accounts</a></li>
                <li><a href="main.php?subscribe">Subscribers</a></li>
            </ul>
        </li>
        <li>
            <a href="main.php?donate"><i class='bx bx-donate-heart' ></i><span class="link_name">Donation</span></a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="main.php?donate">Donation</a></li>
            </ul>
        </li>
        
        <li>
            <div class="profile-details">
                <a href="../User/userProfile.php">
                    <div class="profile-content">
                        <?php echo $picture; ?>
                    </div>
                    <div class="name-job">
                        <div class="profile_name"><?php echo $fullName; ?></div>
                        <div class="job"><?php echo $role; ?></div>
                    </div>
                </a>
                <a href="../logout.php"><i class='bx bx-log-out'></i></a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../User/main.php">Customer</a></li>
                    <li><a class="link_name" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </li>
        <!--
        <li>
        <div class="iocn-link">
        <a href="#">
        <i class='bx bx-plug' ></i>
        <span class="link_name">Plugins</span>
        </a>
        <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
        <li><a class="link_name" href="#">Plugins</a></li>
        <li><a href="#">UI Face</a></li>
        <li><a href="#">Pigments</a></li>
        <li><a href="#">Box Icons</a></li>
        </ul>
        </li>
        <li>
        <a href="#">
        <i class='bx bx-compass' ></i>
        <span class="link_name">Explore</span>
        </a>
        <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Explore</a></li>
        </ul>
        </li>
        <li>
        <a href="#">
        <i class='bx bx-history'></i>
        <span class="link_name">History</span>
        </a>
        <ul class="sub-menu blank">
        <li><a class="link_name" href="#">History</a></li>
        </ul>
        </li>
        <li>
        <a href="#">
        <i class='bx bx-cog' ></i>
        <span class="link_name">Setting</span>
        </a>
        <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Setting</a></li>
        </ul>
        </li>
        <li>
        <div class="profile-details">
        <div class="profile-content">
        <img src="image/profile.jpg" alt="profileImg">
        </div>
        <div class="name-job">
        <div class="profile_name">Prem Shahi</div>
        <div class="job">Web Desginer</div>
        </div>
        <i class='bx bx-log-out' ></i>
        </div>
        </li>-->
    </ul>
</div>