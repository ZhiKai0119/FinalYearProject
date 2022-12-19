

<?php
session_start();
if (!isset($_SESSION['customerID'])) {
    echo "<h1>Warning</h1>";
    echo "<h2>No permission allowed to access this page</h2>";
    echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
    exit(); // Quit the script.
}
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
                <h1 class="text-center"> Orders Status </h1>


                <!-- Displaying Products Start -->
                <div class="container">
                    <div id="message"></div>
                    <div class="row mt-2 pb-3">
                        <?php
                        $customerID = $_SESSION['customerID'];
                        $stmt = $conn->prepare("SELECT * FROM orders where status = 'pending' and customerID = '$customerID'");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                <div class="card-deck">
                                    <div class="card p-2 border-secondary mb-2">

                                        <div class="card-body p-1">
                                            <h4 class="card-title text-center text-info">Order ID : <?= $row['id'] ?></h4>
                                            <h4 class="card-title text-center text-info"><?= $row['products'] ?></h4>


                                        </div>
                                        <div class="card-footer p-1">
                                            <form action="" class="form-submit">
                                                <div class="row p-2">


                                                    <h4 class="card-title text-center text-info">Payment Method : <?= $row['pmode'] ?></h4>

                                                </div>

                                                <h4 class="card-title text-center text-danger">Status : <?= $row['status'] ?> </h4>
                                                <td>
                                                    <a href="action.php?cancel=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to cancel order?');"><i class="fas fa-trash-alt"></i>Cancel Order</a>
                                                </td>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    }
                    ?>


                </div>
            </div>
            <!-- Displaying Products End -->

            <div class="container">
                <div id="message"></div>
                <div class="row mt-2 pb-3">
                    <?php
                    $customerID = $_SESSION['customerID'];
                    $stmt = $conn->prepare("SELECT * FROM orders where status = 'shipped' and customerID = '$customerID'");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($data = $result->fetch_assoc()):
                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                            <div class="card-deck">
                                <div class="card p-2 border-secondary mb-2">

                                    <div class="card-body p-1">
                                        <h4 class="card-title text-center text-info">Order ID : <?= $data['id'] ?></h4>
                                        <h4 class="card-title text-center text-info"><?= $data['products'] ?></h4>


                                    </div>
                                    <div class="card-footer p-1">
                                        <form action="" class="form-submit">
                                            <div class="row p-2">


                                                <h4 class="card-title text-center text-info">Payment Method : <?= $data['pmode'] ?></h4>

                                            </div>

                                            <h4 class="card-title text-center text-danger">Status : <?= $data['status'] ?> </h4>
                                            <td>
                                                <a href="action.php?update=<?= $data['id'] ?>" class="text-danger lead" onclick="return confirm('Are you CONFIRM this order');"><i class="fas fa-trash-alt"></i>Confirm Received</a>
                                            </td>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    ?>


                </div>
            </div>

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
<?php include 'footer.php' ?>
<?php include 'chatbot.php' ?>