<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Wishlist</title>
        <link rel="stylesheet" href="CSS/pagination.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            table {background-color: AliceBlue;}
            tr:hover {background-color: #f2f2f2;}
            th, td {border-bottom: 2px solid #ddd;}
            /* .maintxt {position: relative;}
            .maintxt > img, .overlay-text {position: absolute;} */
        </style>
    </head>
    <body>
        <?php   
        include './Partials/nav.php';
        
        if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
            $email = $userInfo['email'];
        } else {
            $email = "";
        }

        $total_pages = $conn->query("SELECT * FROM wishlist WHERE email = '$email'")->num_rows;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $num_results_on_page = 9;

        if ($stmt = $conn->prepare("SELECT * FROM wishlist WHERE email = '$email' LIMIT ?,?")) {
            $calc_page = ($page - 1) * $num_results_on_page;
            $stmt->bind_param('ii', $calc_page, $num_results_on_page);
            $stmt->execute(); 
            $result = $stmt->get_result();
        ?>

        <div class="col-md-10 col-11 mx-auto">
            <nav aria-label="breadcrumb" class="m-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
              </ol>
            </nav>
        </div>

        <div class="py-3">
            <div class="container" style="min-height:30vh;">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center"><strong>Wishlist</strong></h1>
                        <hr>
                        <?php if(mysqli_num_rows($result) > 0) { ?>
                            <table>
                                <tbody>
                            <!-- <ul class="list-group"> -->
                                    <?php while ($item = $result->fetch_assoc()): ?>
                                <!-- <li class="list-group-item bg-light"> -->
                                    <tr>
                                        <td>
                                            <div class="row" style="cursor: pointer;">
                                                <?php 
                                                $prodId = $item['prodId'];
                                                $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
                                                if(mysqli_num_rows($product) == 1) {
                                                    $prodInfo = mysqli_fetch_assoc($product); 
                                                    if($prodInfo['status'] == 1) { ?>
                                                        <div class="col-md-2">
                                                            <img src="../Owner/Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';" style="width: 100%; height: 130px;">
                                                        </div>
                                                        <div class="col-md-8" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';">
                                                            <?php 
                                                                $original = $prodInfo['original_price'];
                                                                $rental = $prodInfo['rental_price'];

                                                                $promotion = ($original-$rental)/$original*100;
                                                            ?>
                                                            <h6><?php echo $item['prodId']; ?> <span class="text-success"> <i class="fa fa-arrow-down"></i><?php echo round($promotion,2); ?>%</span></h6>
                                                            <h5 class="text-dark"><?php echo $prodInfo['prodName'];?></h5>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <h5><s class="text-danger">RM <?php echo round($prodInfo['original_price'],2); ?></s></h5>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h5><span class="font-weight-bold">RM <?php echo $prodInfo['rental_price']; ?></span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 my-auto">
                                                            <form action="../process/user.php" method="POST">
                                                                <input type="hidden" name="wishId" value="<?php echo $item['wishId']; ?>">
                                                                <button type="button" class="btn btn-secondary mb-1 pr-3" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</button>
                                                                <button type="submit" class="btn btn-danger pr-2" id="btnRemoveWish" name="btnRemoveWish" value="<?php echo $item['wishId']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Remove</button>
                                                            </form>
                                                        </div>

                                                    <?php } else { ?>
                                                        
                                                        <div class="col-md-2">
                                                            <div class="maintxt">
                                                                <img src="../Owner/Images/<?php echo $prodInfo['image']; ?>" alt="" class="img-fluid" style="width: 100%; height: 130px; opacity: 0.5;">
                                                                <span class="overlay-text text-danger" style="position: absolute; transform: rotate(-35deg); left: 30px; top: 50%;"><strong>NOT AVAILABLE</strong></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 text-muted" style="opacity: 0.5;">
                                                            <?php 
                                                                $original = $prodInfo['original_price'];
                                                                $rental = $prodInfo['rental_price'];

                                                                $promotion = ($original-$rental)/$original*100;
                                                            ?>
                                                            <h6><?php echo $item['prodId']; ?> <span class="text-success"> <i class="fa fa-arrow-down"></i><?php echo round($promotion,2); ?>%</span></h6>
                                                            <h5 class="text-dark"><?php echo $prodInfo['prodName'];?></h5>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <h5><s class="text-danger">RM <?php echo round($prodInfo['original_price'],2); ?></s></h5>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <h5><span class="font-weight-bold">RM <?php echo $prodInfo['rental_price']; ?></span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 my-auto">
                                                            <form action="../process/user.php" method="POST">
                                                                <input type="hidden" name="wishId" value="<?php echo $item['wishId']; ?>">
                                                                <button disabled type="button" class="btn btn-secondary mb-1 pr-3" onclick="location.href='product_details.php?prodId=<?php echo $prodInfo['prodId']; ?>';"><i class="fa fa-info-circle" aria-hidden="true"></i> Details</button>
                                                                <button type="submit" class="btn btn-danger pr-2" id="btnRemoveWish" name="btnRemoveWish" value="<?php echo $item['wishId']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Remove</button>
                                                            </form>
                                                        </div>
                                                    <?php } ?>
                                            <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <!-- </li> -->
                            <?php endwhile; ?>
                                </tbody>
                            </table>
                            <!-- </ul> -->

                            <div class="d-flex justify-content-center">
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                        <li class="prev"><a href="wishlist.php?page=<?php echo $page-1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                        <li class="start"><a href="wishlist.php?page=1">1</a></li>
                                        <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page-2 > 0): ?><li class="page"><a href="wishlist.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                                        <?php if ($page-1 > 0): ?><li class="page"><a href="wishlist.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                                        <li class="currentpage"><a href="wishlist.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="wishlist.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="wishlist.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                        <li class="dots">...</li>
                                        <li class="end"><a href="wishlist.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li class="next"><a href="wishlist.php?page=<?php echo $page+1 ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php } else { ?>
                            <small class="text-muted small">No Products Added Inside The Wishlist.</small>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $stmt->close();
        }
        ?>

        <script>
            function redirect(message) {
                var date = new Date();
                date.setTime(date.getTime() + (1*1000));
                var expires = "; expires= " + date.toGMTString();

                document.cookie = "status=" + message + expires + "; path=/";
                location.reload();
            }

            function errorRedirect(message) {
                var date = new Date();
                date.setTime(date.getTime() + (1*1000));
                var expires = "; expires= " + date.toGMTString();
                
                document.cookie = "failureStatus=" + message + expires + "; path=/";
                location.reload();
            }
        </script>

        <?php include './Partials/footer.php'; ?>
        <?php include './Partials/chatbot.php'; ?>
    </body>
</html>