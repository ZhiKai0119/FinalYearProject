<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) { 
                $id = $_GET['id'];
                $product = $conn->query("SELECT * FROM products WHERE prodId = '$id'");
                if (mysqli_num_rows($product) > 0) { 
                    $data = mysqli_fetch_array($product);
                ?>
                <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Edit Products</h4>
                </div>
                <div class="card-body bg-transparent">
                    <form action="process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="product_id" value="<?php echo $id;?>">
                                <label class="mb-0">Select Category</label>
                                <select name="category_id" class="custom-select mb-2">
                                    <option selected>Select Category</option>
                                    <?php
                                        $categories = $conn->query("SELECT * FROM categories");
                                        if(mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $item) {
                                                ?>
                                                    <option value="<?php echo $item['catId'];?>" <?php echo $data['catId'] == $item['catId']?'selected':'' ?>><?php echo $item['catName'];?></option>
                                                <?php
                                            }
                                        } else {
                                            echo "No category available";
                                        }
                                    ?>                                          
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Name</label>
                                <input type="text" name="name" value="<?php echo $data['prodName'];?>" placeholder="Enter Product Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Small Description</label>
                                <textarea rows="3" name="small_description" placeholder="Enter Small Description" class="form-control mb-2"><?php echo $data['small_description'];?></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"><?php echo $data['description'];?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Product Price</label>
                                <input type="text" name="product_price" value="<?php echo $data['prodPrice'];?>" placeholder="Enter Product Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Original Price</label>
                                <input type="text" name="original_price" value="<?php echo $data['original_price'];?>" placeholder="Enter Original Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Rental Price</label>
                                <input type="text" name="rental_price" value="<?php echo $data['rental_price'];?>" placeholder="Enter Rental Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2">
                                <label class="mb-0">Current Image</label>
                                <input type="hidden" name="old_image" value="<?php echo $data['image'];?>">
                                <img src="Images/<?php echo $data['image'];?>" height="50px" width="50px" alt="">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Available Status</label>
                                <input type="checkbox" <?php echo $data['status']? "checked":""; ?> name="status">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Trending</label>
                                <input type="checkbox" <?php echo $data['trending']? "checked":""; ?> name="trending">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords" class="form-control mb-2"><?php echo $data['meta_keywords'];?></textarea>
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