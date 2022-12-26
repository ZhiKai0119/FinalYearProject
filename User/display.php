<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Products Catalog</title>
        <link rel="stylesheet" href="CSS/product.css"/>
        <link rel="stylesheet" href="CSS/pagination.css"/>
        <link rel="stylesheet" href="../CSS/bootstrap-4.0.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../CSS/bootstrap-5.0.2/dist/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js" integrity="sha512-TToQDr91fBeG4RE5RjMl/tqNAo35hSRR4cbIFasiV2AAMQ6yKXXYhdSdEpUcRE6bqsTiB+FPLPls4ZAFMoK5WA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>
        
        <?php   
        include './Partials/nav.php';

        if(isset($_GET['searchKey'])) {
            $searchKey = $_GET['searchKey'];

            $total_pages = $conn->query("SELECT * FROM products WHERE status = 1 AND meta_keywords LIKE '%".$searchKey."%' ORDER BY meta_keywords")->num_rows;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $num_results_on_page = 9;

            if ($stmt = $conn->prepare("SELECT * FROM products WHERE status = 1 AND meta_keywords LIKE '%".$searchKey."%' ORDER BY meta_keywords LIMIT ?,?")) {
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                $stmt->execute(); 
                $result = $stmt->get_result();
            ?>

            <div class="col-md-10 col-11 mx-auto">
                <nav aria-label="breadcrumb" class="m-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
                </nav>
            </div>
            
            <div class="py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">Products <a class="link-dark mr-2" role="button" href="javascript:openCanvas();"><i class="fa fa-bars float-end" style="font-size:35px;" aria-hidden="true"></i></a></h1>
                            <hr>
                            <div class="row" id="output">
                                <?php while ($item = $result->fetch_assoc()): ?>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <div class="product-box" style="cursor: pointer;">
                                        <div class="product-inner-box position-relative">
                                            <div class="icons position-absolute">
                                                <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                                <a class="text-decoration-none text-dark bg-light wishlist" value="<?php echo $item['prodId']; ?>"><i class="fa fa-heart" aria-hidden="true"></i></i></a>
                                                <a href="product_details.php?prodId=<?php echo $item['prodId']; ?>" class="text-decoration-none text-dark bg-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="onsale">
                                                <?php 
                                                $original = $item['original_price'];
                                                $rental = $item['rental_price'];

                                                $promotion = ($original-$rental)/$original*100;
                                                ?>
                                                <!-- <input type="hidden" id="rentPrice" name="rentPrice" value="<?php // echo round($item['rental_price'],2); ?>">
                                                <input type="hidden" id="prodPrice" name="prodPrice" value="<?php // echo round($item['prodPrice'],2); ?>"> -->
                                                <span class="badge rouunded-0 text-light"><i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo round($promotion,2); ?>%</span>
                                            </div>
                                            <img src="../Owner/Images/<?php echo $item['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $item['prodId']; ?>';">
                                            <div class="cart-btn">
                                                <button class="btn btn-light shadow-sm badge-pill badge-light btnRent" value="<?php echo $item['prodId']; ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> Rent It</button>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">
                                                <h3 class="text-dark"><?php echo $item['prodName'];?></h3>
                                            </div>
                                            <div class="product-price">
                                                RM<span><?php echo $item['rental_price']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>

                            <div class="d-flex justify-content-center">
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                        <li class="prev"><a href="display.php?page=<?php echo $page-1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                        <li class="start"><a href="display.php?page=1">1</a></li>
                                        <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page-2 > 0): ?><li class="page"><a href="display.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                                        <?php if ($page-1 > 0): ?><li class="page"><a href="display.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                                        <li class="currentpage"><a href="display.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="display.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="display.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                        <li class="dots">...</li>
                                        <li class="end"><a href="display.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li class="next"><a href="display.php?page=<?php echo $page+1 ?>">Next</a></li>
                                        <?php endif; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            $stmt->close();
            }
           
        } elseif(isset($_GET['startDate']) || isset($_GET['endDate'])) {
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];

            $total_pages = $conn->query("SELECT * FROM products p, pending_rent pr WHERE p.prodId = pr.prodId AND p.status = '1' AND pr.startDate < '$startDate'")->num_rows;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $num_results_on_page = 9;

            if ($stmt = $conn->prepare("SELECT * FROM products p, pending_rent pr WHERE p.prodId = pr.prodId AND p.status = '1' AND pr.startDate < '$startDate' LIMIT ?,?")) {
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                $stmt->execute(); 
                $result = $stmt->get_result();
            ?>

            <div class="col-md-10 col-11 mx-auto">
                <nav aria-label="breadcrumb" class="m-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
                </nav>
            </div>
            
            <div class="py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">Products <a class="link-dark mr-2" role="button" href="javascript:openCanvas();"><i class="fa fa-bars float-end" style="font-size:35px;" aria-hidden="true"></i></a></h1>
                            <hr>
                            <div class="row" id="output">
                                <?php while ($item = $result->fetch_assoc()): ?>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <div class="product-box" style="cursor: pointer;">
                                        <div class="product-inner-box position-relative">
                                            <div class="icons position-absolute">
                                                <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                                <a class="text-decoration-none text-dark bg-light wishlist" value="<?php echo $item['prodId']; ?>"><i class="fa fa-heart" aria-hidden="true"></i></i></a>
                                                <a href="product_details.php?prodId=<?php echo $item['prodId']; ?>" class="text-decoration-none text-dark bg-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="onsale">
                                                <?php 
                                                $original = $item['original_price'];
                                                $rental = $item['rental_price'];

                                                $promotion = ($original-$rental)/$original*100;
                                                ?>
                                                <!-- <input type="hidden" id="rentPrice" name="rentPrice" value="<?php // echo round($item['rental_price'],2); ?>">
                                                <input type="hidden" id="prodPrice" name="prodPrice" value="<?php // echo round($item['prodPrice'],2); ?>"> -->
                                                <span class="badge rouunded-0 text-light"><i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo round($promotion,2); ?>%</span>
                                            </div>
                                            <img src="../Owner/Images/<?php echo $item['image']; ?>" alt="" class="img-fluid" onclick="location.href='product_details.php?prodId=<?php echo $item['prodId']; ?>';">
                                            <div class="cart-btn">
                                                <button class="btn btn-light shadow-sm badge-pill badge-light btnRent" value="<?php echo $item['prodId']; ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> Rent It</button>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-name">
                                                <h3 class="text-dark"><?php echo $item['prodName'];?></h3>
                                            </div>
                                            <div class="product-price">
                                                RM<span><?php echo $item['rental_price']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>

                            <div class="d-flex justify-content-center">
                                <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                        <li class="prev"><a href="display.php?page=<?php echo $page-1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                        <li class="start"><a href="display.php?page=1">1</a></li>
                                        <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page-2 > 0): ?><li class="page"><a href="display.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                                        <?php if ($page-1 > 0): ?><li class="page"><a href="display.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                                        <li class="currentpage"><a href="display.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                        <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="display.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                        <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="display.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                        <li class="dots">...</li>
                                        <li class="end"><a href="display.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li class="next"><a href="display.php?page=<?php echo $page+1 ?>">Next</a></li>
                                        <?php endif; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            $stmt->close();
            }
        } else { ?>
            <script type="text/javascript"> 
                window.open('./products.php', '_self'); 
            </script>
        <?php } ?>

        <?php include './rental_modal.php'; ?>
        <script type="text/javascript" src="JS/wishlist.js"></script>

        <script>
            function openCanvas() {
                $('#filterProd').offcanvas('show');
            }

            $(document).ready(function() {
                $('.btnRent').click(function () {
                    email = "<?php echo $userInfo['email'];?>";
                    prodId = $(this).attr("value");

                    $.ajax({
                        type: "POST",
                        url: "../process/user.php",
                        data: "getProductInfo" + "&email=" + email + "&prodId=" + prodId,
                        success: function (html) {
                            obj = JSON.parse(html);
                            $('#rentDetail').modal('show');
                            $('#email').val(email);
                            $('#prodId').val(prodId);
                            getReservedDate(obj.rentDate);
                            $('#origFees').val(obj.rentalPrice);
                            prodPrice = obj.prodPrice;
                            calDeposit = (prodPrice * 0.10).toFixed(2);
                            if (calDeposit >= 100) {
                                $('#deposit').val();
                            } else {
                                $('#deposit').val(calDeposit);
                            }
                            changeRange();
                        }
                    });
                    return false;                    
                });

                $('#keywords').keyup(function() {
                    var Keywords = $('#keywords').val();
                    if(Keywords != "") {
                        $.ajax({
                            type: "POST",
                            url: "process/search.php",
                            data: {keywords:Keywords},
                            success: function(html) {
                                $('#content').html(html);
                            }
                        })
                    } else {
                        $('#content').html('');
                    }
                    $(document).on('click', 'a', function() {
                        $('#keywords').val($(this).text());
                        $('#content').html('');
                    })
                })
                
                $(document).on('click', '#btn-search', function() {
                    var value = $('#keywords').val();
                    window.location.href="./display.php?searchKey=" + value;
                })
            });

            $('.input-daterange').datepicker({
                format: "yyyy-mm-dd",
                startDate: "0d",
                endDate: "+60d",
                todayBtn: "linked",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });
        </script>

        <?php include './Partials/footer.php'; ?>
        <?php include './Partials/chatbot.php'; ?>
    </body>
</html>
