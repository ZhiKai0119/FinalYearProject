<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <title>RNS Service - Products Catalog</title>
        <link rel="stylesheet" href="./CSS/product.css"/>
        <link rel="stylesheet" href="./CSS/pagination.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js" integrity="sha512-TToQDr91fBeG4RE5RjMl/tqNAo35hSRR4cbIFasiV2AAMQ6yKXXYhdSdEpUcRE6bqsTiB+FPLPls4ZAFMoK5WA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>

        <?php
        session_start();
        if (!isset($_SESSION['customerID'])) {
            echo "<h1>Warning</h1>";
            echo "<h2>No permission allowed to access this page</h2>";
            echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
            exit(); // Quit the script.
        }
        include './nav.php';
        include './config/constant.php';

        // $products = $conn->query("SELECT DISTINCT meta_keywords FROM products WHERE status = '1' ORDER BY meta_keywords ASC");
        // $data = array();
        // foreach($products as $row) {
        //     $data[] = array(
        //         'label'=>$row['meta_keywords'],
        //         'value'=>$row['meta_keywords']
        //     );
        // }

        $total_pages = $conn->query('SELECT * FROM product WHERE type = 2')->num_rows;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $num_results_on_page = 9;

        if ($stmt = $conn->prepare('SELECT * FROM product WHERE type = "fashion"  LIMIT ?,?')) {
            $calc_page = ($page - 1) * $num_results_on_page;
            $stmt->bind_param('ii', $calc_page, $num_results_on_page);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>


            <div class="py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center">Fashion Cloths Products <a class="link-dark mr-2" href="#filterProd" data-bs-toggle="offcanvas" role="button" aria-controls="filterProd"><i class="fa fa-bars float-end" style="font-size:35px;" aria-hidden="true"></i></a></h1>
                            <hr>
                            <div class="row" id="output">
                                <?php while ($item = $result->fetch_assoc()): ?>
                                    <div class="col-lg-4 col-md-4 mb-3">
                                        <div class="product-box" style="cursor: pointer;">
                                            <div class="product-inner-box position-relative">
                                                <div class="icons position-absolute">


                                                    <a href="product_details.php?prodId=<?php echo $item['id']; ?>" class="text-decoration-none text-dark bg-light"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="onsale">

        <!-- <input type="hidden" id="rentPrice" name="rentPrice" value="<?php // echo round($item['rental_price'],2);  ?>">
        <input type="hidden" id="prodPrice" name="prodPrice" value="<?php // echo round($item['prodPrice'],2);  ?>"> -->

                                                </div>
                                                <img src="<?php echo $item['product_image']; ?>" alt="" class="img-fluid" onclick="location.href = 'product_details.php?prodId=<?php echo $item['id']; ?>';">
                                            </div>
                                            <div class="product-info">
                                                <div class="product-name">
                                                    <h3 class="text-dark"><?php echo $item['product_name']; ?></h3>
                                                </div>
                                                <div class="product-price">
                                                    RM<span><?php echo $item['product_price']; ?></span>
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
                                            <li class="prev"><a href="fashion.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                            <li class="start"><a href="fashion.php?page=1">1</a></li>
                                            <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page - 2 > 0): ?><li class="page"><a href="fashion.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                        <?php if ($page - 1 > 0): ?><li class="page"><a href="fashion.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                        <li class="currentpage"><a href="fashion.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="fashion.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="fashion.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                            <li class="dots">...</li>
                                            <li class="end"><a href="fashion.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                            <li class="next"><a href="fashion.php?page=<?php echo $page + 1 ?>">Next</a></li>
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
            ?>

            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="filterProd" aria-labelledby="filterProdLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="filterProdLabel">Products Filtering</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- <div class="card-body"> -->
                    <div class="input-group rounded">
                        <input type="search" class="form-control rounded" name="keywords" id="keywords" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <span class="input-group-text border-0" id="search-addon">
                            <button type="button" class="btn shadow-none" id="btn-search"><i class="fas fa-search"></i></button>
                        </span>
                        <div class="list-group list-group-item-action" id="content"></div>
                        <!-- </div> -->
                    </div>
                    <!-- <div class="card-body">
                        <div class="list-group list-group-item-action" id="content"></div>
                    </div> -->

                    <p>Try scrolling the rest of the page to see this option in action.</p>
                    <div class="form-group row mb-3">
                        <h6 class="col-form-label">Date Range</h6>
                        <div class="col-sm input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" id="startDate" name="startDate">
                            <span class="input-group-text" id="addon-wrapping">TO</span>
                            <input type="text" class="input-sm form-control" id="endDate" name="endDate" onchange="calculateDate()">
                        </div>
                    </div>
                </div>
            </div>




            <script>
                $(document).ready(function () {
                    $('#keywords').keyup(function () {
                        var Keywords = $('#keywords').val();
                        if (Keywords != "") {
                            $.ajax({
                                type: "POST",
                                url: "process/search.php",
                                data: {keywords: Keywords},
                                success: function (html) {
                                    $('#content').html(html);
                                }
                            })
                        } else {
                            $('#content').html('');
                        }
                        $(document).on('click', 'a', function () {
                            $('#keywords').val($(this).text());
                            $('#content').html('');
                        })
                    })
                    $(document).on('click', '#btn-search', function () {
                        var value = $('#keywords').val();
                        $.ajax({
                            type: "POST",
                            url: "process/display.php",
                            data: {query: value},
                            success: function (html) {
                                if (html == "false") {
                                    $('#content').html(html);
                                } else {
                                    $('#output').html(html);
                                }
                            }
                        })
                    })
                })

                $(document).ready(function () {
                    $('.btnRent').click(function () {
                        email = "<?php echo $userInfo['email']; ?>";
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

            <?php include './footer.php'; ?>
            <?php include './chatbot.php'; ?>
    </body>
</html>
