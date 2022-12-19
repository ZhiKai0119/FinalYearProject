<link rel="stylesheet" href="CSS/pagination.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Pending Return</h4>
                </div>
                <div class="card-body bg-transparent" id="rental_table">
                    <table class="table table-bordered text-center table-sm table-responsive w-100 d-block d-md-table" id="tblRental" cellspacing="0">
                        <thead class="bg-dark text-light">
                            <th scope="col">#</th>
                            <th scope="col">Rental ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Return Date</th>
                            <th scope="col">Remain Days</th>
                            <th scope="col">Return</th>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $rental_details = $conn->query("SELECT * FROM rental_details WHERE rental_status = 'Customer Received'");
                            while($rental = $rental_details->fetch_assoc()):
                                $rental_id = $rental['rental_id'];
                                $pending_rental = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rental_id' AND status = 'Pending Return'");   
                                if(mysqli_num_rows($pending_rental) > 0) {
                                    while($item = $pending_rental->fetch_assoc()):
                            ?>
                                <tr>
                                    <form class="col-md" action="process/rental.php" method="POST">
                                        <td><?php echo $i?></td>
                                        <td><?php echo $item['rentId'];?></td>
                                        <td><?php echo $item['email'];?></td>
                                        <td><?php echo $item['prodId'];?></td>
                                        <td><?php echo $item['endDate'];?></td>
                                        <td>
                                            <?php
                                            $todayDate = date("Y-m-d");
                                            $returnDate = $item['endDate'];
                                            $diff = strtotime($returnDate) - strtotime($todayDate);
                                            $days = round($diff/86400);
                                            echo $days;
                                            ?>
                                            <input type="hidden" id="email" name="email" value="<?php echo $item['email'];?>">
                                            <input type="hidden" id="prodId" name="prodId" value="<?php echo $item['prodId'];?>">
                                            <input type="hidden" id="remainDay" name="remainDay" value="<?php echo $days; ?>">
                                        </td>
                                        <td class="col-sm-1">
                                            <input type="hidden" id="rental_id" name="rental_id" value="<?php echo $item['rentId'];?>">
                                            <button type="submit" class="btn btn-primary btn-sm" id="btnReturn" name="btnReturn">Received</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php $i++; endwhile; } endwhile;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>