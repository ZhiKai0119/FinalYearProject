

<?php

// if (!isset($_SESSION['customerID'])) {
//     echo "<h1>Warning</h1>";
//     echo "<h2>No permission allowed to access this page</h2>";
//     echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
//     exit(); // Quit the script.
// }
include './config/constant.php';
include './nav.php';
$total_pages = $conn->query('SELECT * FROM product WHERE type = 2')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 9;

if ($stmt = $conn->prepare('SELECT * FROM product LIMIT ?,?')) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>


    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="author" content="Sahil Kumar">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title></title>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
        </head>

        <body>
            <div class="col-md-12">
                <h1 class="text-center"> Products </h1>


                <!-- Displaying Products Start -->
                <div class="container">
                    <div id="message"></div>
                    <div class="row mt-2 pb-3">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM product");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                <div class="card-deck">
                                    <div class="card p-2 border-secondary mb-2">
                                        <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
                                        <div class="card-body p-1">
                                            <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
                                            <h5 class="card-text text-center text-danger">RM &nbsp;&nbsp;<?= number_format($row['product_price'], 2) ?>/Unit</h5>

                                        </div>
                                        <div class="card-footer p-1">
                                            <form action="" class="form-submit">
                                                <div class="row p-2">
                                                    <div class="col-md-6 py-1 pl-4">
                                                        <b>Quantity : </b>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                                                    </div>
                                                </div>
                                                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                                                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">

                                                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                                                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                                                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                                                    cart</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        ?>
                        <div class="d-flex justify-content-center">
                            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="prev"><a href="product.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                    <?php endif; ?>

                                    <?php if ($page > 3): ?>
                                        <li class="start"><a href="product.php?page=1">1</a></li>
                                        <li class="dots">...</li>
                                    <?php endif; ?>

                                    <?php if ($page - 2 > 0): ?><li class="page"><a href="product.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                    <?php if ($page - 1 > 0): ?><li class="page"><a href="product.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                    <li class="currentpage"><a href="product.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="products.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="products.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                        <li class="dots">...</li>
                                        <li class="end"><a href="product.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                    <?php endif; ?>

                                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li class="next"><a href="product.php?page=<?php echo $page + 1 ?>">Next</a></li>
                                        <?php endif; ?>
                                </ul>
                                <?php
                            endif;
                        }
                        ?>
                    </div>

                </div>
            </div>
            <!-- Displaying Products End -->

            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

            <script type="text/javascript">
                $(document).ready(function () {

                    // Send product details in the server
                    $(".addItemBtn").click(function (e) {
                        e.preventDefault();
                        var $form = $(this).closest(".form-submit");
                        var pid = $form.find(".pid").val();
                        var pname = $form.find(".pname").val();
                        var pprice = $form.find(".pprice").val();
                        var pimage = $form.find(".pimage").val();
                        var pcode = $form.find(".pcode").val();

                        var pqty = $form.find(".pqty").val();

                        $.ajax({
                            url: 'action.php',
                            method: 'post',
                            data: {
                                pid: pid,
                                pname: pname,
                                pprice: pprice,
                                pqty: pqty,
                                pimage: pimage,
                                pcode: pcode
                            },
                            success: function (response) {
                                $("#message").html(response);
                                window.scrollTo(0, 0);
                                load_cart_item_number();
                            }
                        });
                    });

                    // Load total no.of items added in the cart and display in the navbar
                    load_cart_item_number();

                    function load_cart_item_number() {
                        $.ajax({
                            url: 'action.php',
                            method: 'get',
                            data: {
                                cartItem: "cart_item"
                            },
                            success: function (response) {
                                $("#cart-item").html(response);
                            }
                        });
                    }
                });
            </script>
    </body>

</html>
<?php include 'simpleFooter.php' ?>
<?php include 'chatbot.php' ?>