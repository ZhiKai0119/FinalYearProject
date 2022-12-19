<link rel="stylesheet" href="./CSS/product.css"/>

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
$total_pages = $conn->query('SELECT * FROM categories WHERE status = 1')->num_rows;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$num_results_on_page = 8;

if ($stmt = $conn->prepare('SELECT * FROM categories WHERE status = 1 LIMIT ?,?')) {
    $calc_page = ($page - 1) * $num_results_on_page;
    $stmt->bind_param('ii', $calc_page, $num_results_on_page);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <!--    <div class="py-1">
            <div class="container">
                <h6 class="text-muted">
                    <a class="text-muted" href="main.php">Home</a> / Collections
                </h6>
            </div>
        </div>-->
   
   <link href="./CSS/index.css" rel="stylesheet" type="text/css"/>
   

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Product Categories</h1>
                    <hr>
                    <div class="row">
                        <div class="content-wrapper">
                         
                            <div class="first">
                                <div class="section1">
                                    <div class="conscious main1">
                                        <a href='categories.php'><img src="./imgs/electro1.png" alt="Conscious Picture" width="500" ></a>
                                    </div>
                                    <p> Electronic Products</p>
                                    <p> ELECTRONIC MAKE LIFE BETTER </p>
                                    <div class="more">
                                        <a href="electronic.php">View More</a>
                                    </div>
                                </div>

                                <div class="section1 lessStuff">
                                    <div class="main1">
                                         <a href='categories.php'><img src="./imgs/fashion1.jpg" alt="Conscious Picture" width="500" ></a>
                                    </div>
                                    <p>Fashion Products</p>
                                    <p> Fashion bring life colorful </p>
                                    <div class="more">
                                        <a href="fashion.php">View More</a>
                                    </div>
                                </div>
                            </div>

                            <div class="second">
                                <div class="section1 trails">
                                    <div class="main1">
                                        <a href='categories.php'><img src="./imgs/mobile.jpg" alt="Conscious Picture" width="500" ></a>
                                    </div>
                                    <p>Mobile Accessories</p>
                                    <p> Accessories make life more entertain</p>
                                    <div class="more">
                                        <a href="mobile.php">View More</a>
                                    </div>
                                </div>

                                <div class="section1 eco">
                                    <div class="main1">
                                       <a href='categories.php'><img src="./imgs/gro.png" alt="Conscious Picture" width="500" ></a>
                                    </div>
                                    <p>grocery</p>
                                    <p> Vegetables bring life greennn</p>
                                    <div class="more">
                                        <a href="grocery.php">View More</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $stmt->close();
        } else {
            echo "No Category Available.";
        }
        ?>
        <?php include './footer.php'; ?>
        <?php include './chatbot.php'; ?>