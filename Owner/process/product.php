<?php

include '../../config/constant.php';
include './myfunctions.php';

if(isset($_POST['add_product_btn'])) {
    $query = "SELECT * FROM products ORDER BY prodId desc limit 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['prodId'];
    if($lastId == "") {
        $prodId = "PRO2001";
    } else {
        $prodId = substr($lastId, 3);
        $prodId = intval($prodId);
        $prodId = "PRO".($prodId + 1);
    }
    
    $category_id = $_POST['category_id']; 
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $prodPrice = $_POST['product_price'];
    $original_price = $_POST['original_price'];
    $rental_price = $_POST['rental_price'];
    $status = isset($_POST['status']) ? '1':'0';
    $trending = isset($_POST['trending']) ? '1':'0';
    $meta_keywords = $_POST['meta_keywords'];
    
    $image = $_FILES['image']['name'];
    $path = "../Images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;
    
    $product_query = "INSERT INTO products (prodId,catId, prodName,small_description,description,prodPrice,original_price,rental_price,image,status,trending,meta_keywords)"
            . "VALUES ('$prodId','$category_id','$name','$small_description','$description', '$prodPrice', '$original_price','$rental_price','$filename','$status','$trending','$meta_keywords')";
    
    $prod_query_run = mysqli_query($conn, $product_query);
    if($prod_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        redirect("../main.php?add-product", "Product Added Successfully");
    } else {
        errorRedirect("../main.php?add-product", "Something Went Wrong");
    }
} else if(isset($_POST['edit_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id']; 
    
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $prodPrice = $_POST['product_price'];
    $original_price = $_POST['original_price'];
    $rental_price = $_POST['rental_price'];
    $status = isset($_POST['status']) ? '1':'0';
    $trending = isset($_POST['trending']) ? '1':'0';
    $meta_keywords = $_POST['meta_keywords'];

    $path = "../Images";
    
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    
    if($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$image_ext;
    } else {
        $update_filename = $old_image;
    }
    
    $update_product = "UPDATE products SET catId='$category_id',prodName='$name',small_description='$small_description',"
            . "description='$description',prodPrice='$prodPrice',original_price='$original_price',rental_price='$rental_price',image='$update_filename',status='$status',trending='$trending',"
            . "meta_keywords='$meta_keywords' WHERE prodId='$product_id'";
    
    $update_query_run = mysqli_query($conn, $update_product);
    if($update_query_run) {
        if($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../Images/".$old_image)) {
                unlink("../Images/".$old_image);
            }
        }
        redirect("../main.php?edit-product&id=$product_id", "Product Updated Successfully");
    } else {
        errorRedirect("../main.php?edit-product&id=$product_id", "Something Went Wrong");
    }
} else if(isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);  
    
    $check_exists = $conn->query("SELECT * FROM pending_rent WHERE prodId='$product_id' AND status='Pending Return'");
    if($check_exists->num_rows > 0) {
        echo "exists";
    } else {
        $delete_query = $conn->query("UPDATE products SET Activated = '0' WHERE prodId='$product_id'");
        if($delete_query) {
            echo "success";
        } else {
            echo "error";
        }
    }
} else if(isset($_POST['create_donation_btn'])) {
    $query = "SELECT * FROM donation ORDER BY donationId desc limit 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['donationId'];
    if($lastId == "") {
        $donationId = "DON8001";
    } else {
        $donationId = substr($lastId, 3);
        $donationId = intval($donationId);
        $donationId = "DON".($donationId + 1);
    }
    
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    
    $check_product = "SELECT * FROM donation WHERE prodId='$product_id' LIMIT 1";
    $prod_result = mysqli_query($conn, $check_product);
    if(mysqli_num_rows($prod_result) > 0) {
        $data = mysqli_fetch_array($prod_result);
        $donationId = $data['donationId'];
        header("Location: ../main.php?edit-donation&id=$product_id");
    } else {
        $donate = $conn->query("INSERT INTO donation (donationId, prodId, prodName) VALUES ('$donationId','$product_id','$product_name')");
        if($donate) {
            header("Location: ../main.php?edit-donation&id=$product_id");
        } else {
            errorRedirect("../main.php?add_donation", "Something Went Wrong");
        }
    }
} else if(isset ($_POST['update_donation_btn'])) {
    $donation_id = $_POST['donation_id'];
    $prodId = $_POST['product_id'];
    $location_name = $_POST['location_name'];
    $location_address = $_POST['location_address'];
    
    $update_donation = $conn->query("UPDATE donation SET locationName='$location_name',location='$location_address',status=1 WHERE donationId='$donation_id'");
    if($update_donation) {
        $update_product = $conn->query("UPDATE products SET donated=1 WHERE prodId='$prodId'");
        if($update_product) {
            redirect("../main.php?donate", "Product had been donated!");
        } else {
            errorRedirect("../main.php?edit-donation&id=$product_id", "Something Went Wrong");
        }
    } else {
        errorRedirect("../main.php?edit-donation&id=$product_id", "Something Went Wrong");
    }
} else if(isset($_POST['updateRentTimes'])) {
    $prodId = $_POST['prodId'];

    $check = $conn->query("SELECT * FROM donation WHERE prodId='$prodId'");
    if($check->num_rows > 0) {
        $update = $conn->query("DELETE FROM donation WHERE prodId='$prodId'");
        $update = $conn->query("UPDATE products SET rentalTimes=rentalTimes+50 WHERE prodId='$prodId'");
        if($update) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        $update = $conn->query("UPDATE products SET rentalTimes=rentalTimes+50 WHERE prodId='$prodId'");
        if($update) {
            echo "success";
        } else {
            echo "error";
        }
    }
} else {
    header("Location: ../main.php");
}
?>