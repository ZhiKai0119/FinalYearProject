<?php
require_once './config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R&S Service - Registration</title>
    <!-- <link rel="stylesheet" href="CSS/login.css"> -->
    <link rel="stylesheet" href="./CSS/bootstrap-5.0.2/dist/css/bootstrap.min.css">
    <script src="./CSS/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <style>
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
    </style>
</head>
<body class="bg-secondary">
    <div class="container rounded border d-flex align-items-center justify-content-center mt-3 mb-3 col-md-8 bg-light">
        <form class="col-md-12 row g-2" action="" id="formRegistration">
            <h3 class="text-dark pt-3">Registration Details</h3><hr>
            <div class="row">
                <div class="profile mb-3 text-center">
                    <img src="./Images/user.png" id="userImg" class="rounded-circle" alt="" width="150px" height="150px" style="margin: 5px;">
                    <div class="round">
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                        <i class="fa fa-camera text-light"></i>
                    </div>
                </div>
            </div>
            <div id="register_info"></div>
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <h6 class="col-form-label">First Name</h6>
                        <div class="col-sm">
                            <input type="text" class="form-control mb-1" id="fname" name="fname" onkeyup="fillFullname()">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <h6 class="col-form-label">Last Name</h6>
                        <div class="col-sm">
                            <input type="text" class="form-control mb-1" id="lname" name="lname" onkeyup="fillFullname()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-1">
                <h6 class="col-form-label">Full Name</h6>
                <div class="col-sm">
                    <input type="text" readonly class="form-control mb-1" id="fullName" name="fullName">
                </div>
            </div>
            <div class="form-group mb-1">
                <h6 class="col-form-label">Email</h6>
                <div class="col-sm">
                    <input type="text" class="form-control mb-1" id="email" name="email">
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <h6 class="col-form-label">Password</h6>
                        <div class="col-sm">
                            <input type="password" class="form-control mb-1" id="password" name="password">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <h6 class="col-form-label">Confirmed Password</h6>
                        <div class="col-sm">
                            <input type="password" class="form-control mb-1" id="cPassword" name="cPassword">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success m-2" id="register">Submit</button>
                <hr class="hr-text mt-2" data-content="OR">
                <button onclick="window.location = '<?php echo $login_url; ?>'" type="button" class="btn btn-danger m-2">Sign Up with Google</button>
            </div>
        </form>
    </div>
    
    <script>
        function fillFullname() {
            var fname = $('#fname').val();
            var lname = $('#lname').val();

            $('#fullName').val(lname + " " + fname);
        }

        function redirect(message) {
            var date = new Date();
            date.setTime(date.getTime() + (1*1000));
            var expires = "; expires= " + date.toGMTString();

            document.cookie = "status=" + message + expires + "; path=/";
            window.location.href = "./index.php";
        }

        function errorRedirect(message) {
            var date = new Date();
            date.setTime(date.getTime() + (1*1000));
            var expires = "; expires= " + date.toGMTString();
            
            document.cookie = "failureStatus=" + message + expires + "; path=/";
            location.reload();
        }

        $(document).ready(function(e) {
            $('#register').click(function(e) {
                e.preventDefault();

                data = new FormData();
                data.append('userImg', $('#userImg').attr("src"));
                data.append('image', $('#image')[0].files[0]);
                data.append('fname', $('#fname').val());
                data.append('lname', $('#lname').val());
                data.append('fullname', $('#fullName').val());
                data.append('email', $('#email').val());
                data.append('password', $('#password').val());
                data.append('cPassword', $('#cPassword').val());

                $.ajax({
                    type: "POST",
                    url: "process/register.php",
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    success: function(html) {
                        if(html == "true") {
                            redirect("Register Successfully. Please check your email.")
                        } else if(html == "exist") {
                            $("#register_info").html('<div class="alert alert-danger"><strong>Error</strong> This email address has been registered!</div>');
                        } else if(html == "blank") {
                            $("#register_info").html('<div class="alert alert-warning"><strong>Warning</strong> All the fields must be filled up.</div>');
                        } else if(html == "nMatch") {
                            $("#register_info").html('<div class="alert alert-danger"><strong>Error</strong> Password Not Match.</div>');
                        } else if (html === 'invalid') {
                            $("#register_info").html('<div class="alert alert-danger"><strong>Error!</strong> Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</div>');
                        } else {
                            $("#register_info").html('<div class="alert alert-danger"><strong>Error!</strong> Something went wrong.</div>');
                            alert(html);
                        }
                    }
                })
            })
        })
    </script>

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