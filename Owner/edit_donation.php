<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_GET['id'])) { 
                $id = $_GET['id'];
                $donation = $conn->query("SELECT * FROM donation WHERE prodId = '$id'");
                if (mysqli_num_rows($donation) > 0) { 
                    $data = mysqli_fetch_array($donation);
                ?>
                    <div class="card border-0 bg-transparent">
                    <div class="card-header border-0">
                        <h4 class="text-uppercase font-weight-bold">Update Donation</h4>
                    </div>
                    <div class="card-body bg-transparent">
                        <form action="process/product.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="donation_id" value="<?php echo $data['donationId'];?>">
                                    <input type="hidden" name="product_id" value="<?php echo $data['prodId'];?>">
                                    <label class="mb-0">ID</label>
                                    <input type="text" name="prodId" value="<?php echo $data['prodId'];?>" class="form-control mb-2" readonly="">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-0">Name</label>
                                    <input type="text" name="name" value="<?php echo $data['prodName'];?>" class="form-control mb-2" disabled="disable">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Location Name</label>
                                    <input type="text" name="location_name" value="<?php echo $data['locationName'];?>" placeholder="Enter Location Name" class="form-control mb-2">
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-0">Location Address</label>
                                    <textarea rows="3" name="location_address" placeholder="Enter Location Addressn" class="form-control mb-2"><?php echo $data['location'];?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="update_donation_btn">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    
                <?php 
                } else {
                    echo "Product not found";
                }
            } else {
                echo "ID missing from url";
            }
            ?>
                
        </div>
    </div>
</div>
