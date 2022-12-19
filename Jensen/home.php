<?php
include 'nav.php';
if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM sell_product LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?= template_header('Home') ?>
<div class="featured">
    <h2>Selling</h2>
    <p>Gadgets For Routine</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
            <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
                <span class="name"><?= $product['name'] ?></span>
                <span class="price">
                    &dollar;<?= $product['price'] ?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php include './footer.php'; ?>
<?php include './chatbot.php'; ?>
