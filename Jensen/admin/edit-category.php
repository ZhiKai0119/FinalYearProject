<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $category = $conn->query("SELECT * FROM sell_category WHERE cat_id = '$id'");
                if (mysqli_num_rows($category) > 0) { 
                    $data = mysqli_fetch_array($category);
                ?>
                <div class="card border-0 bg-transparent">
                    <div class="card-header border-0">
                        <h4 class="text-uppercase font-weight-bold">Edit Selling Category</h4>
                    </div>
                    <div class="card-body bg-transparent">
                        <form action="../Jensen/process/product.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="mb-0">Category ID</label>
                                    <input type="text" readonly name="catID" class="form-control mb-2" value="<?php echo $data['cat_id']; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Category Name</label>
                                    <input type="text" name="name" placeholder="Enter Category Name" class="form-control mb-2" value="<?php echo $data['category_name']; ?>">
                                </div>
                                
                                <div class="col-md-12">
                                    <label class="mb-0">Upload Image</label>
                                    <input type="file" name="image" class="form-control mb-4">
                                    <label class="mb-0">Current Image</label>
                                    <input type="hidden" name="old_image" value="<?php echo $data['image'];?>">
                                    <img src="../Jensen/Images/<?php echo $data['image'];?>" height="50px" width="50px" alt="">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="edit_category_btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
