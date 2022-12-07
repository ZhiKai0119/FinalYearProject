<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php   
include './Partials/nav.php';

if(isset($_GET['prodId'])) {
    $prodId = $_GET['prodId'];
    $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId'");
    $data = mysqli_fetch_array($product);
    
    $catId = $data['catId'];
    $category = $conn->query("SELECT * FROM categories WHERE catId = '$catId'");
    $cat_data = mysqli_fetch_array($category);
    
    if($data) { ?>
        <div class="col-md-10 col-11 mx-auto">
            <nav aria-label="breadcrumb" class="m-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Home</a></li>
                <li class="breadcrumb-item"><a href="categories.php">Collections</a></li>
                <li class="breadcrumb-item"><a href="product-category.php?catId=<?php echo $data['catId']; ?>"><?php echo $cat_data['catName']; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $data['prodId']; ?></li>
              </ol>
            </nav>
        </div>
        
        <div class="py-4">
            <div class="container mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="shadow-lg p-3 mb-5 bg-white rounded">
                            <img src="../Owner/Images/<?php echo $data['image']; ?>" alt="Product Image" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4 class="font-weight-bold"><?php echo $data['prodName']; ?>
                            <span class="float-right text-danger"><?php if($data['trending'] == 1){ echo "Trending"; } ?></span>
                        </h4>
                        <hr>
                        <p><?php echo $data['small_description']; ?></p>
                        <div class="row">
                            <div class="col-md-2">
                                <h5><s class="text-danger">RM <?php echo round($data['original_price'],2); ?></s></h5>
                            </div>
                            <div class="col-md-6">
                                <h4>RM <span class="text-success font-weight-bold"><?php echo round($data['rental_price'],2); ?></span>/Day</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-primary px-5 btnRent"><i class="fa fa-handshake-o" aria-hidden="true"></i> Rent</button>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="email" id="email" value="<?php echo $userInfo['email']; ?>">
                                <button class="btn btn-danger px-4 wishlist" value="<?php echo $data['prodId']; ?>"><i class="fa fa-heart" aria-hidden="true"></i> Add to Wishlist</button>
                            </div>
                        </div>
                        <hr>
                        <h6>Product Description:</h6>
                        <p><?php echo $data['description']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        
    <?php } else {
        echo "Product Not Found";
    }
}
?>

<?php include './rental_modal.php'; ?>
<?php
    $prodId = $data['prodId'];
    $disableDate = $conn->query("SELECT * FROM pending_rent WHERE prodId = '$prodId' AND status = 'Pending'");
    $dates_ar = [];

    if(mysqli_num_rows($disableDate) > 0) {
        while ($ddate = $disableDate->fetch_array()) {
            $begin = new DateTime($ddate['startDate']);
            $end = new DateTime($ddate['endDate']);
            $end = $end->modify('+1 day');
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);
            foreach ($daterange as $date) {
                $dates_ar[] = $date->format("Y-m-d");
            }
        }
    }
?>

<script type="text/javascript" src="JS/wishlist.js"></script>
<script>
    dateArr = <?php echo json_encode($dates_ar);?>;

    $(document).ready(function () {
        $('.btnRent').click(function () {
            email = "<?php echo $userInfo['email'];?>";
            prodId = "<?php echo $data['prodId']; ?>";
            origFees = "<?php echo round($data['rental_price'],2); ?>";
            prodPrice = "<?php echo round($data['prodPrice'],2); ?>";
            calDeposit = (prodPrice * 0.10).toFixed(2);

            $('#rentDetail').modal('show');
            $('#email').val(email);
            $('#prodId').val(prodId);
            getReservedDate(dateArr);
            $('#origFees').val(origFees);
            if (calDeposit >= 100) {
                $('#deposit').val();
            } else {
                $('#deposit').val(calDeposit);
            }
            changeRange();
        });
    });
</script>

<?php include './Partials/footer.php'; ?>
<?php include './Partials/chatbot.php'; ?>