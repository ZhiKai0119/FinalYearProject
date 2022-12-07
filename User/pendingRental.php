<?php 
include './Partials/nav.php'; 

if(isset($userInfo['email'])) {
    $email = $userInfo['email'];
} else {
    $email = "";
}


$pending_rental = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND status = 'Pending'");

?>

<div class="col-md-10 col-11 mx-auto">
    <nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="main.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rental</li>
    </ol>
    </nav>
</div>

<div class="py-3">
    <div class="container" style="min-height:30vh;">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center"><strong>Pending Rental</strong></h1>
                <hr>
                <?php if(mysqli_num_rows($pending_rental) > 0) { ?>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Rental ID</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Rent Days</th>
                                <th scope="col">Rental Fees</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1; 
                            while ($item = $pending_rental->fetch_assoc()): 
                                $prodId = $item['prodId'];
                                $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
                                if(mysqli_num_rows($product) == 1) {
                                    $prodInfo = mysqli_fetch_assoc($product); ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $item['rentId']; ?></td>
                                        <td>
                                            <?php echo $item['prodId']; ?><br>
                                            <img src="../Owner/Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';" style="width: 100px; height: 100px;">
                                        </td>
                                        <td><?php echo $item['startDate']; ?></td>
                                        <td><?php echo $item['rentDay']; ?></td>
                                        <td>RM <?php echo number_format((float)$item['totalFees'],2); ?></td>
                                        <td class="col-sm-1">
                                            <button type="button" class="btn btn-primary btnProceed" value="<?php echo $item['rentId'];?>">Proceed</button>
                                        </td>
                                        <td class="col-sm-1">
                                            <button type="button" class="btn btn-danger btnCancel" value="<?php echo $item['rentId'];?>">Cancel</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php $i++; endwhile; ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <small class="text-muted">There is no any pending rental to proceed.</small>
                <?php } ?>
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
        $('.btnProceed').click(function () {
            email = "<?php echo $userInfo['email'];?>";
            rentId = $(this).val();

            $.ajax({
                type: "POST",
                url: "../process/user.php",
                data: "getRentalDetails" + "&email=" + email + "&rentId=" + rentId,
                success: function(html) {
                    obj = JSON.parse(html);
                    $('#rentalProcess').modal('show');
                    $('#rentId').val(rentId);
                    $('#email').val(email);
                    $('#prodId').val(obj.prodId);
                    document.getElementById("prodImg").src = "../Owner/Images/" + obj.prodImg;
                    $('#startDate').val(obj.startDate);
                    $('#endDate').val(obj.endDate);
                    $('#rentFees').val(Number(obj.rentFees).toFixed(2));
                    $('#deposit').val(Number(obj.deposit).toFixed(2));
                    $('#sTotal').val(Number(obj.totalFees).toFixed(2));

                    var sTotal = parseFloat(obj.totalFees);
                    var delFees = parseFloat(5.7);
                    var totalFees = sTotal + delFees;

                    $('#totalPay').val(Number(totalFees).toFixed(2));

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