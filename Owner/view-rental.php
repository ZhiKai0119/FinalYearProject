<link rel="stylesheet" href="CSS/pagination.css">
<script src="https://kit.fontawesome.com/885ec11a96.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php 
$total_pages = $conn->query('SELECT * FROM pending_rent ORDER BY rentId DESC')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 9;

if ($stmt = $conn->prepare('SELECT * FROM pending_rent ORDER BY rentId DESC LIMIT ?,?')) {
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
                    <h4 class="text-uppercase font-weight-bold">Pending Rental</h4>
                </div>
                <div class="card-body bg-transparent" id="rental_table">
                    <table class="table table-bordered text-center table-sm table-responsive w-100 d-block d-md-table" id="tblRental" cellspacing="0">
                        <thead class="bg-dark text-light">
                            <th scope="col">#</th>
                            <th scope="col">Rental ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Rental Fees</th>
                            <th scope="col">Rental Status</th>
                            <th scope="col">Return</th>
                            <th scope="col">Fine</th>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($item = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $item['rentId'];?></td>
                                    <td><?php echo $item['email'];?></td>
                                    <td><?php echo $item['prodId'];?></td>
                                    <td><?php echo $item['startDate'];?></td>
                                    <td><?php echo $item['endDate'];?></td>
                                    <td><?php echo $item['rentFees'];?></td>
                                    <?php if($item['status'] == "Pending") { ?>
                                        <td><span class="badge badge-primary"><?php echo $item['status'];?></span></td>
                                    <?php } elseif($item['status'] == "Pending Fine") {  ?>
                                        <td><span class="badge badge-warning"><?php echo $item['status'];?></span></td>
                                    <?php } elseif($item['status'] == "Cancelled") {  ?>
                                        <td><span class="badge badge-danger"><?php echo $item['status'];?></span></td>
                                    <?php } elseif($item['status'] == "Completed") {  ?>
                                        <td><span class="badge badge-success"><?php echo $item['status'];?></span></td>
                                    <?php } else {  ?>
                                        <td><span class="badge badge-secondary"><?php echo $item['status'];?></span></td>
                                    <?php }?>

                                    <?php if($item['returnId'] != "") { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                    <?php } else { ?>
                                        <td><i class="fa fa-xmark" aria-hidden="true"></i></td>
                                    <?php } ?>

                                    <?php if($item['fineId'] != "") { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                    <?php } else { ?>
                                        <td><i class="fa fa-xmark" aria-hidden="true"></i></td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; endwhile; ?>
                        </tbody>
                    </table>
                    <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                        <li class="prev"><a href="main.php?view-rental&page=<?php echo $page-1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                        <li class="start"><a href="main.php?view-rental&page=1">1</a></li>
                        <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?view-rental&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                        <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?view-rental&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="main.php?view-rental&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-rental&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?view-rental&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="main.php?view-rental&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="main.php?view-rental&page=<?php echo $page+1 ?>">Next</a></li>
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