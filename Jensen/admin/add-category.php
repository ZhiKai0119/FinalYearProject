<?php
$query = "SELECT * FROM sell_category ORDER BY cat_id desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$lastId = $row['cat_id'];
if($lastId == "") {
    $cat_id = "CAT2001";
} else {
    $cat_id = substr($lastId, 3);
    $cat_id = intval($cat_id);
    $cat_id = "CAT".($cat_id + 1);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Add Selling Category</h4>
                </div>
                <div class="card-body bg-transparent">
                    <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Category ID</label>
                                <input type="text" readonly name="catID" class="form-control mb-2" value="<?php echo $cat_id; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Category Name</label>
                                <input type="text" name="name" placeholder="Enter Category Name" class="form-control mb-2">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-4">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
