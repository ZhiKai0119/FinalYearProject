<link rel="stylesheet" href="CSS/pagination.css">
<?php 
$total_pages = $conn->query('SELECT * FROM products')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 10;

if ($stmt = $conn->prepare('SELECT * FROM products LIMIT ?,?')) {
	$calc_page = ($page - 1) * $num_results_on_page;
	$stmt->bind_param('ii', $calc_page, $num_results_on_page);
	$stmt->execute(); 
	$result = $stmt->get_result();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Products</h4>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link active" id="rental-tab" data-bs-target="#rental" type="button" role="tab" aria-controls="rental" aria-selected="true">Rental</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link" id="selling-tab" data-bs-target="#selling" type="button" role="tab" aria-controls="selling" aria-selected="false">Selling</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="rental" role="tabpanel" aria-labelledby="rental-tab">
                    <div class="card-body bg-transparent" id="products_table">
                        <table class="table table-bordered table-striped text-center table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $product = $conn->query("SELECT * FROM products");
                                    if(mysqli_num_rows($product) > 0) {
                                        foreach ($product as $item) {?>
                                            <tr>
                                                <td><?php echo $item['prodId'];?></td>
                                                <td><?php echo $item['prodName'];?></td>
                                                <td>
                                                    <img src="Images/<?php echo $item['image'];?>" width="50px" alt="<?php echo $item['prodName'];?>">
                                                </td>
                                                <td><?php echo $item['status'] == '1'?"Available":"Unavailable";?></td>
                                                <td class="col-sm-1">
                                                    <a href="main.php?edit-product&id=<?php echo $item['prodId'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                                                </td>
                                                <td class="col-sm-1">
                                                    <button type="submit" class="btn btn-danger delete_product_btn" value="<?php echo $item['prodId'];?>">Delete</button>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "No Records Found";
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                            <li class="prev"><a href="main.php?view-product&page=<?php echo $page-1 ?>">Prev</a></li>
                            <?php endif; ?>

                            <?php if ($page > 3): ?>
                            <li class="start"><a href="main.php?view-product&page=1">1</a></li>
                            <li class="dots">...</li>
                            <?php endif; ?>

                            <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?view-product&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                            <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?view-product&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                            <li class="currentpage"><a href="main.php?view-product&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                            <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-product&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                            <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-product&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                            <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                            <li class="dots">...</li>
                            <li class="end"><a href="main.php?view-product&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                            <?php endif; ?>

                            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                            <li class="next"><a href="main.php?view-product&page=<?php echo $page+1 ?>">Next</a></li>
                            <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="selling" role="tabpanel" aria-labelledby="selling-tab">
                    <?php include '../Jensen/admin/view-product.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$stmt->close();
}
?>