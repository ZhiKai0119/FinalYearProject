<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<?php 
include './config/constant.php';
include './nav.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
} else { ?>
    <script>window.open("../index.php", "_self");</script>
<?php }

$check_voucher = $conn->query("SELECT * FROM sell_voucher");
$data = $check_voucher->fetch_assoc();
if($data['quantity'] == 0) {
    $delete_voucher = $conn->query("UPDATE sell_voucher SET voucher_status = 'Unavailable' WHERE redeemCode = '$redeemCode'");
}

?>

<div class="py-2">
    <div class="container">
        <div class="col-md-12">
            <h1 class="text-center"><strong>Make Payment</strong></h1><hr>
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-center"><strong>Shipping Address</strong></h3>
                    <form action="process/action.php" method="POST">
                        <div class="mb-3">
                            <h6 for="address" class="form-label">Address</h6>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="city" class="form-label">City</h6>
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="state" class="form-label">State</h6>
                            <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="zip" class="form-label">Zip</h6>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="country" class="form-label">Country</h6>
                            <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="country" class="form-label">Receiver Name</h6>
                            <input type="text" class="form-control" id="rName" name="rName" placeholder="Receiver Name" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="phone" class="form-label">Phone</h6>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                        </div>
                        <div class="mb-3">
                            <h6 for="email" class="form-label">Email</h6>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center"><strong>Order Summary</strong></h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            if (isset($_GET['cartId'])) {
                                $cart = $conn->query("SELECT * FROM cart WHERE cartId = '{$_GET['cartId']}'");
                                while($row = $cart->fetch_assoc()) {
                                    $subtotal = 0;
                                    $product = $conn->query("SELECT * FROM sell_product WHERE product_code = '{$row['prodCode']}'");
                                    $productRow = $product->fetch_assoc();
                                    $subtotal += $productRow['product_price'] * $row['qty'];

                                    echo "
                                        <tr>
                                            <td>{$productRow['product_name']}</td>
                                            <td>{$row['qty']}</td>
                                            <td>{$subtotal}</td>
                                        </tr>";
                                    $total += $subtotal;
                                }
                            }
                            $shipping = 10;
                            $total += $shipping;
                            ?>
                            <tr>
                                <td colspan="2">Shipping</td>
                                <td><?php echo $shipping ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Voucher <button class="btn btn-secondary ml-3 float-right btnApply" onclick="openModal();">Apply Voucher</button></td>
                                <td><input type="text" class="form-control-plaintext" readonly name="discount_price" id="discount_price" value="0"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total</td>
                                <input type="hidden" name="cartId" id="cartId" value="<?php echo $_GET['cartId']; ?>">
                                <td><b><input type="text" class="total form-control-plaintext" readonly name="total" value="<?php echo $total; ?>"></b></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <div id="paypal-button-container"></div>
                        <!-- <button type="submit" class="btn btn-primary">Make Payment</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal With voucher -->
<div id="voucher" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h5 class="modal-title" id="paymentlabel">Voucher</h5>
            </div>
            <div class="modal-body">
                <p>There are some voucheres are for you to redeem.</p>
                <ul class="list-group">
                    <?php include './config/constant.php'; 
                    $voucher = $conn->query("SELECT * FROM sell_voucher WHERE voucher_status = 'Available'");
                    while($data = $voucher->fetch_assoc()):  ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo $data['title']; ?><br>
                                    <input type="text" class="form-control-plaintext input-sm p-0 code" name="code" value="<?php echo $data['redeemCode']; ?>">
                                    <span class="text-danger">Minimum Spend: RM <?php echo $data['minSpend']; ?></span>
                                </div>
                                <div class="col-md-3 d-flex align-content-center">
                                    <button class="btn-sm btn-success btnRedeem" value="<?php echo $data['redeemCode']; ?>">Redeem</button>
                                </div>
                            </div>
                        </li> 
                    <?php endwhile; ?>
                </ul>
                
                <!-- <button type="button" class="btn btn-danger confirmclosed">Confirm Close</button> -->
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnRedeem').click(function() {
            var total = $('.total').val();
            var code = $(this).val();
            console.log(code);
            console.log(total);
            $.ajax({
                type: "POST",
                url: "./process/process.php",
                data: "checkVoucher" + "&total=" + total + "&redeemCode=" + code,
                success: function(response) {
                    obj = JSON.parse(response);
                    $('.total').val(obj.total);
                    $('#discount_price').val(obj.value);
                    if(obj.value == '0.00') {
                        alert("Your cart haven't reach the minimum spend.");
                    } else {
                        $('#voucher').modal('hide');
                        $('.btnApply').attr('disabled', 'disabled');
                    }
                }
            });
        });
    });

    function openModal() {
        $('#voucher').modal('show');
    }

    function calTotal() {
        var total = $('.total').val();
        var discount = $('#discount_price').val();
        var calTotal = ~~total + ~~discount;
        $('.total').val(calTotal);
        $('.total').html(calTotal);
    }

    paypal.Buttons({
        createOrder: (data, actions) => {
        return actions.order.create({
            purchase_units: [{
            amount: {
                value: Number($('.total').val()).toFixed(2)
            }
            }]
        });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
            const transaction = orderData.purchase_units[0].payments.captures[0];

            var email = '<?php echo $_GET['email']; ?>';
            var cartId = $('#cartId').val();
            var total = $('.total').val();
            var address = $('#address').val();
            var city = $('#city').val();
            var state = $('#state').val();
            var zip = $('#zip').val();
            var country = $('#country').val();
            var rName = $('#rName').val();
            var phone = $('#phone').val();
            

            $.ajax({
                type: "POST",
                url: "./process/process.php",
                data: {
                    "makePayment": true,
                    "email": email,
                    "cartId": cartId,
                    "total": total,
                    "payment_mode": "Paid by Paypal",
                    "payment_id": transaction.id,
                    "address": address,
                    "city": city,
                    "state": state,
                    "zip": zip,
                    "country": country,
                    "rName": rName,
                    "phone": phone
                },
                success: function(response) {
                    if(response == "success") {
                        alert("Payment Success");
                        window.location.href = "./home.php";
                    } else {
                        alert("Payment Failed");
                    }
                }
            }); 
        });
        }
    }).render('#paypal-button-container');
</script>

<?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>