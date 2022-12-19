<link rel="stylesheet" href="../CSS/pagination.css">
<?php
include '../config/constant.php';

$total_pages = $conn->query('SELECT * FROM users')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 9;

if ($stmt = $conn->prepare('SELECT * FROM users Where UserType = "User "LIMIT ?,?')) {
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
                        <h4 class="text-uppercase font-weight-bold">All Users</h4>
                    </div>
                </div>
                <div class="card-body bg-transparent" id="products_table">
                    <table class="table table-bordered table-striped text-center table-responsive-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email </th>
                                <th colspan="1">Registration_Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $item['customerID']; ?></td>
                                    <td><?php echo $item['Username']; ?></td>
                                    <td><?php echo $item['Phone']; ?></td>
                                    <td><?php echo $item['Email']; ?></td>
                                    <td><?php echo $item['Registration_date']; ?></td>
                                    



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