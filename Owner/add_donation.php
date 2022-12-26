<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="CSS/pagination.css">
<?php 
$total_pages = $conn->query('SELECT * FROM products WHERE rentalTimes = 0')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 5;

if ($stmt = $conn->prepare('SELECT * FROM products WHERE rentalTimes = 0 ORDER BY donated LIMIT ?,?')) {
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
            <div class="card-body bg-transparent" id="products_table">
                <table class="table table-bordered table-striped text-center table-responsive-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Donation Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $result->fetch_assoc()):?>
                            <tr>
                                <td><?php echo $item['prodId'];?></td>
                                <td><?php echo $item['prodName'];?></td>
                                <td>
                                    <img src="Images/<?php echo $item['image'];?>" width="50px" alt="<?php echo $item['prodName'];?>">
                                </td>
                                <td><?php echo $item['donated'] == '1'?"Donated":"Pending Donate";?></td>
                                <td>
                                    <?php if($item['donated']==0) { ?>
                                        <button type="submit" class="btn btn-primary addRentTimes" name="addRentTimes" value="<?php echo $item['prodId']; ?>">Good Condition</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary addRentTimes" name="addRentTimes" disabled="">Good Condition</button>
                                    <?php }?>
                                </td>
                                <td class="col-sm-1">
                                    <form action="process/product.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $item['prodId'];?>">
                                        <input type="hidden" name="product_name" value="<?php echo $item['prodName'];?>">
                                        <?php if($item['donated']==0) { ?>
                                            <button type="submit" class="btn btn-primary" name="create_donation_btn">Donate</button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="create_donation_btn" disabled="">Donate</button>
                                        <?php }?>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                        <?php if ($page > 1): ?>
                        <li class="prev"><a href="main.php?donate&page=<?php echo $page-1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                        <li class="start"><a href="main.php?donate&page=1">1</a></li>
                        <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page-2 > 0): ?><li class="page"><a href="main.php?donates&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                        <?php if ($page-1 > 0): ?><li class="page"><a href="main.php?donate&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="main.php?donate&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?donate&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="main.php?donate&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="main.php?donate&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                        <li class="next"><a href="main.php?donate&page=<?php echo $page+1 ?>">Next</a></li>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('.addRentTimes').click(function(e) {
            e.preventDefault();
            var prodId = $(this).val();
            swal({
                title: "Are you sure?",
                text: "Once confirmed, you will not be able to undo this action!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }) .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'process/product.php',
                        type: 'POST',
                        data: {
                            updateRentTimes: true,
                            prodId: prodId
                        },
                        success: function(response) {
                            if(response == "success") {
                                swal("Good condition!", "You have successfully confirmed the product condition!", "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal("Error!", "Something went wrong!", "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "You have cancelled the action!", "error");
                }
            });
        });
    })
</script>