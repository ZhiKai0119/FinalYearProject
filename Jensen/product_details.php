<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
include './nav.php';
include './config/constant.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $sql = "SELECT * FROM users WHERE token='{$_COOKIE["token"]}'";
    $result = mysqli_query($conn, $sql);
    $userInfo = mysqli_fetch_assoc($result);
    $email = $userInfo['email'];
} else {
    header("Location: index.php");
    exit();
}

if (isset($_GET['prodCode'])) {
    $prodCode = $_GET['prodCode'];
    $product = $conn->query("SELECT * FROM sell_product where product_code = '$prodCode' LIMIT 1");
    $data = $product->fetch_assoc();
?>
    <div class="py-3 bg-secondary">
        <div class="container mt-3">
            <div class="row">
                <h1 class="text-center text-light font-weight-bold">Product Details</h1><br>
                <div id="message"></div>
                <div class="col-md-4">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded">
                        <img src="./Images/<?php echo $data['image']; ?>" alt="Product Image" class="w-100">
                    </div>
                </div>
                <div class="col-md-8 w-100">
                    <div class="shadow-lg p-3 mb-5 bg-white rounded text-justify">
                        <h3 class="text-left text-dark"><?php echo $data['product_name']; ?></h3><br>
                        <h5 class="text-left text-dark">RM <?php echo $data['product_price']; ?></h5><br>
                        <p class="text-left text-dark"><?php echo $data['description']; ?></p>
                        <div class="row">
                            <div class="col-md-5 d-inline my-1">
                                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
                                <input type="hidden" name="prodCode" id="prodCode" value="<?php echo $data['product_code']; ?>">
                                <input type="hidden" name="prodPrice" id="prodPrice" value="<?php echo $data['product_price']; ?>">
                                Quantity: <input type="number" class="prodQty input-sm col-sm-5 form-control d-inline" name="prodQty" value="1" min="1" max="<?php echo $data['product_qty']; ?>">
                            </div>
                            <button class="btn btn-sm btn-info btn-block col-sm-6 my-1 addItemBtn"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>



<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

<script type="text/javascript">
    $(document).ready(function () {

        // Send product details in the server
        $(".addItemBtn").click(function (e) {
            e.preventDefault();
            var email = document.getElementById("email").value;
            var prodCode = document.getElementById("prodCode").value;
            var prodQty = document.getElementsByClassName("prodQty")[0].value;
            var prodPrice = document.getElementById("prodPrice").value;
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
<?php include 'footer.php' ?>'