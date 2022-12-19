<?php
session_start();
if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}

if(isset($_GET['paytotal'])) {
    $paytotal = $_GET['paytotal'];
}

include 'nav.php';
require './config/constant.php';

$grand_total = 0;
$allItems = '';
$items = [];

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Checkout</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
        <script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
    </head>

    <body>


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 px-4 pb-4" id="order">
                    <h4 class="text-center text-info p-2">Complete your order!</h4>
                    <div class="jumbotron p-3 mb-2 text-center">
                        <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
                        <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                        <h5><b>Total Amount Payable : </b><?= number_format($paytotal, 2) ?>/-</h5>
                    </div>
                    <form action="" method="post" id="placeOrder">

                        <input type="hidden" name="products" value="<?= $allItems; ?>">
                        <input type="hidden" name="grand_total" id="grand_total" value="<?= $paytotal; ?>">
                        <div class="form-group">
                            <input type="hidden" name="customerID" value="<?= $_SESSION['customerID']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                        </div>
                        <div class="form-group">
                            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
                        </div>
                        <h6 class="text-center lead">Select Payment Mode</h6>
                        <div class="form-group">
                            <select name="pmode" class="form-control">
                                <option value="" selected disabled>-Select Payment Mode-</option>
                                <option value="cod">Cash On Delivery</option>
                                <option value="netbanking">Net Banking</option>
                                <option value="cards">Debit/Credit Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block mb-2">
                            <div id="paypal-button-container"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

        <script type="text/javascript">
            $(document).ready(function () {

                // Sending Form data to the server
                $("#placeOrder").submit(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'action.php',
                        method: 'post',
                        data: $('form').serialize() + "&action=order",
                        success: function (response) {
                            $("#order").html(response);
                        }
                    });
                });

                // Load total no.of items added in the cart and display in the navbar
                load_cart_item_number();

                function load_cart_item_number() {
                    $.ajax({
                        url: 'action.php',
                        method: 'get',
                        data: {
                            cartItem: "cart_item"
                        },
                        success: function (response) {
                            $("#cart-item").html(response);
                        }
                    });
                }
            });

            paypal.Buttons({
                onClick: function()  {
                if($('#addId').val() == "none") {
                    if(fullname.length == 0 || phoneNo.length == 0 || stateCity.length == 0 || postalCode.length == 0 || detailAdd.length == 0) {
                    hideAllActiveBoxes();
                    $('#deliveryAdd').modal('show');
                    alert("Please fill up all the fields. No field can be blank.");
                    return false;
                    }
                } 
                },
                onCancel: function (data) {
                
                },
                createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                    amount: {
                        value: Number($('#grand_total').val()).toFixed(2)
                    }
                    }]
                });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    const transaction = orderData.purchase_units[0].payments.captures[0];

                    // var email = $('#email').val();
                    // var grand_total = $('#grand_total').val();

                    // $.ajax({
                    // type: "POST",
                    // url: "../process/user.php",
                    // data: "makePayment" + "&email=" + email + "&payment_mode=Paid by Paypal" + "&payment_id=" + transaction.id + "&addId=" + addId + "&totalPay=" + totalPay + "&rentId=" + rentId,
                    // success: function(html) {
                    //     if(html == "success") {
                    //     redirect("Rental Placed Successfully");
                    //     } else {
                    //     $("#pay_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                    //     alert(html);
                    //     }
                    // }
                    // }); 
                });
                }
            }).render('#paypal-button-container');
        </script>
    </body>

</html>


<?php include './footer.php'; ?>