<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) { 
                $id = $_GET['id'];
                $product = $conn->query("SELECT * FROM sell_product WHERE product_code = '$id'");
                if (mysqli_num_rows($product) > 0) { 
                    $data = mysqli_fetch_array($product);
                ?>
                <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Edit Selling Products</h4>
                </div>
                <div class="card-body bg-transparent">
                    <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="product_id" value="<?php echo $id;?>">
                                <label class="mb-0">Select Category</label>
                                <select name="category_id" class="custom-select mb-2"?>
                                    <?php
                                        $categories = $conn->query("SELECT * FROM sell_category");
                                        if(mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $item) {
                                                ?>
                                                    <option value="<?php echo $item['cat_id'];?>" <?php echo $data['type'] == $item['cat_id']?'selected':'' ?>><?php echo $item['category_name'];?></option>
                                                <?php
                                            }
                                        } else {
                                            echo "No category available";
                                        }
                                    ?>                                          
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Name</label>
                                <input type="text" name="name" value="<?php echo $data['product_name'];?>" placeholder="Enter Product Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"><?php echo $data['description'];?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Product Price</label>
                                <input type="text" name="product_price" value="<?php echo $data['product_price'];?>" placeholder="Enter Product Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Quantity</label>
                                <input type="number" name="prodQty" placeholder="Enter Quantity" class="form-control mb-2" value="<?php echo $data['product_qty']; ?>" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2">
                                <label class="mb-0">Current Image</label>
                                <input type="hidden" name="old_image" value="<?php echo $data['image'];?>">
                                <img src="../Jensen/Images/<?php echo $data['image'];?>" height="50px" width="50px" alt="">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Product Status</label>
                                <select name="status" id="status" class="form-control mb-2" value="<?php echo $data['available']? "selected":""; ?> ">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="edit_product_btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
                } else {
                    echo "Product not found";
                }
            } else {
                echo "ID missing from url";
            }
            ?>
        </div>
    </div>
</div>