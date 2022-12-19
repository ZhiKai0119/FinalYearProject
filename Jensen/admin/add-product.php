<?php
$query = "SELECT * FROM sell_product ORDER BY product_code desc limit 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$lastId = $row['product_code'];
if($lastId == "") {
    $product_code = "P1001";
} else {
    $product_code = substr($lastId, 1);
    $product_code = intval($product_code);
    $product_code = "P".($product_code + 1);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Add Selling Products</h4>
                </div>
                <div class="card-body bg-transparent">
                    <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Select Category</label>
                                <select name="category_id" class="custom-select mb-2">
                                    <option selected>Select Category</option>
                                    <?php
                                        $categories = $conn->query("SELECT * FROM sell_category");
                                        if(mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $item) {
                                                ?>
                                                    <option value="<?php echo $item['cat_id'];?>"><?php echo $item['category_name'];?></option>
                                                <?php
                                            }
                                        } else {
                                            echo "No category available";
                                        }
                                    ?>                                          
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Product Name</label>
                                <input type="text" name="name" placeholder="Enter Product Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="desc" placeholder="Enter Description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Product Price</label>
                                <input type="text" name="product_price" placeholder="Enter Product Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Quantity</label>
                                <input type="number" name="prodQty" placeholder="Enter Quantity" class="form-control mb-2" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Product Code</label>
                                <input type="text" name="prodCode" readonly class="form-control mb-2" value="<?php echo $product_code; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Product Status</label>
                                <select name="status" id="status" class="form-control mb-2">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>