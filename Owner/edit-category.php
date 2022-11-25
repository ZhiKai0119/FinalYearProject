<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) { 
                $id = $_GET['id'];
                $category = $conn->query("SELECT * FROM categories WHERE catId = '$id'");
                if (mysqli_num_rows($category) > 0) { 
                    $data = mysqli_fetch_array($category);
                ?>
                    <div class="card border-0 bg-transparent">
                    <div class="card-header border-0">
                        <h4 class="text-uppercase font-weight-bold">Edit Category</h4>
                    </div>
                    <div class="card-body bg-transparent">
                        <form action="process/category.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="category_id" value="<?php echo $id;?>">
                                    <label class="mb-0">Name</label>
                                    <input type="text" name="name" value="<?php echo $data['catName'];?>" placeholder="Enter Category Name" class="form-control mb-2">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Slug</label>
                                    <input type="text" name="slug" value="<?php echo $data['slug'];?>" placeholder="Enter Slug" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Description</label>
                                    <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"><?php echo $data['description'];?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Upload Image</label>
                                    <input type="file" name="image" class="form-control mb-2">
                                    <label class="mb-0">Current Image</label>
                                    <input type="hidden" name="old_image" value="<?php echo $data['image'];?>">
                                    <img src="Images/<?php echo $data['image'];?>" height="50px" width="50px" alt="">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Meta Title</label>
                                    <input type="text" name="meta_title" value="<?php echo $data['meta_title'];?>" placeholder="Enter Meta Title" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Meta Description</label>
                                    <textarea rows="3" name="meta_description" placeholder="Enter Meta Description" class="form-control mb-2"><?php echo $data['meta_description'];?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Meta Keywords</label>
                                    <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords" class="form-control mb-2"><?php echo $data['meta_keywords'];?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Status</label>
                                    <input type="checkbox" <?php echo $data['status']? "checked":""; ?> name="status">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Popular</label>
                                    <input type="checkbox" <?php echo $data['popular']? "checked":""; ?> name="popular">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
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
                echo "ID missing from url";
            }
            ?>
                
        </div>
    </div>
</div>
