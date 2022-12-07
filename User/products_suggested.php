<link rel="stylesheet" href="CSS/product.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
$get_prod = $conn->query("SELECT * FROM products WHERE status = 1 ORDER BY RAND() LIMIT 0,3");
?>

<div class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center text-dark">Featured Products</h3>
                <hr>
                <div class="row">
                    <?php while ($prod = $get_prod->fetch_assoc()): ?>
                    <div class="col-lg-4 col-md-4 mb-3 bg-light">
                        <div class="product-box" style="cursor: pointer;">
                            <div class="product-inner-box position-relative">
                                <div class="icons position-absolute">
                                    <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                    <a class="text-decoration-none text-dark bg-light wishlist" value="<?php echo $prod['prodId']; ?>"><i class="fa fa-heart" aria-hidden="true"></i></i></a>
                                    <a href="product_details.php?prodId=<?php echo $prod['prodId']; ?>" class="text-decoration-none text-dark bg-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </div>
                                <div class="onsale">
                                    <?php 
                                    $original = $prod['original_price'];
                                    $rental = $prod['rental_price'];

                                    $promotion = ($original-$rental)/$original*100;
                                    ?>
                                    <span class="badge rouunded-0 text-light"><i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo round($promotion,2); ?>%</span>
                                </div>
                                <img src="../Owner/Images/<?php echo $prod['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $prod['prodId']; ?>';">
                                <div class="cart-btn">
                                    <button class="btn btn-light shadow-sm badge-pill badge-light btnRent" value="<?php echo $prod['prodId']; ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> Rent It</button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-name">
                                    <h3 class="text-dark"><?php echo $prod['prodName'];?></h3>
                                </div>
                                <div class="product-price">
                                    RM<span><?php echo $prod['rental_price']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './rental_modal.php'; ?>
<script type="text/javascript" src="JS/wishlist.js"></script>
<script>
    $(document).ready(function () {
        $('.btnRent').click(function () {
            email = "<?php echo $userInfo['email'];?>";
            prodId = $(this).attr("value");

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "getProductInfo" + "&email=" + email + "&prodId=" + prodId,
                success: function (html) {
                    obj = JSON.parse(html);
                    $('#rentDetail').modal('show');
                    $('#email').val(email);
                    $('#prodId').val(prodId);
                    getReservedDate(obj.rentDate);
                    $('#origFees').val(obj.rentalPrice);
                    prodPrice = obj.prodPrice;
                    calDeposit = (prodPrice * 0.10).toFixed(2);
                    if (calDeposit >= 100) {
                        $('#deposit').val();
                    } else {
                        $('#deposit').val(calDeposit);
                    }
                    changeRange();
                }
            });
            return false;                    
        });
    });
</script>