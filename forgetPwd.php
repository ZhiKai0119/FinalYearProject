<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R&S Service - Forget Password</title>
        <link rel="stylesheet" href="CSS/login.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#request").click(function () {
                    fgtEmail = $("#femail").val();

                    $.ajax({
                        type: "POST",
                        url: "./process/forgetPassword.php",
                        data: "fgtEmail=" + fgtEmail,
                        success: function (html) {
                            if(html === 'true') {
                                $("#add_info").html('<div class="alert alert-success"><strong>Success</strong> Please check your email.</div>');
                                // window.open("http://localhost/FinalYearProject/thankyou.php#", "_self");
                            } else if (html === 'false') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Email send unsuccessful.</div>');
                            } else if (html === 'invalid') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Error!</strong> Please provide a valid email address.</div>');
                            } else if (html === 'eshort') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> is required.</div>');
                            } else if (html === 'eformat') {
                                $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> format is not valid.</div>');
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
        <div class="container h-100 p-3 border align-items-center justify-content-center col-lg-6 bg-light">
            <form role="form" class="col-12">
                <h3>Forget Password</h3>
                <p>Please insert your email in order to reset your password.</p>
                <div id="add_info"></div>
                <div class="form-group">
                    <label for="femail" class="col-form-label">Email:</label>
                    <input type="email" class="form-control" id="femail">
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-primary" id="request">Request New Password</button>
                </div>
                <a href="index.php" target="_self" style="font-size: 12px"> < Back</a>
            </form>
        </div>
    </body>
</html>
