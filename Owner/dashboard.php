<?php
$total = 0;
$calculate_total = $conn->query("SELECT * FROM payments");
while($price = $calculate_total->fetch_assoc()) {
    $total += $price['amount'];
}

$count_pending = $conn->query("SELECT COUNT(rental_status) as total FROM rental_details WHERE rental_status = 'Pending Delivery'");
$num = $count_pending->fetch_assoc();

$total_user = $conn->query("SELECT * FROM users")->num_rows;
$pending_rent = $conn->query("SELECT * FROM pending_rent WHERE status = 'Pending'")->num_rows;
?>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Revenue'],
            <?php
            $chartRevenue = $conn->query("SELECT DISTINCT(MONTHNAME(rd.created_at)) AS month, SUM(p.amount) AS amount FROM rental_details rd, payments p WHERE rd.payment_id = p.payment_id GROUP BY MONTH(rd.created_at)");
            while($record = $chartRevenue->fetch_assoc()) {
                echo "['".$record['month']."',".$record['amount']."],";
            }
            ?>
        ]);

        var options = {
            title: 'Total Revenue Based On Month',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Category', 'Number of Products'],
        <?php
        $chartCategory = $conn->query("SELECT * FROM categories");
        while($category = $chartCategory->fetch_assoc()) {
            $catId = $category['catId'];
            $numCategory = $conn->query("SELECT * FROM products WHERE catId = '$catId'")->num_rows;
            echo "['". $category['catName'] ."',".$numCategory."],";
        }
        ?>
    ]);

    var options = {
        title: 'Categories',
        is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
    chart.draw(data, options);
    }
</script>

<style>
    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }

    @media print {
        body {
            visibility: hidden;
        }
        #dashboard{
            visibility: visible;
            position: absolute;
            top: 20px;
            width: 80%;
            font-size: 18px;
        }
    }
</style>

<div class="container-fluid" id="dashboard">
    <!-- <div class="row">
        <div class="col-md-12"> -->
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0 d-sm-flex align-items-center justify-content-between mb-2">
                    <h4 class="text-uppercase font-weight-bold">Dashboard</h4>
                    <a class="d-none d-sm-inline-block btn btn-primary shadow-sm" href="#" onclick="window.print()">
                        <i class='bx bx-download text-white-50'></i>
                        Generate Report
                    </a>
                </div>
            </div>
                <div class="row">
                    <!-- Earnings (Monthly) Card Sample -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left border-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase">Total Annual Revenue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">RM <?php echo $total; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class='bx bxs-calendar-alt bx-md text-muted pr-2'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total User Card Sample -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" onclick="window.location.href='main.php?view-users'">
                        <div class="card border-left border-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase">Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_user; ?></div>
                                    </div>
                                    <div class="col-auto">
                                    <i class='bx bx-user bx-md text-muted pr-2'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Rent Card Sample -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" onclick="window.location.href='main.php?view-rental'">
                        <div class="card border-left border-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase">Pending Rent</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending_rent; ?></div>
                                    </div>
                                    <div class="col-auto">
                                    <i class='bx bx-timer bx-md text-muted pr-2'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Example -->
                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left border-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-2 font-weight-bold text-gray-800">50%</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2" style="height: 10px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class='bx bx-clipboard bx-md text-muted pr-2'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Pending Request -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" onclick="window.location.href='main.php?view-delivery'">
                        <div class="card border-left border-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase">Pending Delivery</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $num['total']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class='bx bxs-truck bx-md text-muted pr-2'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-7" id="line-chart">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row aligh-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="mh-100 mw-100" id="curve_chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row aligh-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Product Categories</h6>
                                </div>
                                <div class="card-body">
                                    <div class="pie-chart">
                                    <div class="mh-100 mw-100" id="piechart_3d"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row aligh-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">User Login</h6>
                                </div>
                                <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col">ID</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Login Time</th>
                                                <th scope="col">Logout Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $login = $conn->query("SELECT * FROM login ORDER BY id DESC");
                                            while($row = $login->fetch_assoc()):
                                                $id = $row['id']; 
                                                $username = $row['username'];
                                                $role = $row['role'];
                                                $loginDateTime = $row['loginDateTime'];
                                                $logoutDateTime = $row['logoutDateTime'];  
                                                if($role == 'Admin') { ?>
                                                    <tr class="table-primary">
                                                <?php } else { ?>
                                                    <tr class="table-secondary">
                                                <?php } ?>
                                                        <td><?php echo $id; ?></td>
                                                        <td><?php echo $username; ?></td>
                                                        <td><?php echo $role; ?></td>
                                                        <td><?php echo $loginDateTime; ?></td>
                                                        <td><?php echo $logoutDateTime; ?></td>
                                                    </tr>
                                            <?php endwhile ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div>
        </div>
    </div> -->
</div>