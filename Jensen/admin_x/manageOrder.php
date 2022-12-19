<link rel="stylesheet" href="../CSS/pagination.css">
<?php
include '../config/constant.php';

$total_pages = $conn->query('SELECT * FROM orders')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 9;

if ($stmt = $conn->prepare('SELECT * FROM orders Where status = "pending "LIMIT ?,?')) {
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
                        <h4 class="text-uppercase font-weight-bold">All Pending Orders</h4>
                    </div>
                </div>
                <div class="card-body bg-transparent" id="products_table">
                    <table class="table table-bordered table-striped text-center table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Paid</th>
                                <th>Address </th>
                                <th colspan="1">status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo $item['products']; ?></td>
                                    <td><?php echo $item['amount_paid']; ?></td>
                                    <td><?php echo $item['address']; ?></td>
                                    <td><?php echo $item['status']; ?>  <td>
                                        <a href="../action.php?updated=<?= $item['id'] ?>" class="text-danger lead" onclick="return confirm('Are you CONFIRM this order');"><i class="fas fa-trash-alt"></i>Confirm shipped</a>
                                    </td>
                                    </td>




                                    </td>

                                </tr>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <a href="indexAdmin.php">Back </a>
                </div>
                <?php
                $stmt->close();
            }
            ?>
            <script type="text/javascript">
                $(document).ready(function () {

                // Sending Form data to the server
                $("#updateBtn").submit(function (e) {
                e.preventDefault();
                        $.ajax({
                        url: '../action.php',
                                method: 'post',
                                data: $('form').serialize() + "&action=updated",
                                success: function (response) {
                                $("#updated").html(response);
                                }
                        });
                });
            </script>