<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="CSS/product.css"/>
<?php   
include './Partials/nav.php';

if(isset($_GET['catId'])) {
    $catId = $_GET['catId'];
    $category = $conn->query("SELECT * FROM categories WHERE catId = '$catId' AND status = 1");
    $data = mysqli_fetch_array($category);
    
    $total_pages = $conn->query("SELECT * FROM products WHERE catId = '$catId' AND status = 1")->num_rows;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $num_results_on_page = 9;

    if ($stmt = $conn->prepare("SELECT * FROM products WHERE catId = '$catId' AND status = 1 LIMIT ?,?")) {
        $calc_page = ($page - 1) * $num_results_on_page;
        $stmt->bind_param('ii', $calc_page, $num_results_on_page);
        $stmt->execute(); 
        $result = $stmt->get_result();
?>

    <div class="col-md-10 col-11 mx-auto">
        <nav aria-label="breadcrumb" class="m-3">
          <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="main.php">Home</a></li>
            <li class="breadcrumb-item"><a href="categories.php">Collections</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php echo $data['catName']; ?></li>
          </ol>
        </nav>
    </div>
        

    <div class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $data['catName']; ?></h1>
                    <hr>
                    <div class="row">
                        <?php while ($item = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <div class="product-box" style="cursor: pointer;">
                                <div class="product-inner-box position-relative">
                                    <div class="icons position-absolute">
                                        <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                        <a class="text-decoration-none text-dark bg-light wishlist" value="<?php echo $item['prodId']; ?>"><i class="fa fa-heart" aria-hidden="true"></i></i></a>
                                        <a href="product_details.php?prodId=<?php echo $item['prodId']; ?>" class="text-decoration-none text-dark bg-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="onsale">
                                        <?php 
                                        $original = $item['original_price'];
                                        $rental = $item['rental_price'];

                                        $promotion = ($original-$rental)/$original*100;
                                        ?>
                                        <span class="badge rouunded-0 text-light"><i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo round($promotion,2); ?>%</span>
                                    </div>
                                    <img src="../Owner/Images/<?php echo $item['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $item['prodId']; ?>';">
                                    <div class="cart-btn">
                                    <button class="btn btn-light shadow-sm badge-pill badge-light btnRent" value="<?php echo $item['prodId']; ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> Rent It</button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="product-name">
                                        <h3 class="text-dark"><?php echo $item['prodName'];?></h3>
                                    </div>
                                    <div class="product-price">
                                        RM<span><?php echo $item['rental_price']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <center>
                        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                        <ul class="pagination">
                                <?php if ($page > 1): ?>
                            <li class="prev"><a href="product-category.php?page=<?php echo $page-1 ?>">Prev</a></li>
                                <?php endif; ?>

                                <?php if ($page > 3): ?>
                                <li class="start"><a href="product-category.php?page=1">1</a></li>
                                <li class="dots">...</li>
                                <?php endif; ?>

                                <?php if ($page-2 > 0): ?><li class="page"><a href="product-category.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                                <?php if ($page-1 > 0): ?><li class="page"><a href="product-category.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                                <li class="currentpage"><a href="products.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="product-category.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="product-category.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                <li class="dots">...</li>
                                <li class="end"><a href="product-category.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                <?php endif; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                <li class="next"><a href="product-category.php?page=<?php echo $page+1 ?>">Next</a></li>
                                <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                    </center>
                </div>
            </div>
        </div>
<?php
    $stmt->close();
    } else {
        echo "There is no products in this category.";
    }
} else {
    echo "Error";
}
?>

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

<?php include './Partials/footer.php'; ?>
<?php include './Partials/chatbot.php'; ?>