<?php
// session_start();
// if (!isset($_SESSION['customerID'])) {
//     echo "<h1>Warning</h1>";
//     echo "<h2>No permission allowed to access this page</h2>";
//     echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
//     exit(); // Quit the script.
// }
include_once './nav.php';
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int) $_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM product');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT

$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM product')->rowCount();
?>

<?= template_header('Products') ?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?= $total_products ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
            <a href="index.php?page=product" class="product">
                <img src="imgs/<?= $product['product_image'] ?>" width="200" height="200" alt="<?= $product['product_name'] ?>">
                <span class="name"><?= $product['product_name'] ?></span>
                <span class="price">
                    &dollar;<?= $product['product_price'] ?>

                </span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
            <a href="index.php?page=products&p=<?= $current_page - 1 ?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
            <a href="index.php?page=products&p=<?= $current_page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</div>


<?php include_once './simpleFooter.php'; ?>