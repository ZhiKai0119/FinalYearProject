<link rel="stylesheet" href="CSS/pagination.css">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

<?php 
$total_pages = $conn->query('SELECT * FROM rental_details  ORDER BY rental_id DESC')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 5;

if ($stmt = $conn->prepare('SELECT * FROM rental_details  ORDER BY rental_id DESC LIMIT ?,?')) {
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
                    <h4 class="text-uppercase font-weight-bold">Pending Delivery</h4>
                </div>
                <div class="card-body bg-transparent" id="rental_table">
                    <table class="table table-bordered text-center table-sm table-responsive w-100 d-block d-md-table" id="tblRental" cellspacing="0">
                        <thead class="bg-dark text-light">
                            <th scope="col">#</th>
                            <th scope="col">Rental ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Tracking No.</th>
                            <th scope="col" colspan="2">Rental Status</th>
                        </thead>
                        <tbody>
                            <?php while ($item = $result->fetch_assoc()): 
                            $rentId = $item['rental_id'];
                            $find_prod = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rentId'");
                            $prod_item = $find_prod->fetch_assoc();
                            
                            if($item['rental_status'] == "Pending Delivery") { ?>
                                <tr class="table-warning">
                            <?php } elseif($item['rental_status'] == "Delivering") { ?> 
                                <tr class="table-info">
                            <?php } elseif($item['rental_status'] == "Customer Received") { ?> 
                                <tr class="table-success">
                            <!-- <?php // } elseif($item['rental_status'] == "Pending Return") { ?> 
                                <tr class="table-light">
                            <?php //} elseif($item['rental_status'] == "Returned") { ?> 
                                <tr class="table-secondary"> -->
                            <?php } else { ?>
                                <tr>
                            <?php } ?>
                                    <td><?php echo $item['no'];?></td>
                                    <td><?php echo $item['rental_id'];?></td>
                                    <td><?php echo $item['email'];?></td>
                                    <td><?php echo $prod_item['prodId'];?></td>
                                    <td><?php echo $prod_item['startDate'];?></td>
                                    <td><?php echo $item['tracking_no'];?></td>
                                    <form class="col-md" action="process/rental.php" method="POST">
                                        <td class="col-sm-2">
                                            <input type="hidden" id="rental_id" name="rental_id" value="<?php echo $item['rental_id'];?>">
                                            <input type="hidden" id="rental_status" name="rental_status" value="<?php echo $item['rental_status'];?>">
                                            <!-- <select class="form-control" name="rental_status" id="rental_status">
                                                <option value="Pending Delivery" selected>Please select status</option>
                                                <option value="Delivering">Delivering</option>
                                                <option value="Received">Received</option>
                                                <option value="Pending Return">Pending Return</option>
                                                <option value="Returned">Returned</option>
                                            </select> -->
                                            <span class="badge badge-primary"><?php echo $item['rental_status'];?></span>
                                        </td>
                                        <td class="col-sm-1">
                                            <?php if($item['rental_status'] == "Customer Received") { ?>
                                                <button disabled type="submit" class="btn btn-primary btn-sm" id="btnConfirm" name="btnConfirm">Proceed</button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-primary btn-sm" id="btnConfirm" name="btnConfirm">Proceed</button>
                                            <?php } ?>
                                        </td>
                                    </form>
                                    <!-- <td class="col-sm-1">
                                        <form class="col-md" action="process/rental.php" method="POST">
                                            <input type="hidden" id="rental_id" name="rental_id" value="<?php echo $item['rental_id'];?>">
                                            <button type="submit" class="btn btn-danger btn-sm" id="btnReturn" name="btnReturn">Return Product</button>
                                        </form>
                                    </td> -->
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                        <li class="prev"><a href="main.php?view-delivery&page=<?php echo $page-1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                        <li class="start"><a href="main.php?view-delivery&page=1">1</a></li>
                        <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?view-delivery&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                        <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?view-delivery&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="main.php?view-delivery&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-delivery&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-delivery&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="main.php?view-delivery&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="main.php?view-delivery&page=<?php echo $page+1 ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$stmt->close();
}
?>