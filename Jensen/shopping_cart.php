<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<?php 
include './config/constant.php';
include './nav.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
} else {
    header("Location: index.php");
    exit();
}
?>

<div class="py-3">
    <div class="container-fluid" style="min-height:30vh;">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center"><strong>Shopping Cart</strong></h1><hr>
            <div class="row d-flex justify-content-center">
                <?php 
                $cartId = $conn->query("SELECT DISTINCT * FROM cart WHERE email = '$email' AND status = 'Pending' LIMIT 1");
                if($cartId->num_rows > 0) {
                    $row = $cartId->fetch_assoc(); ?>
                        <div class="card col-md-8 p-0 mx-1">
                            <div class="card-body">
                                <?php $cart = $conn->query("SELECT * FROM cart WHERE email = '$email' AND status = 'Pending'");
                                if(mysqli_num_rows($cart) > 0) { ?>
                                    <table class="table text-center table-sm table-responsive w-100 d-block d-md-table p-0">
                                        <thead>
                                            <tr class="bg-dark text-light table-borderless">
                                                <th scope="col">#</th>
                                                <th scope="col">Product ID</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Unit Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1; 
                                            $totalProdPrice = 0.00;
                                            $delFees = 10.0;
                                            while ($item = $cart->fetch_assoc()): 
                                                $prodCode = $item['prodCode'];
                                                $product = $conn->query("SELECT * FROM sell_product WHERE product_code = '$prodCode' LIMIT 1");
                                                if(mysqli_num_rows($product) == 1) {
                                                    $prodInfo = mysqli_fetch_assoc($product); ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $i; ?></th> 
                                                        <td><?php echo $item['prodCode']; ?><br></td>
                                                        <td><img src="./Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodCode=<?php echo $prodInfo['product_code']; ?>';" style="width: 100px; height: 100px;"></td>
                                                        <td><?php echo $item['prodPrice']; ?><br></td>
                                                        <td><input type="number" class="form-control prodQty" name="prodQty" value="<?php echo $item['qty']; ?>" min="1" max="<?php echo $prodInfo['product_qty'] ?>"></td>
                                                        <td><?php echo $item['subtotal']; ?></td>
                                                        <?php $totalProdPrice += $item['subtotal']; ?>
                                                        <td class="col-sm-1">
                                                            <button type="button" class="btn btn-danger btnCancel" value="<?php echo $item['prodCode'];?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php $i++; endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php } else { 
                                    $totalProdPrice = 0.00;
                                    $delFees = 0.00; ?>
                                    <small class="text-muted">There is no any pending rental to proceed.</small>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card col-md-3 p-0 mx-1">
                            <div class="card-header">
                                <h5 class="text-uppercase text-center font-weight-bold text-dark">Summary</h5>
                                <!-- <input type="hidden" id="rentId" name="rentId" value="<?php echo $row['rentId']; ?>"> -->
                            </div>
                            <div class="card-body">
                                <div class="form-group d-flex justify-content-between">
                                    <h6 class="d-inline">Subtotal(RM): </h6>
                                    <h6 class="d-inline"><span><?php echo number_format((float)$totalProdPrice,2); ?></span></h6>
                                </div>
                                <div class="form-group d-flex justify-content-between">
                                    <h6 class="d-inline">Delivery Fees(RM): </h6>
                                    <h6 class="d-inline"><span><?php echo number_format((float)$delFees,2); ?></span></h6>
                                </div>
                                <hr>
                                <div class="form-group d-flex justify-content-between">
                                    <h6 class="d-inline text-success">Total Rental Fees(RM): </h6>
                                    <?php $totalFees = $totalProdPrice + $delFees; ?>
                                    <h6 class="d-inline text-success"><span><?php echo number_format((float)$totalFees,2); ?></span></h6>
                                </div>
                                <hr>
                                <input type="hidden" class="cartId" name="cartId" value="<?php echo $row['cartId']; ?>">
                                <input type="hidden" class="totalFees" name="totalFees" value="<?php echo number_format((float)$totalFees,2); ?>">
                                <button type="button" class="btn btn-success col" id="btnPayment">Make Payment</button>
                            </div>
                        </div>
            <?php } else { ?>
                <small class="text-muted small">No Items.</small>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnCancel').click(function() {
            var prodCode = $(this).val();
            var email = '<?php echo $email; ?>';
            $.ajax({
                url: './process/action.php',
                method: 'POST',
                data: {
                    deleteItem: "deleteItem",
                    prodCode: prodCode,
                    email: email
                },
                success: function(data) {
                    if(data == "success") {
                        alert("Item has been removed from cart.");
                        location.reload();
                    } else {
                        alert("Failed to remove item from cart.");
                    }
                }
            });
        });

        $('.prodQty').change(function() {
            var prodCode = $(this).parent().parent().find('.btnCancel').val();
            var qty = $(this).val();
            var email = '<?php echo $email; ?>';
            $.ajax({
                url: './process/action.php',
                method: 'POST',
                data: {
                    updateQty: "updateQty",
                    prodCode: prodCode,
                    qty: qty,
                    email: email
                },
                success: function(data) {
                    if(data == "success") {
                        // alert("Item quantity has been updated.");
                        location.reload();
                    } else {
                        alert("Failed to update item quantity.");
                    }
                }
            });
        })

        $('#btnPayment').click(function() {
            var email = '<?php echo $email; ?>';
            var totalFees = $('.totalFees').val();
            var cartId = $('.cartId').val();

            window.open("make_payment.php?email=" + email + "&totalFees=" + totalFees + "&cartId=" + cartId, "_self");
        });
    });
</script>

<?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>