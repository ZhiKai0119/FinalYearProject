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
                $product = $conn->query("SELECT * FROM sell_product");
                if(mysqli_num_rows($product) > 0) {
                    foreach ($product as $item) {?>
                        <tr>
                            <td><?php echo $item['product_code'];?></td>
                            <td><?php echo $item['product_name'];?></td>
                            <td>
                                <img src="../Jensen/Images/<?php echo $item['image'];?>" width="50px" alt="">
                            </td>
                            <td><?php echo $item['available'] ;?></td>
                            <td class="col-sm-1">
                                <a href="main.php?edit-sProduct&id=<?php echo $item['product_code'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                            </td>
                            <td class="col-sm-1">
                                <form action="../Jensen/process/product.php" method="POST">
                                    <input type="hidden" name="product_code" value="<?php echo $item['product_code'];?>">
                                    <button type="submit" class="btn btn-danger" name="delete_selling_prod">Delete</button>
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
