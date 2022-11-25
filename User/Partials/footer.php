<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<link rel="stylesheet" href="CSS/footerStyle.css">

<style>
    .alert {
        font-size: 12px;
        margin-top: 5px;
    }
    
    #sEmail {
        font-size: 15px;
        width: 100%;
        margin-bottom: 3px;
    }
</style>

<script>
$(document).ready(function () {
    $("#subscribe").click(function () {
        sEmail = $("#sEmail").val();
        
        $.ajax({
            type: "POST",
            url: "./process/subscribe.php",
            data: "sEmail=" + sEmail,
            success: function (html) {
                if(html === 'true') {
                    $("#add_info").html('<div class="alert alert-success"><strong>Subscribed</strong>.</div>');
                    document.getElementById('sForm').reset();
                } else if (html === 'false') {
                    $("#add_info").html('<div class="alert alert-danger"><strong>Error</strong> Please try again.</div>');
                } else if (html === 'eshort') {
                    $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> is required.</div>');
                } else if (html === 'eformat') {
                    $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> format is not valid.</div>');
                } else if (html === 'exist') {
                    $("#add_info").html('<div class="alert alert-danger"><strong>Email Address</strong> already subscribed.</div>');
                    document.getElementById('sForm').reset();
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

<body>
    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 segment-one md-mb-30 sm-mb-30">
                        <h3>R&S Service</h3>
                        <p>Welcome to R&S Service</p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 segment-two md-mb-30 sm-mb-30">
                        <h2>Useful Link</h2>
                        <ul>
                            <li><a href="#">Event</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Hosting</a></li>
                            <li><a href="#">Career</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 segment-three sm-mb-30">
                        <h2>Follow Us</h2>
                        <p>Please Follow us on our Social Media Platform in order to keep updated.</p>
                        <a href="#"><i class="fa fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-brands fa-linkedin"></i></a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 segment-four sm-mb-30">
                        <h2>Our Newsletter</h2>
                        <p>You will receive any latest information from us.</p>
                        <form role="form" id="sForm">
                            <div id="add_info"></div>
                            <input type="email" name="sEmail" id="sEmail" placeholder="abc@gmail.com">
                            <input type="submit" value="Subscribe" id="subscribe">
<!--                            <button class="bg-danger" type="submit" id="subscribe">Subscribe</button>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p class="footer-bottom-text">All Right reserved by &copy; R&S Service. <?php echo date('Y'); ?></p>
    </footer>
<!--    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>
<!--</html>-->
