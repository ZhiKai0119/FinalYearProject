<div class="card-body bg-transparent" id="category_table">
    <table class="table table-bordered table-striped text-center table-responsive-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $category = $conn->query("SELECT * FROM sell_category");
                if(mysqli_num_rows($category) > 0) {
                while ($item = $category->fetch_assoc()):?>
                    <tr>
                        <td><?php echo $item['cat_id'];?></td>
                        <td><?php echo $item['category_name'];?></td>
                        <td>
                            <img src="../Jensen/Images/<?php echo $item['image'];?>" width="50px" alt="<?php echo $item['catName'];?>">
                        </td>
                        <td class="col-sm-1">
                            <a href="main.php?edit-sCategory&id=<?php echo $item['cat_id'];?>" class="btn btn-primary">&nbsp;Edit&nbsp;</a>
                        </td>
                        <td class="col-sm-1">
                            <form action="../Jensen/process/product.php" method="POST">
                                <input type="hidden" name="category_id" value="<?php echo $item['cat_id'];?>">
                                <button type="submit" class="btn btn-danger" name="delete_category_btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; } ?>
        </tbody>
    </table>
</div>