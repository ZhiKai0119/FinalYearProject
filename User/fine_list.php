<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Fine List</title>
        <link rel="stylesheet" href="CSS/pagination.css"/>
        <link rel="stylesheet" href="../CSS/bootstrap-5.0.2/dist/css/bootstrap.min.css">     
        <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=AdSkztRu2j-BUhPEP869O0jnt--TP2guml7TnkOcSeVfJ_5p1cxWKQ0Z1MoJSVPI2lnkFUvLc3Z_pWN6&currency=MYR"></script>
        <style>
            table {background-color: AliceBlue;}
            tr:hover {background-color: #f2f2f2;}
            th, td {border-bottom: 2px solid #ddd;}
            .nav-link:hover, .breadcrumb-item a {
                color: #333;
                text-decoration: none;
            }
            .my-custom-scrollbar {
                position: relative;
                height: 500px;
                overflow: auto;
            }
            .table-wrapper-scroll-y {
                display: block;
            }
        </style>
    </head>
    <body>
        <?php   
        include './Partials/nav.php';
        
        if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
            $email = $userInfo['email'];
        } else {
            $email = "";
        }

        $fine_record = $conn->query("SELECT * FROM fine WHERE email = '$email' AND pay_status = 'Pending'");
        ?>

        <div class="col-md-10 col-11 mx-auto">
            <nav aria-label="breadcrumb" class="m-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fine List</li>
              </ol>
            </nav>
        </div>

        <div class="py-3">
            <div class="container" style="min-height:30vh;">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center"><strong>Fine List</strong></h1><hr>
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
                                <div id="pay_info"></div>
                                <?php if(mysqli_num_rows($fine_record) > 0) { ?>
                                    <!-- <table>
                                        <tbody> -->
                                        <ul class="list-group">
                                            <?php while ($item = $fine_record->fetch_assoc()): ?>
                                            <!-- <tr>
                                                <td> -->
                                                <li class="list-group-item">
                                                    <div class="row" style="cursor: pointer;">
                                                        <?php 
                                                        $prodId = $item['prodId'];
                                                        $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
                                                        if(mysqli_num_rows($product) == 1) {
                                                            $prodInfo = mysqli_fetch_assoc($product); ?>
                                                            <div class="col-md-2">
                                                                <img src="../Owner/Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" style="width: 100%; height: 200px;">
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <h6 class="col-4 col-form-label font-weight-bold">Fine ID: </h6>
                                                                            <div class="col-sm">
                                                                                <input type="text" readonly class="form-control" id="fineId" name="fineId" value="<?php echo $item['fineId']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <h6 class="col-4 col-form-label font-weight-bold">Product ID: </h6>
                                                                            <div class="col-sm">
                                                                                <input type="text" readonly class="form-control" id="prodId" name="prodId" value="<?php echo $item['prodId']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <h6 class="col-2 col-form-label font-weight-bold">Product Name: </h6>
                                                                    <div class="col-sm">
                                                                        <textarea type="text" readonly class="form-control" id="prodName" name="prodName"><?php echo $prodInfo['prodName']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <h6 class="col-2 col-form-label font-weight-bold">Rental ID: </h6>
                                                                    <div class="col-sm">
                                                                        <input type="text" readonly class="form-control" id="rentId" name="rentId" value="<?php echo $item['rentId']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group row">
                                                                            <h6 class="col-5 col-form-label font-weight-bold">Days Late: </h6>
                                                                            <div class="col-sm">
                                                                                <input type="text" readonly class="form-control" id="late_days" name="late_days" value="<?php echo $item['late_days']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="form-group row">
                                                                            <h6 class="col-4 col-form-label font-weight-bold">Total Fine: RM</h6>
                                                                            <div class="col-sm">
                                                                                <input type="text" readonly class="form-control text-danger font-weight-bold" id="total_fine" name="total_fine" value="<?php echo $item['total_fine']; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-center" id="paypal-button-container"></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                                <!-- </td>
                                            </tr> -->
                                    <?php endwhile; ?>
                                        </ul>
                                        <!-- </tbody>
                                    </table> -->
                                <?php } else { ?>
                                    <small class="text-muted small">No Fine Should Be Pay.</small>
                                <?php } ?>
                            </div>

                            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                <?php 
                                $email = $userInfo['email'];
                                $fine_history = $conn->query("SELECT * FROM fine WHERE email = '$email' AND pay_status = 'Paid'");
                                if(mysqli_num_rows($fine_history) > 0) { ?>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Fine ID</th>
                                                <th scope="col">Rental ID</th>
                                                <th scope="col">Product ID</th>
                                                <th scope="col">Late Days</th>
                                                <th scope="col">Total Fine (RM)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            while($record = $fine_history->fetch_assoc()):?>
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $record['fineId']; ?></td>
                                                <td><?php echo $record['rentId']; ?></td>
                                                <td><?php echo $record['prodId']; ?></td>
                                                <td><?php echo $record['late_days']; ?></td>
                                                <td><?php echo $record['total_fine']; ?></td>
                                            </tr>
                                            <?php $i++; endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <small class="text-muted small">No Previos History.</small>
                                <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <script>
            function redirect(message) {
                var date = new Date();
                date.setTime(date.getTime() + (1*1000));
                var expires = "; expires= " + date.toGMTString();

                document.cookie = "status=" + message + expires + "; path=/";
                location.reload();
            }

            function errorRedirect(message) {
                var date = new Date();
                date.setTime(date.getTime() + (1*1000));
                var expires = "; expires= " + date.toGMTString();
                
                document.cookie = "failureStatus=" + message + expires + "; path=/";
                location.reload();
            }

            paypal.Buttons({
                createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                    amount: {
                        value: Number($('#total_fine').val()).toFixed(2)
                    }
                    }]
                });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);

                    var fineId = $('#fineId').val();
                    var rentId = $('#rentId').val();

                    $.ajax({
                      type: "POST",
                      url: "../process/user.php",
                      data: "payFine" + "&fineId=" + fineId + "&rentId=" + rentId,
                      success: function(html) {
                        if(html == "success") {
                          redirect("Rental Placed Successfully");
                        } else {
                          $("#pay_info").html('<div class="alert alert-danger"><strong>Error</strong> processing request. Please try again.</div>');
                          alert(html);
                        }
                      }
                    });
                });
                }
            }).render('#paypal-button-container');
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
        <script src="../CSS/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        <?php include './Partials/footer.php'; ?>
        <?php include './Partials/chatbot.php'; ?>
    </body>
</html>