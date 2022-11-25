
<!--        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>R&S - User Setting</title>-->
<!--        <link type="text/css" rel="stylesheet" href="CSS/userSetting.css"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">        
<!--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
<!--        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">-->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->

    <style>
        .bg-common {
            background: rgba(34, 44, 51, 0.6);
        }

        .nav-link, .breadcrumb-item {
            padding: 10px 0 10px 30px;
            transition: all .2s;
            color: #bfc0cd;
        }

        .nav-link:hover, .breadcrumb-item a {
            color: #fff;
            text-decoration: none;
        }

        .card {
            box-shadow: 0 0 8px 2px rgba(250,250,250,0.1);
        }

        .card-left {
            border-radius: 5px;
        }

        .profile {
            width: 150px;
            position: relative;
            margin: auto;
        }

        .profile .round {
            position: absolute;
            background: #bfc0cd;
            right: 0;
            bottom: 0;
            width: 32px;
            height: 32px;
            line-height: 33px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .profile .round input[type="file"] {
            position: absolute;
            transform: scale(3);
            opacity: 0;
        }

        input[type="file"]::-webkit-file-upload-button {
            cursor: pointer;
        }

        /* .form-switch {
            display: flex;
            flex-direction: row-reverse;
        }

        .form-switch label {
            padding: 0;
            margin-right: 50% !important;
        } */
    </style>
<!--    </head>-->

<body class="bg-secondary">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">

                <nav aria-label="breadcrumb" class="mb-3">
                  <ol class="breadcrumb bg-dark">
                    <li class="breadcrumb-item"><a href="main.php">Home</a></li>
<!--                        <li class="breadcrumb-item"><a href="#">User</a></li>-->
                    <li class="breadcrumb-item active" aria-current="page">Profile Setting</li>
                  </ol>
                </nav>

                <div class="row">
                    <div class="col-lg-3 col-md-4 d-md-block">
                        <div class="card bg-dark card-left">
                            <div class="card-body">
                                <nav class="nav d-md-block d-none">
                                    <a data-toggle='tab' class="nav-link active" href="#profile"><i class="fas fa-user mr-1"></i> Profile</a>
                                    <a data-toggle='tab' class="nav-link" href="#account"><i class="fas fa-user-cog mr-1"></i> Account Setting</a>
                                    <a data-toggle='tab' class="nav-link" href="#security"><i class="fas fa-user-shield mr-1"></i> Security</a>
                                    <a data-toggle='tab' class="nav-link" href="#address"><i class="fas fa-map mr-1"></i> Address</a>
                                    <a data-toggle='tab' class="nav-link" href="#notification"><i class="fas fa-bell mr-1"></i> Notification</a>
                                    <a data-toggle='tab' class="nav-link" href="#billing"><i class="fas fa-money-check-alt mr-1"></i> Billing</a>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!--Right side div starts-->
                    <div class="col-lg-9 col-md-8 mb-3">
                        <div class="card">
                            <div class="card-header border-bottom mb-3 d-md-none">
                                <ul class="nav nav-tabs card-header-tabs nav-fill">
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link active" href="#profile"><i class="fas fa-user mr-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link" href="#account"><i class="fas fa-user-cog mr-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link" href="#security"><i class="fas fa-user-shield mr-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link" href="#address"><i class="fas fa-map mr-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link" href="#notification"><i class="fas fa-bell mr-1"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a data-toggle='tab' class="nav-link" href="#billing"><i class="fas fa-money-check-alt mr-1"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body tab-content border-0">

                                <!--user profile-->
                                <div class="tab-pane active" id="profile">
                                    <h6>YOUR PROFILE INFORMATION</h6>
                                    <hr>
                                    <form class="form" id="piForm" action="../process/user.php" enctype="multipart/form-data" method="POST">
                                        <div class="profile mb-3 text-center">
                                            <img src="../Images/<?php echo $userInfo['picture']; ?>" class="rounded-circle" alt="" width="150px" height="150px" style="margin: 5px;">
                                            <div class="round">
                                                <input type="hidden" name="name" value="<?php echo $userInfo['lname']; ?>">
                                                <input type="hidden" name="email" value="<?php echo $userInfo['email']; ?>">
                                                <input type="hidden" name="old_image" value="<?php echo $userInfo['picture'];?>">
                                                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                                                <i class="fa fa-camera text-light"></i>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <form class="form" id="updateForm" action="../process/user.php" method="POST">
                                        <input type="hidden" name="email" value="<?php echo $userInfo['email']; ?>">
                                        <div class="mb-3">
                                            <label for="fullName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo $userInfo['fullName']; ?>" readonly>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="fname" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $userInfo['fname']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lname" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $userInfo['lname']; ?>">
                                            </div>    
                                        </div>

<!--                                            <div class="mb-3">
                                            <label for="bio" class="form-label">Your Bio</label>
                                            <textarea class="form-control" id="bio" rows="3" placeholder="I am a full stack developer."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="url" class="form-label">URL</label>
                                            <input type="text" class="form-control" id="url" placeholder="https://www.w3school.com">
                                        </div>-->

                                        <div class="form-group form-text text-muted small">
                                            All of the fields on this page are optional and can be deleted at any time,
                                            and by filling them out, you're giving us consent to share this data wherever your user profile appears.
                                        </div>
                                        <br>
                                        <button class="btn btn-outline-info" type="submit" name="updateProfile">Update Profile</button>
                                        <button class="btn btn-outline-info" type="reset">Reset Changes</button>
                                    </form>
                                </div>

                                <!--account data-->
                                <div class="tab-pane" id="account">
                                    <h6>ACCOUNT SETTINGS</h6>
                                    <hr>
                                    <form>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="username" placeholder="abc@gmail.com" value="<?php echo $userInfo['email']; ?>" readonly>
                                            <small class="form-text text-muted">After changing your email, your old username becomes available for anyone else to claim.</small>
                                        </div>
                                    </form>

                                    <hr>
                                    <form action="">
                                        <div class="mb-3">
                                            <label class="form-label text-danger">Delete Account</label>
                                            <p class="text-muted">Once you delete your account, there is no going back. Please be certain.</p>
                                        </div>
                                        <br>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete">Delete Profile</button>
                                    </form>
                                </div>

                                <!--security data-->
                                <div class="tab-pane" id="security">
                                    <h6>SECURITY SETTINGS</h6>
                                    <hr>
                                    <form role="form" id="pwdForm" action="../process/user.php" method="POST">
                                        <div id="add_info"></div>
                                        <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Change Password</label>
                                            <input type="password" class="form-control mb-2" id="oldPassword" name="oldPassword" placeholder="Your current password">
                                            <input type="password" class="form-control mb-2" id="newPassword1" name="newPassword1" placeholder="Your new password">
                                            <input type="password" class="form-control" id="newPassword2" name="newPassword2" placeholder="Your new password">
                                        </div>
                                        <button class="btn btn-success" type="button" name="updatePwd" id="changePwd">Change</button>
                                    </form>
                                    <hr>
                                    <form>
                                        <div class="form-group">
                                            <label class="d-block mb-2">Two Factor Authentication</label>
                                            <button class="btn btn-outline-info" type="submit">Enable two-factor authentication</button>
                                            <p class="text-muted small">Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.</p>
                                        </div>
                                    </form>
                                    <hr>
                                    <form>
                                        <div class="form-group">
                                            <label class="d-block mb-2">Sessions</label>
                                            <p class="text-muted small">This is a list of devices that have logged into your account. Revoke any sessions that you not recognize.</p>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div>
                                                        <h6>Pokhara 28.2096. N, 83.9856. E</h6>
                                                        <small class="text-muted">Your current session seen in Nepal.</small>
                                                    </div>
                                                    <button class="btn btn-light btn-sm ml-auto" type="button">More Info</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>

                                <!--notification data-->
                                <div class="tab-pane" id="notification">
                                    <h6>NOTIFICATION SETTINGS</h6>
                                    <hr>
                                    <form>
                                        <div class="mb-3">
                                            <label for="securityAlert" class="form-label d-block">Security Alerts</label>
                                            <small class="form-text text-muted">Receive security alert notifications via email.</small>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="vulnerability">
                                                <label class="form-check-label" for="vulnerability">Email each time a vulnerability is found.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="summaryVulnerability">
                                                <label class="form-check-label" for="summaryVulnerability">Email a digest summary vulnerability.</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="d-block mb-3">SMS Notifications</label>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    Comments
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="comments" checked>
                                                        <label class="form-check-label" for="comments"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    Updates From People 
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="updates" checked>
                                                        <label class="form-check-label" for="updates"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    Reminders 
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="reminders" checked>
                                                        <label class="form-check-label" for="reminders"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    Events
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="events" checked>
                                                        <label class="form-check-label" for="events"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    Pages You Follow
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="follow" checked>
                                                        <label class="form-check-label" for="follow"></label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>

                                <!--billing data-->
                                <div class="tab-pane" id="billing">
                                    <h6>BILLING SETTINGS</h6>
                                    <hr>
                                    <form action="../process/user.php" method="POST">
                                        <div class="mb-3">
                                            <label class="d-block">Payment Methods</label>
                                            <?php
                                                function ccMasking($number, $maskingCharacter = '*') {
                                                    return str_repeat($maskingCharacter, strlen($number) - 4) . substr($number, -4);
                                                }
                                                $email = $userInfo['email'];
                                                $paymentMethod = $conn->query("SELECT * FROM paymentmethod WHERE email = '$email'");
                                                if(mysqli_num_rows($paymentMethod) > 0) { ?>
                                                    <ul class="list-group">
                                                    <?php foreach ($paymentMethod as $method) { ?>
                                                        <li class="list-group-item">
                                                            <?php echo ccMasking($method['cardNo']).' [' .$method['type']. ']';?>
                                                            <input type="hidden" name="methodId" value="<?php echo $method['methodId'];?>">
                                                            <button type="submit" class="btn btn-danger" name="delete_payment_method" style="float: right;">Delete</button>
                                                        </li>
                                                    <?php } ?>
                                                    </ul>
                                                <?php } else { ?>
                                                    <small class="text-muted small">You have not added a payment method.</small>
                                            <?php }?>
                                            <br>
                                            <button type="button" class="btn btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#addPay">Add Payment Method</button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="d-block">Payment History</label>
                                            <div class="border p-3 text-center">
                                                You have not made any payment.
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Address data -->
                                <div class="tab-pane" id="address">
                                    <h6>ADDRESS SETTINGS</h6>
                                    <hr>
                                    <form action="../process/user.php" method="POST">
                                        <div class="mb-3">
                                            <label class="d-block">Address</label>
                                            <?php 
                                            $email = $userInfo['email'];
                                            $addresses = $conn->query("SELECT * FROM address WHERE email = '$email'"); ?>
                                            
                                            <?php if(mysqli_num_rows($addresses) > 0) { ?>
                                                <ul class="list-group" id="add">
                                                <?php foreach($addresses as $address) { ?>
                                                    <li class="list-group-item editAddId" value="<?php echo $address['addId']; ?>">
                                                        <input type="hidden" name="addId" id="addId" value="<?php echo $address['addId'];?>">
                                                        <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#editAddress<?php echo $address['addId']; ?>" style="text-decoration: none;"> -->
                                                            <label><?php echo $address['fullName']. ' | ' .$address['phoneNo']; ?></label><br>
                                                            <label><?php echo $address['detailAdd'].', '.$address['postalCode'].', '.$address['stateCity'].'.' ?></label><br>
                                                            <?php if($address['defaultAdd'] == 1) { ?>
                                                                <div class="d-inline p-1 mb-2 mr-2 border border-danger text-danger"><?php echo $address['defaultAdd']? "Default":""; ?></div>
                                                            <?php }
                                                            if($address['pickupAdd'] == 1) { ?>
                                                                <div class="d-inline p-1 mb-2 mr-2 border border-dark text-muted"><?php echo $address['pickupAdd']? "Pickup Address":""; ?></div>
                                                            <?php } 
                                                            if($address['returnAdd'] == 1) { ?>
                                                                <div class="d-inline p-1 mb-2 mr-2 border border-dark text-muted"><?php echo $address['returnAdd']? "Return Address":""; ?></div>
                                                            <?php } ?>
                                                        <!-- </a> -->
                                                    </li>
                                                <?php } ?>
                                                </ul>
                                            <?php } else { ?>
                                                <small class="text-muted small">You have not added a shipping address.</small>
                                            <?php } ?>
                                            
                                            <br>
                                            <button type="button" class="btn btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#addAddress">Add Address</button>
                                        </div>                
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE Modal -->
    <div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirmed Delete Account?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" action="../process/user.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="email" value="<?php echo $userInfo['email'];?>">
                        Once you delete your account (<u><?php echo $userInfo['email'];?></u>), there is no going back. Please be certain.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="deleteProfile" class="btn btn-danger">Yes! Delete</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <!-- ADD PAYMENT METHODS Modal -->
    <div class="modal fade" id="addPay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header text-white-50 bg-dark">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment Method</h5> <hr>
                    <img src="https://img.icons8.com/color/36/000000/visa.png">
                    <img src="https://img.icons8.com/color/36/000000/mastercard.png">
                    <img src="https://img.icons8.com/color/36/000000/amex.png">
                    <button type="button" class="btn-close text-muted" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPayForm" action="../process/user.php" method="POST">
                    <div class="modal-body">
                        <div id="payment_info"></div>
                        <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email'];?>">
                        <div class="mb-3">
                            <label for="cardholderName" class="col-form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardholderName" name="cardholderName">
                        </div>
                        <div class="mb-3">
                            <label for="card" class="form-label">Card Number</label>
                            <input type="text" class="form-control inputtxt" id="cardNo" name="cardNo" data-mask="0000000000000000"  placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;">
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="expMth" class="form-label exptxt">Expiry Month</label>
                                <input type="text" class="form-control expiry" id="expMth" name="expMth" data-mask="00" placeholder="&bull;&bull;">  
                            </div>
                            <div class="col-sm-4">
                                <label for="expYear" class="form-label exptxt">Expiry Year</label>
                                <input type="text" class="form-control expiry" id="expYear" name="expYear" data-mask="0000" placeholder="&bull;&bull;&bull;&bull;"> 
                            </div>
                            <div class="col-sm-4">
                                <label for="cvv" class="form-label cvvtxt">CVV/CVC</label>
                                <input type="number" class="form-control cvv" id="cvv" name="cvv" autocomplete="cvv" data-mask="000" placeholder="&bull;&bull;&bull;">
                            </div>    
                        </div>
                    </div>
                    <div class="modal-footer text-white-50 bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="addPayMethod" id="addPayMethod" class="btn btn-primary">Add Payment Method</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <!-- ADD ADDRESS Modal -->
    <div class="modal fade" id="addAddress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header text-white-50 bg-dark">
                    <h5 class="modal-title" id="staticBackdropLabel">New Address</h5> <hr>
                    <button type="button" class="btn-close text-muted" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addAddForm" action="../process/user.php" method="POST">
                    <div class="modal-body">
                        <div id="address_info"></div>
                        <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email'];?>">
                        <div class="mb-3">
                            <label for="fullname" class="col-form-label">Contact</label>
                            <input type="text" class="form-control mb-1" id="fullname" name="fullname" placeholder="Full Name">
                            <input type="tel" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone Number">
                        </div>
                        <div class="mb-3">
                            <label for="stateCity" class="form-label">Address</label>
                            <input type="text" class="form-control mb-1" id="stateCity" name="stateCity"  placeholder="City, State">
                            <input type="tel" class="form-control mb-1" id="postalCode" name="postalCode"  placeholder="Postal Code">
                            <input type="text" class="form-control mb-1" id="detailAdd" name="detailAdd"  placeholder="Detailed Address">
                        </div>

                        <div class="mb-3">
                            <label for="labelAs" class="form-label">Settings</label>
                            <div class="row mr-1">
                                <div class="col-sm-8">
                                    <label for="labelAs" class="form-label align-middle">Label As:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="radio" class="btn-check" name="labelAs" id="home" value="Home" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="home">Home</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="radio" class="btn-check" name="labelAs" id="work" value="Work" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="work">Work</label>
                                </div>
                            </div>
                            
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="defaultAdd" value="yes" checked>
                                        <label class="form-check-label" for="defaultAdd">Set as Default Address</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pickupAdd" value="yes">
                                        <label class="form-check-label" for="pickupAdd">Set as Pickup Address</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="returnAdd" value="yes">
                                        <label class="form-check-label" for="returnAdd">Set as Return Address</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer text-white-50 bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="btnaddAddress" id="btnaddAddress" class="btn btn-primary">Add Address</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <!-- EDIT ADDRESS Modal -->
    <div class="modal fade" id="editAddress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header text-white-50 bg-dark">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Address</h5> <hr>
                    <button type="button" class="btn-close text-muted" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAddForm" action="../process/user.php" method="POST">
                    <div class="modal-body">
                        <div id="address_info"></div>
                        <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email'];?>">
                        <input type="text" class="form-control" id="eId" name="eId">

                        <div class="mb-3">
                            <label for="efullname" class="col-form-label">Contact</label>
                            <input type="text" class="form-control mb-1" id="efullname" name="fullname" placeholder="Full Name">
                            <input type="tel" class="form-control" id="ephoneNo" name="phoneNo" placeholder="Phone Number">
                        </div>
                        <div class="mb-3">
                            <label for="stateCity" class="form-label">Address</label>
                            <input type="text" class="form-control mb-1" id="estateCity" name="stateCity"  placeholder="City, State">
                            <input type="tel" class="form-control mb-1" id="epostalCode" name="postalCode"  placeholder="Postal Code">
                            <input type="text" class="form-control mb-1" id="edetailAdd" name="detailAdd"  placeholder="Detailed Address">
                        </div>

                        <div class="mb-3">
                            <label for="labelAs" class="form-label">Settings</label><br>
                            <label for="labelAs" class="form-label align-middle">Label As:</label>
                            <input type="radio" name="labelAs" id="ehome" value="Home">
                            <label for="home">Home</label>
                            <input type="radio" name="labelAs" id="ework" value="Work">
                            <label for="work">Work</label>
                            
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edefaultAdd" value="yes">
                                        <label class="form-check-label" for="edefaultAdd">Set as Default Address</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="epickupAdd" value="yes">
                                        <label class="form-check-label" for="epickupAdd">Set as Pickup Address</label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="ereturnAdd" value="yes">
                                        <label class="form-check-label" for="ereturnAdd">Set as Return Address</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer text-white-50 bg-dark">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" name="delete_address" style="float: right;">Delete</button>
                        <button type="button" name="btnUpdateAddress" id="btnUpdateAddress" class="btn btn-primary">Update Address</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function redirect(message) {
        var date = new Date();
        date.setTime(date.getTime() + (1*1000));
        var expires = "; expires= " + date.toGMTString();

        document.cookie = "status=" + message + expires + "; path=/";
        location.reload();
    }

    //FOR IMAGE
    document.getElementById("image").onchange = function() {
        document.getElementById("piForm").submit();
    }

    //FOR CHANGE PASSWORD
    $(document).ready(function () {
        $("#changePwd").click(function () {
            email = $("#email").val();
            oldPassword = $("#oldPassword").val();
            newPassword1 = $("#newPassword1").val();
            newPassword2 = $("#newPassword2").val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "email=" + email + "&oldPassword=" + oldPassword + "&newPassword1=" + newPassword1 + "&newPassword2=" + newPassword2,
                success: function (html) {
                    if(html === 'true') {
                        $("#add_info").html('<div class="alert alert-success"><strong>Success</strong> Your Password has been changed.</div>');
                        document.getElementById('pwdForm').reset();
                    } else if(html === 'false') {
                        $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Password reset unsuccessful.</div>');
                    } else if(html === 'nSame') {
                        $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Old Password Not Match.</div>');
                    } else if(html === 'noPwd') {
                        $("#add_info").html('<div class="alert alert-warning"><strong>Warning</strong> Password Set a New Password For Your Account.</div>');
                    } else if (html === 'invalid') {
                        $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</div>');
                    } else if (html === 'nMatch') {
                        $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> New Password and Comfirm New Password do not match.</div>');
                    } else {
                        $("#add_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                        alert(html);
                    }
                },
                beforeSend: function() {
                    $("#add_info").html('loading...');
                }
            });
            return false;
        });
    });
    
    //FOR ADD PAYMENT METHODS
    $(document).ready(function () {
        $('#addPayMethod').click(function () {
            email = $("#email").val();
            cardholderName = $("#cardholderName").val();
            cardNo = $("#cardNo").val();
            expMth = $("#expMth").val();
            expYear = $("#expYear").val();
            cvv = $("#cvv").val();
            
            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "email=" + email + "&cardholderName=" + cardholderName + "&cardNo=" + cardNo + "&expMth=" + expMth + "&expYear=" + expYear + "&cvv=" + cvv,
                success: function (html) {
                    if(html === 'true') {
                        $("#payment_info").html('<div class="alert alert-success"><strong>Success</strong> New Payment Method has been added.</div>');
                        document.getElementById('addPayForm').reset();
                        window.location.href=window.location.href;
                    } else if(html === 'false') {
                        $("#payment_info").html('<div class="alert alert-danger"><strong>Error!</strong> New payment added unsuccessful.</div>');
                    } else if(html === 'short') {
                        $("#payment_info").html('<div class="alert alert-warning"><strong>Warning</strong> Please check your inserted data. Not enough character.</div>');
                    } else if(html === 'invalid') {
                        $("#payment_info").html('<div class="alert alert-warning"><strong>Warning</strong> Invalid Credit/Debit Card Number.</div>');
                    } else if(html === 'expired') {
                        $("#payment_info").html('<div class="alert alert-warning"><strong>Warning</strong> Your Credit/Debit Card has been expired.</div>');
                    } else if(html === 'exist') {
                        $("#payment_info").html('<div class="alert alert-warning"><strong>Warning</strong> The Credit/Debit Card has been added.</div>');
                        document.getElementById('addPayForm').reset();
                    } else {
                        $("#payment_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                        alert(html);
                    }
                },
                beforeSend: function() {
                    $("#payment_info").html('loading...');
                }
            });
            return false;
        });
    });

    //FOR ADD ADDRESS
    $(document).ready(function () {
        $('#btnaddAddress').click(function () {
            email = $("#email").val();
            fullname = $("#fullname").val();
            phoneNo = $("#phoneNo").val();
            stateCity = $("#stateCity").val();
            postalCode = $("#postalCode").val();
            detailAdd = $("#detailAdd").val();
            labelAs = $("input[name='labelAs']:checked").val();
            defaultAdd = $("#defaultAdd:Checked").val();
            pickupAdd = $("#pickupAdd:Checked").val();
            returnAdd = $("#returnAdd:Checked").val();
            
            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "addAddress" + "&email=" + email + "&fullname=" + fullname + "&phoneNo=" + phoneNo + "&stateCity=" + stateCity + "&postalCode=" + postalCode + "&detailAdd=" + detailAdd + "&labelAs=" + labelAs + 
                "&defaultAdd=" + defaultAdd + "&pickupAdd=" + pickupAdd + "&returnAdd=" + returnAdd,
                success: function (html) {
                    // if(html === 'true') {
                    //     redirect("New Address Added Successfully");
                    // } else if(html === 'false') {
                    //     $("#address_info").html('<div class="alert alert-danger"><strong>Error!</strong> New Address added unsuccessful.</div>');
                    // } else {
                    //     $("#address_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                    //     alert(html);
                    // }
                },
                beforeSend: function() {
                    $("#address_info").html('loading...');
                }
            });
            return false;
        });
    });

    //FOR EDIT ADDRESS   //TODO: Verification
    $(document).ready(function () {
        $('.editAddId').click(function () {
            var id = $(this).attr("value");
            
            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "id=" + id,
                success: function (html) {
                    obj = JSON.parse(html);
                    $('#editAddress').modal('show');
                    $('#eId').val(obj.addId);
                    $('#efullname').val(obj.fullName);
                    $('#ephoneNo').val(obj.phoneNo);
                    $('#estateCity').val(obj.stateCity);
                    $('#epostalCode').val(obj.postalCode);
                    $('#edetailAdd').val(obj.detailAdd);
                    if(obj.labelAs == 'Home') {
                        document.getElementById('ehome').checked = true;
                    } else {
                        document.getElementById('ework').checked = true;
                    }

                    if(obj.defaultAdd == 1) {
                        document.getElementById('edefaultAdd').checked = true;
                    } else {
                        document.getElementById('edefaultAdd').checked = false;
                    }

                    if(obj.pickupAdd == 1) {
                        document.getElementById('epickupAdd').checked = true;
                    } else {
                        document.getElementById('epickupAdd').checked = false;
                    }

                    if(obj.returnAdd == 1) {
                        document.getElementById('ereturnAdd').checked = true;
                    } else {
                        document.getElementById('ereturnAdd').checked = false;
                    }
                    // alert(html);
                }
            });
            return false;
        });
    });

    $(document).ready(function () {
        $('#btnUpdateAddress').click(function () {
            addId = $("#eId").val();
            fullName = $('#efullname').val();
            phoneNo = $('#ephoneNo').val();
            stateCity = $('#estateCity').val();
            postalCode = $('#epostalCode').val();
            detailAdd = $('#edetailAdd').val();
            labelAs = $("input[name='labelAs']:checked").val();
            defaultAdd = $("#edefaultAdd:Checked").val();
            pickupAdd = $("#epickupAdd:Checked").val();
            returnAdd = $("#ereturnAdd:Checked").val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "updateAddress" + "&addId=" + addId + "&fullName=" + fullName + "&phoneNo=" + phoneNo + "&stateCity=" + stateCity + "&postalCode=" + postalCode + "&detailAdd=" + detailAdd + "&labelAs=" + labelAs + 
                "&defaultAdd=" + defaultAdd + "&pickupAdd=" + pickupAdd + "&returnAdd=" + returnAdd,
                success: function (html) {
                    if(html === 'true') {
                        // $("#address_info").html('<div class="alert alert-success"><strong>Success</strong> Address has been updated.</div>');
                        // location.reload();
                        redirect("Address Update Successfully");
                    } else if(html === 'false') {
                        $("#address_info").html('<div class="alert alert-danger"><strong>Error!</strong> New Address added unsuccessful.</div>');
                    } else {
                        $("#address_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                        alert(html);
                    }
                },
                beforeSend: function() {
                    $("#address_info").html('loading...');
                }
            });
            return false;
        });
    });

    //FIXME: Notification
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>