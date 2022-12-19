<?php
$query = "SELECT * FROM sell_voucher ORDER BY voucherId desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$lastId = $row['voucherId'];
if($lastId == "") {
    $voucherId = "V3001";
} else {
    $voucherId = substr($lastId, 1);
    $voucherId = intval($voucherId);
    $voucherId = "V".($voucherId + 1);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Voucher</h4>
                </div>
            </div>

            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link active" id="displayVoucher-tab" data-bs-target="#displayVoucher" type="button" role="tab" aria-controls="displayVoucher" aria-selected="true">Display All Voucher</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-bs-toggle="tab" class="nav-link" id="addNew-tab" data-bs-target="#addNew" type="button" role="tab" aria-controls="addNew" aria-selected="false">Add New Voucher</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="displayVoucher" role="tabpanel" aria-labelledby="displayVoucher-tab">
                <div class="card-body bg-transparent" id="products_table">
                        <table class="table table-bordered table-striped text-center table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>Voucher ID</th>
                                    <th>Title</th>
                                    <th>Redeem Code</th>
                                    <th>Voucher Value</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $product = $conn->query("SELECT * FROM sell_voucher");
                                    if(mysqli_num_rows($product) > 0) {
                                        foreach ($product as $item) {?>
                                            <tr>
                                                <td><?php echo $item['voucherId'];?></td>
                                                <td><?php echo $item['title'];?></td>
                                                <td><?php echo $item['redeemCode'];?></td>
                                                <td><?php echo $item['voucher_value'];?></td>
                                                <td><?php echo $item['quantity'];?></td>
                                                <td><?php echo $item['voucher_status'];?></td>
                                                <td class="col-sm-1">
                                                    <a href="main.php?edit-voucher&id=<?php echo $item['voucherId'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                                                </td>
                                                <td class="col-sm-1">
                                                <form action="../Jensen/process/product.php" method="POST">
                                                    <input type="hidden" name="voucherId" value="<?php echo $item['voucherId'];?>">
                                                    <button type="submit" class="btn btn-danger" name="delete_voucher">Delete</button>
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "No Records Found";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="addNew" role="tabpanel" aria-labelledby="addNew-tab">
                    <div class="card-body bg-transparent">
                        <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mb-0">Voucher ID</label>
                                    <input type="text" readonly name="vID" class="form-control mb-2" value="<?php echo $voucherId; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Title</label>
                                    <input type="text" name="title" class="form-control mb-2">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Redeem Code</label>
                                    <?php $code = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 6)), 0, 6) ?>
                                    <input type="text" readonly name="redeemCode" class="form-control mb-2" value="<?php echo $code; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0">Voucher Value</label>
                                    <input type="text" name="vValue" class="form-control mb-2">
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0">Maximum Redeem Value</label>
                                    <input type="text" name="maxValue" class="form-control mb-2">
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0">Minimum Spend</label>
                                    <input type="text" name="minSpend" class="form-control mb-2">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Quantity</label>
                                    <input type="number" min="1" name="quantity" class="form-control mb-2">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Voucher Status</label>
                                    <select name="vStatus" id="vStatus" class="form-control mb-2">
                                        <option value="Available">Available</option>
                                        <option value="Unavailable">Unavailable</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="create_voucher">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   