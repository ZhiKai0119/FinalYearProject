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
        <div class="row justify-content-end mr-3">
            <a href="comingSoon.php" class="text-decoration-none text-dark bg-light">Selling</a>
        </div>
        <div class="jumbotron jumbotron-fluid mb-0">
            <div class="container">
                <h1 class="display-4">RNS Service</h1>
                <p class="lead">Rental Or Selling Your Products At Here</p>
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
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="../Images/1.png" class="d-block w-100 img-thumbnail" style="height: 300px;" alt=""></div>
                <div class="carousel-item"><img src="../Images/2.png" class="d-block w-100 img-thumbnail" style="height: 300px;" alt=""></div>
                <div class="carousel-item"><img src="../Images/3.png" class="d-block w-100 img-thumbnail" style="height: 300px;" alt=""></div>
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
        
        //TODO: Create a banner
        <section style="background-color: #c65039;">
            <div class="container">
                <h1>Category</h1>
            </div>
        </section>

        <?php
        include './Partials/footer.php'; 
        include './Partials/chatbot.php';
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
