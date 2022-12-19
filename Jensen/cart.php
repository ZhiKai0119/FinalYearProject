<?php
session_start();
if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}
include './nav.php';

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="author" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Cart</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
    </head>

    <body>
     
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div style="display:<?php
                    if (isset($_SESSION['showAlert'])) {
                        echo $_SESSION['showAlert'];
                    } else {
                        echo 'none';
                    } unset($_SESSION['showAlert']);
                    ?>" class="alert alert-success alert-dismissible mt-3">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                            } unset($_SESSION['showAlert']);
                            ?></strong>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="text-center text-info m-0">Cart </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cart ID</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>
                                        <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require './config/constant.php';
                                $stmt = $conn->prepare('SELECT * FROM cart');
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $grand_total = 0;
                                while ($row = $result->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                                <td><?= $row['product_name'] ?></td>
                                <td>
                                    <i class=""></i>RM&nbsp;&nbsp;<?= number_format($row['product_price'], 2); ?>
                                </td>
                                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                
                                <td>
                                    <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;">
                                </td>
                                <td><i class=""></i> RM&nbsp;&nbsp;<?= number_format($row['total_price'], 2); ?></td>
                                <td>
                                    <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                </tr>
                                <?php $grand_total += $row['total_price']; ?>
                            <?php endwhile; ?>
                            <tr>
                                <td colspan="3">
                                    <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                                        Shopping</a>
                                </td>
                                <td colspan="2"><b>Grand Total</b></td>
                                <td>
                                    <input type="hidden" name="grand_total" id="grand_total" value="<?php echo $grand_total; ?>">
                                    <b><i class=""></i>RM &nbsp;&nbsp;<?= number_format($grand_total, 2); ?></b>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><button class="btn btn-primary m-1" onclick="openModal()">Apply Voucher</button></td>
                                <input type="hidden" class="form-control-plaintext text-center" name="cal_discount" id="cal_discount">
                                <td><input type="text" class="form-control-plaintext text-center" name="discount_price" id="discount_price" value="RM 0.00"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">Total</td>
                                <td><input type="text" class="form-control-plaintext text-center" name="total" id="total" value="RM 0.00"></td>
                                <td>
                                    <form action="placeorder.php">
                                        <input type="hidden" class="form-control-plaintext text-center" name="cal_discount" id="cal_discount">
                                        <input type="hidden" class="form-control-plaintext text-center" name="paytotal" id="paytotal">
                                        <button type="submit" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                            <?php include './config/db.php'; 
                            $voucher = $conn->query("SELECT * FROM sell_voucher WHERE voucher_status = 'Available'");
                            while($data = $voucher->fetch_assoc()):  ?>
                               <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <?php echo $data['title']; ?><br>
                                            <input type="text" class="form-control-plaintext input-sm p-0" id="code" name="code" value="<?php echo $data['redeemCode']; ?>">
                                            <span class="text-danger">Minimum Spend: RM <?php echo $data['minSpend']; ?></span>
                                        </div>
                                        <div class="col-md-3 d-flex align-content-center">
                                            <button class="btn-sm btn-success" onclick="copyText()">Redeem</button>
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

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

        <script type="text/javascript">
            calTotal();
            
            function openModal() {
                $('#voucher').modal('show');
            }
            function copyText() {
                var copyText = document.getElementById("code");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value)
                grand_total = $('#grand_total').val();

                $.ajax({
                    type: "POST",
                    url: "./process/process.php",
                    data: "checkVoucher" + "&grand_total=" + grand_total + "&redeemCode=" + copyText.value,
                    success: function(response) {
                        // alert(response);
                        $('#discount_price').val("-RM" + response);
                        $('#cal_discount').val(response);
                        calTotal();
                        $('#voucher').modal('hide');
                    }
                })
            }
            function calTotal() {
                grand_total = $('#grand_total').val();
                cal_discount = $('#cal_discount').val();
                total = ~~grand_total - ~~cal_discount;

                $('#total').val("RM " + Number(total).toFixed(2));
                $('#paytotal').val(Number(total).toFixed(2));
            }

        $(document).ready(function () {

            // Change the item quantity
            $(".itemQty").on('change', function () {
                var $el = $(this).closest('tr');

                var pid = $el.find(".pid").val();
                var pprice = $el.find(".pprice").val();
                var qty = $el.find(".itemQty").val();
                location.reload(true);
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    cache: false,
                    data: {
                        qty: qty,
                        pid: pid,
                        pprice: pprice
                    },
                    success: function (response) {
                        console.log(response);
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
        </script>
    </body>

</html>
<?php include 'footer.php';?>


