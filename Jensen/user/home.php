<?php 
// include '../config/constant.php';
include './nav.php'; 

$sql = $conn->query("SELECT * FROM sell_product LIMIT 4"); 
?>
<div class="featured">
    <h2>Selling</h2>
    <p>Gadgets For Routine</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php while ($product = $sql->fetch_assoc()): ?>
            <a class="text-decoration-none" href="index.php?page=product&id=<?php echo $product['product_code'] ?>" class="product">
                <img src="../Images/<?php echo $product['image'] ?>" width="200" height="200" alt="<?php echo $product['product_name'] ?>">
                <span class="name"><?php echo $product['product_name'] ?></span>
                <span class="price">
                    RM <?php echo $product['product_price'] ?>
                </span>
            </a>
        <?php endwhile; ?>
    </div>
</div>