<!DOCTYPE html>

<?php
session_start();
include './nav.php';

if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - About Us</title>
        <link rel="stylesheet" href="./CSS/about.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>-->
    </head>
    <body>




        <section class="about_achievements container-fluid">
            <div class="about_achievements-container row justify-content-lg-center no-gutters mr-5">
                <div class="about_achievements-left">
                    <img src="./imgs/about_achievement.png" class="col">
                </div>
                <div class="about_achievements-right col">
                    <h1>Achievements</h1>
                    <p>RNS Service is an online platform that connects people with the best of their neighborhoods across Malaysia. 
                        This platform is allow the people to sell or rental the products. 
                        We enable local businesses to meet consumers’ needs of ease and convenience, and, in turn, generate new ways for people to earn, work, and live.
                        The below data are our achievements:
                    </p>
                    <div class="achievements_cards row">
                        <article class="achievement_card col">
                            <span class="achievement_icon material-symbols-sharp">receipt_long</span>
                            <h3 class="counter">450</h3>
                            <p>Transaction</p>
                        </article>

                        <article class="achievement_card col">
                            <span class="achievement_icon material-symbols-sharp">group</span>
                            <h3 class="counter">79000</h3>
                            <p>Customers</p>
                        </article>

                        <article class="achievement_card col">
                            <span class="achievement_icon material-symbols-sharp">reviews</span>
                            <h3 class="counter">36000</h3>
                            <p>Reviews</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="team">
            <h2 class="row justify-content-md-center display-4" style="font-family: monospace;">Meet Our Team</h2>
            <div class="team_container row justify-content-md-center">
                <article class="team_member col-lg-3">
                    <div class="team_member-image">
                        <img src="./imgs/team2_1.jpeg" class="col">
                    </div>
                    <div class="team_member-info">
                        <h5>Chong Zhi Kai</h5>
                        <p>Web Designer / Developer</p>
                    </div>
                    <div class="team_member-socials">
                        <a href="https://www.facebook.com/zhikai.chong.7" target="_blank"><i class="uil uil-facebook-f"></i></span></a>
                        <a href="https://www.instagram.com/zhikai.chong.19/" target="_blank"><i class="uil uil-instagram"></i></span></a>
                        <a href="https://linkedin.com" target="_blank"><i class="uil uil-linkedin-alt"></i></span></a>
                        <a href="https://api.whatsapp.com/send?phone=601139571932" target="_blank"><i class="uil uil-whatsapp"></i></span></a>
                    </div>
                </article>

                <article class="team_member col-lg-3">
                    <div class="team_member-image">
                        <img src="./imgs/team3_1.jpeg" class="col">
                    </div>
                    <div class="team_member-info">
                        <h5>Jensen Yap Yee Tat</h5>
                        <p>Web Designer / Developer</p>
                    </div>
                    <div class="team_member-socials">
                        <a href="https://facebook.com" target="_blank"><i class="uil uil-facebook-f"></i></span></a>
                        <a href="https://instagram.com" target="_blank"><i class="uil uil-instagram"></i></span></a>
                        <a href="https://linkedin.com" target="_blank"><i class="uil uil-linkedin-alt"></i></span></a>
                        <a href="https://whatsapp.com" target="_blank"><i class="uil uil-whatsapp"></i></span></a>
                    </div>
                </article>
            </div>
        </section>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".counter").each(function () {
                    $(this).prop('Counter', 0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 3500,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now) + '+');
                        }
                    })
                });
            });
        </script>

        <?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>
    </body>
</html>
