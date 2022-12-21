<?php
require_once './config.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R&S Service - Login</title>
        <link rel="stylesheet" href="CSS/login.css">
        <link rel="shortcut icon" href="pic/buylogo.jpg" type="image/gif">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#loginF").click(function () {
                    inputEmail = $("#iEmail").val();
                    inputPassword = $("#iPassword").val();

                    $.ajax({
                        type: "POST",
                        url: "./process/loginAcc.php",
                        data: "inputEmail=" + inputEmail + "&inputPassword=" + inputPassword,
                        success: function (html) {
                            if(html === 'true') {
                                $("#add_info").html('<div class="alert alert-success"><strong>Logged In.</strong>.</div>');
                            } else if (html === 'false') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Invalid Email or Password.</div>');
                            } else if (html === 'invalidEmail') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> The email do not exist.</div>');
                            } else if (html === 'verify') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Account have not been verified.</div>');
                            } else if (html === 'eshort') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> is required.</div>');
                            } else if (html === 'eformat') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> format is not valid.</div>');
                            } else if (html === 'pError') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Invalid </strong> Password.</div>');
                            } else if (html === 'user') {
                                $("#add_info").html('<div class="alert alert-success"><strong>Logged In.</strong>.</div>');
                                window.open('User/main.php','_self');
                            } else if (html === 'admin') { 
                                $("#add_info").html('<div class="alert alert-success"><strong>Logged In.</strong>.</div>');
                                window.open('Owner/main.php','_self');
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
        </script>

    </head>
    <body class="bg-dark">
        <?php       
            if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {   // && isset($_SESSION['user_token'])
                $id = intval($_COOKIE['id']);
                $token = $_COOKIE['token'];
                
                $sql = "SELECT id, role FROM users WHERE id = '$id' AND token = '$token'";
                $result = mysqli_query($conn, $sql);
                $userInfo = mysqli_fetch_assoc($result);
                if(!$userInfo["id"]) {
                    echo "Error";
                } else {
                    $loginSQL = "SELECT * FROM login WHERE logoutDateTime = '0000-00-00 00:00:00'";
                    $loginResult = mysqli_query($conn, $loginSQL);
                    if($loginResult) {
                        $loginInfo = mysqli_fetch_assoc($loginResult);
                        $loginId = $loginInfo['id'];
                        $updateLogin = $conn->query("UPDATE login SET logoutDateTime = now() WHERE id = '{$loginId}'");
                    }
                    
                    if($userInfo["role"] == 'Admin') { ?>
                        <script>window.open("Owner/main.php?dashboard", "_self")</script>
                    <?php } else if($userInfo["role"] == 'Customer') {
                        header("Location:User/main.php");
                    } else {
                        header("Location:User/main.php");
                        //echo "<script>window.open('index.php','_self')</script>";
                    }
                }
            } else {
        ?>
        <div class="container h-100 p-3 border align-items-center justify-content-center col-lg-6 bg-light">
            <form role="form" class="col-12">
                <div id="add_info"></div>
                <div class="form-group">
                    <label for="inputEmail">Email Address</label>
                    <input type="email" class="form-control" id="iEmail" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" id="iPassword" placeholder="Enter Password">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary col-sm-4" id="loginF">Login</button>
                    <button type="button" class="btn btn-success col-sm-4 ml-1" onclick="location.href='registration.php'">Register</button>
                    <hr class="hr-text" data-content="OR">
                    <button onclick="window.location = '<?php echo $login_url; ?>'" type="button" class="btn btn-danger col-sm-8">Login with Google</button>
                    <br>
                    <a href="forgetPwd.php" target="_self" style="font-size: 12px">Forget Password?</a>
                </div>
            </form>           
        </div>
        <?php
            }
        ?>

        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <script>
            alertify.set('notifier','position', 'top-right');
            <?php if(isset($_COOKIE['status'])) { ?>
                alertify.success('<?php echo $_COOKIE['status']; ?>'); 
            <?php } elseif(isset($_COOKIE['failureStatus'])) { ?>
                alertify.error('<?php echo $_COOKIE['failureStatus']; ?>'); 
            <?php } ?>
        </script>
    </body>
</html>
