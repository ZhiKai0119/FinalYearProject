<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>RNS Service - User Profile</title>
        <!--Alertify Js-->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    </head>
    <body>
        <div class="container">
            <h1 class="display-6 text-center text-light">User Profile</h1>
        </div>
        <?php include './Partials/nav.php';?>

<!--        <div class="container h-100">
            <img src="<?php //echo $userInfo['picture']; ?>" class="rounded-circle" alt="" width="150px" height="150px" style="margin: 5px;">
            <p>Full Name: <?php //echo $userInfo['fullName']; ?></p>
            <p>First Name: <?php //echo $userInfo['fname']; ?></p>
            <p>Last Name: <?php //echo $userInfo['lname']; ?></p>
            <p>Email: <?php //echo $userInfo['email']; ?></p>
        </div>-->
        
        <?php include '../userSetting.php'?>
            
        <?php include './Partials/footer.php'; ?>
        <?php //include './Partials/chatbot.php'; ?>

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
    </body>
</html>
