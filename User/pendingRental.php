<!-- CSS only -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
<!-- JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->

<?php 
include './Partials/nav.php'; 

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
} else {
    header("Location: index.php");
    exit();
}
?>

<style>
    .my-custom-scrollbar {
        position: relative;
        height: 500px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }
</style>

<div class="col-md-12 col-11 mx-auto">
    <nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rental</li>
    </ol>
    </nav>
</div>

<div class="py-3">
    <div class="container" style="min-height:30vh;">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center"><strong>Rental</strong></h1><hr>    
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link active" id="pending-tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link" id="history-tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">History</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="row d-flex justify-content-center">
                        <?php 
                        $rentId = $conn->query("SELECT DISTINCT * FROM pending_rent WHERE email = '$email' AND status = 'Pending' LIMIT 1");
                        if($rentId->num_rows > 0) {
                            $row = $rentId->fetch_assoc(); ?>
                                <div class="card col-md-8 p-0 mx-1">
                                    <div class="card-body">
                                        <?php $pending_rental = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND status = 'Pending'");
                                        if(mysqli_num_rows($pending_rental) > 0) { ?>
                                            <table class="table text-center table-sm table-responsive w-100 d-block d-md-table p-0">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product ID</th>
                                                        <th scope="col">Start Date</th>
                                                        <th scope="col">End Date</th>
                                                        <th scope="col">Rent Days</th>
                                                        <th scope="col">Rental Fees</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $i = 1; 
                                                    $rentFees = 0.00;
                                                    $delFees = 5.60;
                                                    while ($item = $pending_rental->fetch_assoc()): 
                                                        $prodId = $item['prodId'];
                                                        $rentFees +=  number_format((float)$item['rentFees'],2);
                                                        $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
                                                        if(mysqli_num_rows($product) == 1) {
                                                            $prodInfo = mysqli_fetch_assoc($product); ?>
                                                            <tr>
                                                                <th scope="row"><?php echo $i; ?></th> 
                                                                <td>
                                                                    <?php echo $item['prodId']; ?><br>
                                                                    <img src="../Owner/Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';" style="width: 100px; height: 100px;">
                                                                </td>
                                                                <td><?php echo $item['startDate']; ?></td>
                                                                <td><?php echo $item['endDate']; ?></td>
                                                                <td><?php echo $item['rentDay']; ?></td>
                                                                <td>RM <?php echo number_format((float)$item['rentFees'],2); ?></td>
                                                                <td class="col-sm-1">
                                                                    <button type="button" class="btn btn-danger btnCancel" value="<?php echo $item['rentId'];?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php $i++; endwhile; ?>
                                                </tbody>
                                            </table>
                                        <?php } else { 
                                            $rentFees = 0.00;
                                            $delFees = 0.00; ?>
                                            <small class="text-muted">There is no any pending rental to proceed.</small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card col-md-3 p-0 mx-1">
                                    <div class="card-header">
                                        <h5 class="text-uppercase text-center font-weight-bold text-dark">Summary</h5>
                                        <!-- <input type="hidden" id="rentId" name="rentId" value="<?php echo $row['rentId']; ?>"> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group d-flex justify-content-between">
                                            <h6 class="d-inline">Subtotal(RM): </h6>
                                            <h6 class="d-inline"><span><?php echo number_format((float)$rentFees,2); ?></span></h6>
                                        </div>
                                        <div class="form-group d-flex justify-content-between">
                                            <h6 class="d-inline">Delivery Fees(RM): </h6>
                                            <h6 class="d-inline"><span><?php echo number_format((float)$delFees,2); ?></span></h6>
                                        </div>
                                        <hr>
                                        <div class="form-group d-flex justify-content-between">
                                            <h6 class="d-inline">Total Rental Fees(RM): </h6>
                                            <?php $totalFees = $rentFees + $delFees; ?>
                                            <h6 class="d-inline"><span><?php echo number_format((float)$totalFees,2); ?></span></h6>
                                        </div>
                                        <hr>
                                        <button type="button" class="btn btn-success col" id="btnPayment">Make Payment</button>
                                    </div>
                                </div>
                        <?php } else { ?>
                            <small class="text-muted small">No Pending Rental.</small>
                            <!-- <script>window.open("./main.php", "_self");</script> -->
                        <?php } ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <?php
                    $email = $userInfo['email'];
                    $rent_history = $conn->query("SELECT * FROM rental_details WHERE email = '$email'");
                    if($rent_history->num_rows > 0) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th scope="col">#</th>
                                            <th scope="col">Rental ID</th>
                                            <th scope="col">Payment ID</th>
                                            <th scope="col">Tracking NO.</th>
                                            <th scope="col">Rent Quantity</th>
                                            <th scope="col">Total Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        while($record = $rent_history->fetch_assoc()):
                                        $rentId = $record['rental_id'];
                                        $payId = $record['payment_id'];
                                        $rentQty = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rentId'")->num_rows; 
                                        $payment = $conn->query("SELECT * FROM payments WHERE payment_id = '$payId '")->fetch_assoc(); ?>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#<?php echo $rentId; ?>" aria-expanded="false" aria-controls="<?php echo $rentId; ?>">+</button></td>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo $record['rental_id']; ?></td>
                                            <td><?php echo $record['payment_id']; ?></td>
                                            <td><?php echo $record['tracking_no']; ?></td>
                                            <td><?php echo $rentQty; ?></td>
                                            <td><?php echo $payment['amount']; ?></td>
                                        </tr>
                                        <tr class="collapse text-left" id="<?php echo $rentId; ?>">
                                            <td colspan="7">
                                                <?php $product = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rentId'"); 
                                                $j = 1;
                                                while($result = $product->fetch_assoc()):?>
                                                    <div class="row">
                                                        <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                                            <?php echo $j; ?>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <b>Product ID: </b><?php echo $result['prodId']; ?> &nbsp;&nbsp;
                                                            <b>Rental Fees: </b><?php echo $result['rentFees']; ?> &nbsp;&nbsp;
                                                            <b>Start Date: </b><?php echo $result['startDate']; ?> &nbsp;&nbsp;
                                                            <b>End Date: </b><?php echo $result['endDate']; ?>
                                                        </div>
                                                        <div class="col-sm-2 d-flex align-items-center justify-content-end">
                                                            <button type="button" class="btn btn-secondary btn-sm mb-2 col-12" onclick="window.location.href='product_details.php?prodId=<?php echo $result['prodId']; ?>'"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</button>
                                                        </div>
                                                    </div>
                                                <?php $j++; endwhile; ?>
                                            </td>
                                        </tr>
                                        <?php $i++; endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else { ?>
                        <small class="text-muted small">No Previos History.</small>
                    <?php } ?>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript" src="JS/wishlist.js"></script>
<?php include './rental_process.php'; ?>
<?php include './Partials/footer.php'; ?>
<?php include './Partials/chatbot.php'; ?>

<script>  
    $(document).ready(function () {
        $('#btnPayment').click(function () {
            email = "<?php echo $email; ?>";
            rentId = "<?php echo $row['rentId']; ?>";
            totalPrice = "<?php echo number_format((float)$totalFees,2); ?>";

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "getRentalDetails" + "&email=" + email + "&rentId=" + rentId,
                success: function(html) {
                    obj = JSON.parse(html);
                    $('#deliveryAdd').modal('show');
                    $('#rentId').val(obj.rentId);
                    $('#totalPrice').val(totalPrice);
                    $('#email').val(obj.email);

                    var address = Object.values(obj.addId);
                    var addId = document.getElementById("addId");
                    for(i = 0; i < address.length; i++) {
                        var option = document.createElement("option");
                        option.text = address[i];
                        addId.add(option, address[i]);
                        // if(address[i] == "ADD2") {
                        //     addId.options[address[i]].selected = 'selected';
                        // }
                    }
                    showAddId();

                    var payMethod = Object.values(obj.methodId);
                    var methodId = document.getElementById("methodId");
                    for (let i = 0; i < payMethod.length; i++) {
                        var option = document.createElement("option");
                        option.text = payMethod[i];
                        methodId.add(option, payMethod[i]);
                    }
                    showPayMthId()
                }
            });

            // $('#rentalProcess').modal('show');
            // $('#rentId').val(rentId);
            // $('#email').val(email);
        });
    });

    $(document).ready(function () {
        $('.btnCancel').click(function () {
            rentId = $(this).val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "cancelRental" + "&rentId=" + rentId,
                success: function(html) {
                    if(html == "true") {
                        redirect("Your rental has been cancelled");
                    } else {
                        errorRedirect("Something went wrong. Try again later.");
                    }
                }
            });
            return false;
        });
    });
</script>