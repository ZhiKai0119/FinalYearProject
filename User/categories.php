<link rel="stylesheet" href="CSS/product.css"/>

<?php 
include './Partials/nav.php'; 

$total_pages = $conn->query('SELECT * FROM categories WHERE status = 1')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 8;

if ($stmt = $conn->prepare('SELECT * FROM categories WHERE status = 1 LIMIT ?,?')) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute(); 
    $result = $stmt->get_result();
?>
<!--    <div class="py-1">
        <div class="container">
            <h6 class="text-muted">
                <a class="text-muted" href="main.php">Home</a> / Collections
            </h6>
        </div>
    </div>-->

    <div class="col-md-10 col-11 mx-auto">
        <nav aria-label="breadcrumb" class="m-3">
          <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="main.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Collections</li>
          </ol>
        </nav>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Our Collections</h1>
                    <hr>
                    <div class="row">
                        <?php while ($item = $result->fetch_assoc()): ?>
                        <div class="col-md-3 mb-2">
                            <a class="text-muted" href="product-category.php?catId=<?php echo $item['catId']; ?>">
                                <div class="cat-box">
                                    <div class="category-inner-box position-relative">
                                        <img src="../Owner/Images/<?php echo $item['image']; ?>" alt="Category Image" class="img-fluid">
                                    </div>
                                    <div class="category-info">
                                        <div class="category-name">
                                            <h4 class="text-center"><?php echo $item['catName']; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile;?>
                    </div>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                        <li class="prev"><a href="categories.php?page=<?php echo $page-1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                        <li class="start"><a href="categories.php?page=1">1</a></li>
                        <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page-2 > 0): ?><li class="page"><a href="categories.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                        <?php if ($page-1 > 0): ?><li class="page"><a href="categories.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="categories.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="categories.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="categories.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="categories.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="categories.php?page=<?php echo $page+1 ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
    $stmt->close();
} else {
    echo "No Category Available.";
}
?>
<?php include './Partials/footer.php'; ?>
<?php include './Partials/chatbot.php'; ?>