<link rel="stylesheet" href="./CSS/product.css"/>
<?php 
include './nav.php';
include './config/constant.php';

$result = $conn->query('SELECT * FROM sell_category')
?>

   
   <link href="./CSS/index.css" rel="stylesheet" type="text/css"/>
   

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Product Categories</h1>
                    <hr>
                    <div class="row">
                        <!-- <div class="content-wrapper"> -->
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="col-md-6 mb-4">
                                <!-- <a class="text-muted" href="product_list.php?catId=<?php echo $row['cat_id']; ?>"> -->
                                    <img src="./Images/<?php echo $row['image']; ?>" alt="Conscious Picture" class="" height="300px">
                                    <p> <?php echo $row['category_name']; ?></p>
                                    <div class="more">
                                        <a href="product_list.php?catId=<?php echo $row['cat_id']; ?>">View More</a>
                                    </div>
                                <!-- </a> -->
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php include './footer.php'; ?>
        <?php include './chatbot.php'; ?>