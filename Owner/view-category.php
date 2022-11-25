<link rel="stylesheet" href="CSS/pagination.css">
<?php 
$total_pages = $conn->query('SELECT * FROM categories')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 5;

if ($stmt = $conn->prepare('SELECT * FROM categories LIMIT ?,?')) {
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
                    <h4 class="text-uppercase font-weight-bold">Categories</h4>
                </div>
            </div>
            <div class="card-body bg-transparent" id="category_table">
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
                            //$category = $conn->query("SELECT * FROM categories");
                            //if(mysqli_num_rows($category) > 0) {
                            while ($item = $result->fetch_assoc()):
                                //foreach ($category as $item) {?>
                                    <tr>
                                        <td><?php echo $item['catId'];?></td>
                                        <td><?php echo $item['catName'];?></td>
                                        <td>
                                            <img src="Images/<?php echo $item['image'];?>" width="50px" alt="<?php echo $item['catName'];?>">
                                        </td>
                                        <td><?php echo $item['status'] == '1'?"Visible":"Hidden";?></td>
                                        <td class="col-sm-1">
                                            <a href="main.php?edit-category&id=<?php echo $item['catId'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                                        </td>
                                        <td class="col-sm-1">
                                            <form action="process/category.php" method="POST">
                                                <input type="hidden" name="category_id" value="<?php echo $item['catId'];?>">
                                                <button type="submit" class="btn btn-danger" name="delete_category_btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php endwhile; ?>
                                <?php //}
//                            } else {
//                                echo "No Records Found";
//                            }
                        ?>
                    </tbody>
                </table>
                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="prev"><a href="main.php?categories&page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                    <li class="start"><a href="main.php?categories&page=1">1</a></li>
                    <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?categories&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?categories&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="main.php?categories&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?categories&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?categories&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="main.php?categories&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                    <li class="next"><a href="main.php?categories&page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$stmt->close();
}
?>