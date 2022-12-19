<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
if (isset($_GET['prodId'])) {
    $prodId = $_GET['prodId'];
    $product = $conn->query("SELECT * FROM product where id = '$prodId'");
    $data = mysqli_fetch_array($product);
    ?>

    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="UTF-8">

            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Shopping Cart System</title>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
            <link rel="stylesheet" href="./CSS/footerStyle.css">
        </head>

        <body>



            <!-- Displaying Products Start -->
            <div class="container">
                <div id="message"></div>
                <div class="row mt-2 pb-3">
                    <?php
                    include './config/constant.php';
                    $stmt = $conn->prepare("SELECT * FROM product where id = '$prodId'");
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

                                                <div class="col-md-6">
                                                    <input type="hidden" class="form-control pqty" value="1">
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
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                            <div class="card-deck">
                                <div class="card p-2 border-secondary mb-2" style="height: 473.6px;">
                                    <h6>Product Description:</h6>
                                    <div class="card-body p-1">
                                        <p><?php echo $row['desc']; ?></p>
                                    </div>
                                </div>
                            </div>
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




            <?php
        endwhile;
    }
    ?>
</html>
<?php include 'footer.php' ?>'