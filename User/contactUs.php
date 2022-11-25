<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Contact Us</title>
        <link rel="stylesheet" href="CSS/contact.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script >
            $(document).ready(function() {
                $('#contact').click(function () {
                    fname = $("#fname").val();
                    email = $("#email").val();
                    message = $("#message").val();
                    
                    $.ajax({
                        type: "POST",
                        url: "./process/sendmsg.php",
                        data: "fname=" + fname + "&email=" + email + "&message=" + message,
                        success: function(html) {
                            if(html === 'true') {
                                $("#add_err").html('<div class="alert alert-success"><strong>Message Sent!</strong></div>');
                            } else if (html === 'fname_long') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>First Name</strong> must cannot exceed 50 characters.</div>');
                            } else if (html === 'fname_short') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>First Name</strong> must exceed 2 characters.</div>');
                            } else if (html === 'email_long') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Email</strong> must cannot exceed 50 characters.</div>');
                            } else if (html === 'email_short') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Email</strong> must exceed 2 characters.</div>');
                            } else if (html === 'eformat') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Email Address</strong> format incorrect.</div>');
                            } else if (html === 'message_long') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Message</strong> must cannot exceed 50 characters.</div>');
                            } else if (html === 'message_short') {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Message</strong> must exceed 2 characters.</div>');
                            } else {
                                $("#add_err").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                            }
                        },
                        beforeSend: function () {
                            $("#add_err").html('loading...');
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body>
        <?php include './Partials/nav.php';?>
        
        <section class="contact">
            <div class="content">
                <h2>Contact Us</h2>
                <p>Have any queries? Send us a message. Your enquiry may be best handled by our dedicated team. We will reply you as soon as possible.</p>
            </div>
            
            <div class="container1">
                <div class="contactInfo">
                    <div class="box">
                       <span class="icon material-symbols-sharp">map</span>
                        <div class="text">
                            <h3>Address</h3>
                            <p>Kampus Utama, Jalan Genting Kelang, <br>
                                53300 Kuala Lumpur, <br>
                                Wilayah Persekutuan Kuala Lumpur</p>
                        </div>
                    </div>
                    
                    <div class="box">
                        <div class="icon"><span class="material-symbols-sharp">mail</span></div>
                        <div class="text">
                            <h3>Email</h3>
                            <p><a href="mailto:rnsservice@contactus.com" style="color: white;">rnsservice@contactus.com</a></p>
                        </div>
                    </div>
                    
                    <div class="box">
                        <div class="icon"><span class="material-symbols-sharp">support_agent</span></div>
                        <div class="text">
                            <h3>Phone</h3>
                            <p>03-1234556</p>
                        </div>
                    </div>
                </div>
                
                <div class="contactForm">
                    <form role="form">
                        <h2>Any Queries</h2>
                        <div id="add_err"></div>
                        <div class="inputBox">
                            <input type="text" name="fname" id="fname" required="required">
                            <span>Full Name</span>
                        </div>
                        <div class="inputBox">
                            <input type="email" name="email" id="email" required="required">
                            <span>Email</span>
                        </div>
                        <div class="inputBox">
                            <textarea name="message" id="message" required="required"></textarea>
                            <span>Type your message...</span>
                        </div>
                        <div class="inputBox">
                            <button type="submit" name="contact" id="contact">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.534261025503!2d101.72683291454236!3d3.216164297658391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc3843bfb6a031%3A0x2dc5e067aae3ab84!2sTunku%20Abdul%20Rahman%20University%20College!5e0!3m2!1sen!2smy!4v1655467905162!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        
        <?php include './Partials/footer.php'; ?>
        <?php include './Partials/chatbot.php'; ?>
    </body>
</html>
