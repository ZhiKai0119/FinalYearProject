<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
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
?>

<div class="py-3">
    <div class="container" style="min-height:30vh;">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center"><strong>Order History</strong></h1><hr>    
            <?php
            $email = $userInfo['email'];
            $sql = $conn->query("SELECT * FROM order_details WHERE email = '$email'");
            if($sql->num_rows > 0) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm text-center table-secondary">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cart ID</th>
                                    <th scope="col">Payment ID</th>
                                    <th scope="col">Receiver ID</th>
                                    <th scope="col">Tracking NO.</th>
                                    <th scope="col">Total Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while($record = $sql->fetch_assoc()):
                                $cartId = $record['cartId'];
                                $payId = $record['payment_id'];
                                $payment = $conn->query("SELECT * FROM payments WHERE payment_id = '$payId '")->fetch_assoc(); ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $record['cartId']; ?></td>
                                    <td><?php echo $record['payment_id']; ?></td>
                                    <td><?php echo $record['receiver_id']; ?></td>
                                    <td><?php echo $record['tracking_no']; ?></td>
                                    <td><?php echo $payment['amount']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <table class="table mb-0">
                                            <thead class="bg-dark text-light">
                                                <tr>
                                                    <th></th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql2 = $conn->query("SELECT * FROM cart WHERE cartId = '$cartId'");
                                                while($record2 = $sql2->fetch_assoc()):
                                                $prodCode = $record2['prodCode'];
                                                $product = $conn->query("SELECT * FROM sell_product WHERE product_code = '$prodCode'")->fetch_assoc(); ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $product['product_name']; ?></td>
                                                    <td><?php echo $record2['qty']; ?></td>
                                                    <td><?php echo $product['product_price']; ?></td>
                                                    <td><?php echo $record2['subtotal']; ?></td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <?php $i++; endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <small class="text-muted small">No Previos History.</small>
            <?php } ?>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>