<!DOCTYPE html>
<html>
    <head>
        <title>RNS Service</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--Alertify Js-->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    </head>
    <body>
        <div class="jumbotron jumbotron-fluid mb-0" style="background-image: url('../Images/bannerHead.png'); background-repeat: no-repeat; background-size: cover;">
            <div class="container">
                <div class="row">
                    <div class="col-5 d-flex justify-content-end">
                        <img src="../Images/RNS_white.png" alt="" width="100px" height="100px">
                    </div>
                    <div class="col text-light font-weight-bold">
                        <h1 class="display-4">RNS Service</h1>
                        <h6 class="lead">Rental Or Selling Your Products At Here</h6>
                    </div>
                </div>
            </div>
        </div>
        <?php include './Partials/nav.php';?>
        <?php include './process/verify.php';?>
        
<!--  auto slideshow  -->
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
                <li data-target="#carousel" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="../Images/1.png" class="d-block w-100 img-thumbnail" style="height: 60vh;" alt=""></div>
                <div class="carousel-item"><img src="../Images/2.jpg" class="d-block w-100 img-thumbnail" style="height: 60vh;" alt=""></div>
                <div class="carousel-item"><img src="../Images/3.png" class="d-block w-100 img-thumbnail" style="height: 60vh;" alt=""></div>
                <div class="carousel-item"><img src="../Images/4.jpg" class="d-block w-100 img-thumbnail" style="height: 60vh;" alt=""></div>
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <?php include './products_suggested.php';?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 bg-warning p-0">
                    <img src="../Images/banner.jpg" alt="" style="background-size: auto; background-repeat: no-repeat; border-radius: 10px;">
                </div>
                <div class="col-md-3 bg-warning">
                    <div class="banner-text text-end font-weight-bold" style="padding-top: 100px; margin-right: 50px; margin-bottom: 20px;">
                        <h2 class="font-weight-bold" style="font-size: 23px;">RENT YOUR PRODUCTS NOW</h2>
                        <h1 class="font-weight-bold" style="font-size: 25px;">PREVENT PURCHASE</h1>
                        <button class="btn btn-dark text-light" onclick="window.location.href='products.php'">SHOP NOW</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include './Partials/footer.php'; 
        include './Partials/chatbot.php';
        ?>        
    </body>
</html>
