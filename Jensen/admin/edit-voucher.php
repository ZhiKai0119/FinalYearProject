<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $voucher = $conn->query("SELECT * FROM sell_voucher WHERE voucherId = '$id'");
                if (mysqli_num_rows($voucher) > 0) { 
                    $data = mysqli_fetch_array($voucher);
                ?>
                <div class="card-body bg-transparent">
                    <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Voucher ID</label>
                                <input type="text" readonly name="vID" class="form-control mb-2" value="<?php echo $data['voucherId']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Title</label>
                                <input type="text" name="title" class="form-control mb-2" value="<?php echo $data['title']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Redeem Code</label>
                                <input type="text" readonly name="redeemCode" class="form-control mb-2" value="<?php echo $data['redeemCode']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Voucher Value</label>
                                <input type="text" name="vValue" class="form-control mb-2" value="<?php echo $data['voucher_value']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Maximum Redeem Value</label>
                                <input type="text" name="maxValue" class="form-control mb-2" value="<?php echo $data['max_redeem']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Minimum Spend</label>
                                <input type="text" name="minSpend" class="form-control mb-2" value="<?php echo $data['minSpend']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control mb-2" value="<?php echo $data['quantity']; ?>" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Voucher Status</label>
                                <select name="vStatus" id="vStatus" class="form-control mb-2" value="<?php echo $data['voucherStatus']; ?>">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="edit_voucher">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php 
                } else {
                    echo "Category not found";
                }
            } else {
                echo "ID Missing from url";
            } ?>
        </div>
    </div>
</div>