//TODO: Pagination haven't do

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0">
                    <h4 class="text-uppercase font-weight-bold">Products</h4>
                </div>
            </div>
            <div class="card-body bg-transparent" id="products_table">
                <table class="table table-bordered table-striped text-center table-responsive-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $product = $conn->query("SELECT * FROM products");
                            if(mysqli_num_rows($product) > 0) {
                                foreach ($product as $item) {?>
                                    <tr>
                                        <td><?php echo $item['prodId'];?></td>
                                        <td><?php echo $item['prodName'];?></td>
                                        <td>
                                            <img src="Images/<?php echo $item['image'];?>" width="50px" alt="<?php echo $item['prodName'];?>">
                                        </td>
                                        <td><?php echo $item['status'] == '1'?"Available":"Unavailable";?></td>
                                        <td class="col-sm-1">
                                            <a href="main.php?edit-product&id=<?php echo $item['prodId'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                                        </td>
                                        <td class="col-sm-1">
                                            <button type="submit" class="btn btn-danger delete_product_btn" value="<?php echo $item['prodId'];?>">Delete</button>
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
    </div>
</div>