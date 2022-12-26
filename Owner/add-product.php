<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Add Products</h4>
                </div>
                <div class="card-body bg-transparent">
                    <form action="process/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Select Category</label>
                                <select name="category_id" class="custom-select mb-2">
                                    <option selected>Select Category</option>
                                    <?php
                                        $categories = $conn->query("SELECT * FROM categories");
                                        if(mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $item) {
                                                ?>
                                                    <option value="<?php echo $item['catId'];?>"><?php echo $item['catName'];?></option>
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
                                <input type="text" name="name" placeholder="Enter Product Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Small Description</label>
                                <textarea rows="3" name="small_description" placeholder="Enter Small Description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Product Price</label>
                                <input type="text" name="product_price" placeholder="Enter Product Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Original Rental Price</label>
                                <input type="text" name="original_price" placeholder="Enter Original Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Actual Rental Price</label>
                                <input type="text" name="rental_price" placeholder="Enter Rental Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Status</label>
                                <input type="checkbox" name="status">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Trending</label>
                                <input type="checkbox" name="trending">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords" class="form-control mb-2"></textarea>
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