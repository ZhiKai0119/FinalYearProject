<link rel="stylesheet" href="CSS/pagination.css">
<?php 
$total_pages = $conn->query('SELECT * FROM payments')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 10;

if ($stmt = $conn->prepare('SELECT * FROM payments LIMIT ?,?')) {
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
                    <h4 class="text-uppercase font-weight-bold">Payment History</h4>
                </div>
            </div>
            <div class="card-body bg-transparent" id="category_table">
                <table class="table table-bordered table-striped text-center table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment ID</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <!-- <th colspan="2">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; $total = 0; while ($item = $result->fetch_assoc()):?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $item['payment_id'];?></td>
                                <td><?php echo $item['payer_email'];?></td>
                                <td><?php echo $item['amount'];?></td>
                                <td><?php echo $item['payment_mode'];?></td>
                            </tr>
                        <?php $total += $item['amount']; $i++; endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Total</td>
                            <td class="text-center"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="prev"><a href="main.php?payment&page=<?php echo $page-1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                    <li class="start"><a href="main.php?payment&page=1">1</a></li>
                    <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?payment&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?payment&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="main.php?payment&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?payment&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?payment&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="main.php?payment&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                    <li class="next"><a href="main.php?payment&page=<?php echo $page+1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
// $stmt->close();
}
?>