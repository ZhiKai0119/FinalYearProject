<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Coming Soon</title>
        
        <style>
            .main{
                background-position: center center;
                background-size: cover;
                background-repeat: no-repeat;
                overflow: hidden;
                height: auto;
                left: 0;
                min-height: 500px;
                min-width: 100%;
                position: relative;
                top: 0;
                width: auto;
            }
            
            .main .logo{
                color: #FFFFFF;
                font-size: 56px;
                font-weight: 300;
                position: relative;
                text-align: center;
                text-shadow: 0 0 10px rgba(0, 0, 0, 0.33);
                margin-top: 100px;
                z-index: 3;
            }
            .main .logo.cursive{
                font-family: 'Grand Hotel',cursive;
                font-size: 82px;

            }
            .main .motto, .main .subscribe .info-text{
                font-size: 28px;
                color: #FFFFFF;
                text-shadow: 0 1px 4px rgba(0, 0, 0, 0.33);
                text-align: center;
                margin-top: 50px;

            }
            .main .subscribe .info-text{
                font-size: 18px;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <?php include './Partials/nav.php';?>
        <div class="main" style="background-image: url(../Images/comingsoon.jpg); background-color: rgba(0,0,0,.6);">
            <div class="cover black" data-color="black"></div>
            <div class="container">
                <h1 class="logo cursive">Coming Soon</h1>
            </div>
            <div class="content">
                <h4 class="motto">This page still developing!</h4>
                <div class="subscribe">
                    <h5 class="info-text">Join the waiting list for beta by subscribing us. We keep you posted.</h5>
                </div>
            </div>
        </div>
        <?php include './Partials/footer.php'; ?>
        <?php include './Partials/chatbot.php'; ?>
    </body>
    
</html>
