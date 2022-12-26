<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
include './config/constant.php';
include './nav.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
} else {
    header("Location: index.php");
    exit();
}

$conn->query("UPDATE sell_product SET available = 'Unavailable' WHERE product_qty = 0");

if(isset($_GET['catId'])){
    $catId = $_GET['catId'];
    $query = "SELECT * FROM sell_product WHERE type = '$catId' AND available = 'Available'";
    $query2 = "SELECT * FROM sell_product WHERE type = '$catId' AND available = 'Available' LIMIT ?,?";
} else {
    $query = "SELECT * FROM sell_product WHERE available = 'Available'";
    $query2 = "SELECT * FROM sell_product WHERE available = 'Available' LIMIT ?,?";
}

$total_pages = $conn->query($query)->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 12;

if ($stmt = $conn->prepare($query2)) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 ml-3 p-0">
                <h1 class="text-center"> Products </h1><hr>
                <div id="message"></div>
                <div class="row" id="output">
                    <?php while ($item = $result->fetch_assoc()): ?>
                        <div class="col-lg-3 col-md-4 mb-3 mx-3 d-flex justify-content-center">
                            <div class="product-box" style="cursor: pointer;">
                                <div class="product-inner-box position-relative">
                                    <div class="product-image">
                                        <img src="./Images/<?php echo $item['image']; ?>" alt="Conscious Picture" class="img-fluid" style="height: 300px;">
                                    </div>
                                    <div class="product-detail">
                                        <h5 class="text-center"><?php echo $item['product_name']; ?></h5>
                                        <h5 class="text-center">RM <?php echo $item['product_price']; ?></h5>
                                        <div class="text-center row">
                                            <a href="product_details.php?prodCode=<?php echo $item['product_code']; ?>" class="btn btn-sm col-sm-5 mr-1">View More</a>
                                            <form action="" class="form-submit col-sm-6">
                                                <input type="hidden" name="email" class="email" value="<?php echo $email; ?>">
                                                <input type="hidden" name="prodCode" class="prodCode" value="<?php echo $item['product_code']; ?>">
                                                <input type="hidden" name="prodPrice" class="prodPrice" value="<?php echo $item['product_price']; ?>">
                                                <input type="hidden" name="prodQty" class="prodQty" value="1">
                                                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;Add cart</button>
                                            </form>
                                            
                                        </div>
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
                            <li class="prev"><a href="product_list.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3): ?>
                            <li class="start"><a href="product_list.php?page=1">1</a></li>
                            <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page - 2 > 0): ?><li class="page"><a href="product_list.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                        <?php if ($page - 1 > 0): ?><li class="page"><a href="product_list.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="product_list.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="product_list.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="product_list.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                            <li class="dots">...</li>
                            <li class="end"><a href="product_list.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                            <li class="next"><a href="product_list.php?page=<?php echo $page + 1 ?>">Next</a></li>
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

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

        <script type="text/javascript">
            $(document).ready(function () {

                $(".addItemBtn").click(function (e) {
                    e.preventDefault();
                    var $form = $(this).closest(".form-submit");
                    var email = $form.find(".email").val();
                    var prodCode = $form.find(".prodCode").val();
                    var prodQty = $form.find(".prodQty").val();
                    var prodPrice = $form.find(".prodPrice").val();
                    $.ajax({
                        url: 'process/action.php',
                        method: 'post',
                        data: {
                            addCart: "addCart",
                            email: email,
                            prodCode: prodCode,
                            prodQty: prodQty,
                            prodPrice: prodPrice
                        },
                        success: function (response) {
                            if(response == "success"){
                                $("#message").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Success!</strong> Item added to your cart.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
                            } else if(response == "over") {
                                $("#message").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Failed!</strong> The quantity exceed the actual value.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
                            } else{
                                $("#message").html("<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Failed!</strong> Item not added to your cart.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
                            }
                            window.scrollTo(0, 0);
                            // load_cart_item_number();
                        }
                    });
                });


                // $(".addItemBtn").click(function (e) {
                //     e.preventDefault();
                //     var $form = $(this).closest(".form-submit");
                //     var pid = $form.find(".pid").val();
                //     var pname = $form.find(".pname").val();
                //     var pprice = $form.find(".pprice").val();
                //     var pimage = $form.find(".pimage").val();
                //     var pcode = $form.find(".pcode").val();

                //     var pqty = $form.find(".pqty").val();

                //     $.ajax({
                //         url: 'action.php',
                //         method: 'post',
                //         data: {
                //             pid: pid,
                //             pname: pname,
                //             pprice: pprice,
                //             pqty: pqty,
                //             pimage: pimage,
                //             pcode: pcode
                //         },
                //         success: function (response) {
                //             $("#message").html(response);
                //             window.scrollTo(0, 0);
                //             load_cart_item_number();
                //         }
                //     });
                // });
            });
        </script>
    <?php include './footer.php'; ?>
    <?php include './chatbot.php'; ?>
