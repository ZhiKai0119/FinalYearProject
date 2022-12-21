<?php 
include './config/constant.php';
$stmt = $conn->query("SELECT * FROM sell_product LIMIT 4");

?>

<div class="container">
    <h1 class="display-6 text-center text-dark font-weight-bold">Selling Platform</h1>
</div>
<?php include './nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <img src="./Images/banner1.png" alt="" width="100%" height="600px">
    </div>
    <h2 class="display-5 font-weight-bold text-dark text-center">Recently Added Products</h2><hr>
    <div class="products">
       <div class="row col-md-10 d-flex justify-content-center">
        <?php while($result = $stmt->fetch_assoc()): ?>
                <div class="col-md-3 mb-2">
                    <img src="./Images/<?php echo $result['image']; ?>" width="200" height="200" alt="<?php echo $result['product_name']; ?>"><br>
                    <?php echo $result['product_name']; ?> <br>
                    RM <?php echo $result['product_price']; ?>
                    <!-- <a class="text-decoration-none" href="" class="product">
                        <img src="./Images/<?php $result['image']; ?>" width="200" height="200" alt="<?php echo $result['product_name']; ?>">
                        <?php $result['product_name']; ?>
                        <?php $result['product_price']; ?>
                    </a> -->
                </div>
            <?php endwhile; ?>
       </div>
    </div>
</div>

<?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>