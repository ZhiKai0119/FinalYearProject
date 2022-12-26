<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R&S Service - Reset Password</title>
        <link rel="stylesheet" href="CSS/login.css">
        <link rel="stylesheet" href="./CSS/bootstrap-4.0.0/dist/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#reset").click(function () {
                    nPwd = $("#nPwd").val();
                    comfirmPwd = $("#comfirmPwd").val();
                    email = $("#email").val();  
                    
                    $.ajax({
                        type: "POST",
                        url: "./process/resetPassword.php",
                        data: "nPwd=" + nPwd + "&comfirmPwd=" + comfirmPwd + "&email=" + email,
                        success: function (html) {
                            if(html === 'true') {
                                $("#add_info").html('<div class="alert alert-success"><strong>Success</strong> You may login now.</div>');
                                window.open("http://localhost/FinalYearProject/index.php","_self");
                            } else if (html === 'false') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Password reset unsuccessful.</div>');
                            } else if (html === 'invalid') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</div>');
                            } else if (html === 'nMatch') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> New Password and Comfirm New Password do not match.</div>');
                            } else {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                                alert(html);
                            }
                        }, 
                        beforeSend: function () {
                            $("#add_info").html('loading...');
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body class="bg-dark">
        <div class="container h-100 p-3 border align-items-center justify-content-center col-lg-6 bg-light">
            <form role="form" class="col-12">
                <h3>Reset Password</h3>
                <div id="add_info"></div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email: </label><br>
                    <input type="text" class="form-control" name="email" value="<?php echo $_GET['email'];?>" id="email" readonly="">
                </div>
                <div class="form-group">
                    <label for="nPwd" class="col-form-label">New Password:</label>
                    <input type="password" class="form-control" id="nPwd">
                </div>
                <div class="form-group">
                    <label for="comfirmPwd" class="col-form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" id="comfirmPwd">
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-primary" id="reset">Reset</button>
                </div>
            </form>
        </div>
    </body>
</html>
