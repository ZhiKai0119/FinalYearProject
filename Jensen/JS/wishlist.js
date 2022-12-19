function redirect(message) {
    var date = new Date();
    date.setTime(date.getTime() + (1*1000));
    var expires = "; expires= " + date.toGMTString();

    document.cookie = "status=" + message + expires + "; path=/";
    location.reload();
}

function errorRedirect(message) {
    var date = new Date();
    date.setTime(date.getTime() + (1*1000));
    var expires = "; expires= " + date.toGMTString();
    
    document.cookie = "failureStatus=" + message + expires + "; path=/";
    location.reload();
}

$(document).ready(function () {
    $('.wishlist').click(function () {
        prodId = $(this).attr("value");
        email = $("#email").val();

        $.ajax({
            type: "POST",
            url: "../user.php",
            data: "addToWishlist" + "&email=" + email + "&prodId=" + prodId,
            success: function (html) {
                if(html == 'true') {
                    redirect("Product Successfully Added to Wishlist");
                } else if(html == 'exists') {
                    errorRedirect("Product Already Exist In Wishlist");
                } else if(html == 'false') {
                    errorRedirect("Product Add to Wishlist Unsuccessful");
                } else {
                    errorRedirect("Error processing request. Please try again.");
                }
            }
        });
        return false;
    });
});
