<?php 
include '../../config/constant.php';
include '../../Owner/process/myfunctions.php';

if(isset($_POST['add_product_btn'])) {
    $name = $_POST['name'];
    $prodPrice = $_POST['product_price'];
    $prodQty = $_POST['prodQty'];

    $image = $_FILES['image']['name'];
    $path = "../Images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;

    $prodCode = $_POST['prodCode'];
    $desc = $_POST['desc'];
    $category_id = $_POST['category_id']; 
    $status = $_POST['status']; 
    
    $product_query = $conn -> query("INSERT INTO sell_product (product_name, product_price, product_qty, image, product_code, description, type, available) VALUES ('$name', '$prodPrice', '$prodQty', '$filename', '$prodCode', '$desc', '$category_id', '$status')");

    if($product_query) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        redirect("../../Owner/main.php?add-sProduct", "Product Added Successfully");
    } else {
        errorRedirect("../../Owner/main.php?add-sProduct", "Something Went Wrong");
    }
} elseif (isset($_POST['add_category_btn'])) {
    $catID = $_POST['catID'];
    $name = $_POST['name'];
    
    $image = $_FILES['image']['name'];
    $path = "../Images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;
    
    $query = "INSERT INTO sell_category (cat_id, category_name, image) VALUES ('$catID','$name','$filename')";
    
    $cate_query_run = mysqli_query($conn, $query);
    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        redirect("../../Owner/main.php?add-sCategory", "Category Added Successfully");
    } else {
        errorRedirect("../../Owner/main.php?add-sCategory", "Something Went Wrong");
    }
} elseif (isset($_POST['edit_category_btn'])) {
    $catID = $_POST['catID'];
    $name = $_POST['name'];

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    
    if($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$image_ext;
    } else {
        $update_filename = $old_image;
    }
    $path = "../Images";

    $update_query = $conn->query("UPDATE sell_category SET category_name = '$name', image = '$update_filename' WHERE cat_id = '$catID'");
    if($update_query) {
        if($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../Images/".$old_image)) {
                unlink("../Images/".$old_image);
            }
        }
        redirect("../../Owner/main.php?categories", "Category Edited Successfully");
    } else {
        errorRedirect("../../Owner/main.php?categories", "Something Went Wrong");
    }
} elseif (isset($_POST['delete_category_btn'])) {
    $category_id = $_POST['category_id'];
    $delete = $conn->query("DELETE FROM sell_category WHERE cat_id = '$category_id'");
    if($delete) {
        redirect("../../Owner/main.php?categories", "Category Deleted Successfully");
    } else {
        errorRedirect("../../Owner/main.php?categories", "Something Went Wrong");
    }
} elseif (isset($_POST['edit_product_btn'])) {
    $name = $_POST['name'];
    $prodPrice = $_POST['product_price'];
    $prodQty = $_POST['prodQty'];

    $path = "../Images";
    
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$image_ext;
    } else {
        $update_filename = $old_image;
    }

    $prodCode = $_POST['product_id'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id']; 
    $status = $_POST['status']; 
    
    $product_query = $conn -> query("UPDATE sell_product SET product_name = '$name', product_price = '$prodPrice', product_qty = '$prodQty', image = '$update_filename', description = '$description', type = '$category_id', available = '$status' WHERE product_code = '$prodCode'");

    if($product_query) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
        redirect("../../Owner/main.php?view-product", "Product Added Successfully");
    } else {
        errorRedirect("../../Owner/main.php?view-product", "Something Went Wrong");
    }
} elseif (isset($_POST['delete_selling_prod'])) {
    $product_code = $_POST['product_code'];
    $delete = $conn->query("DELETE FROM sell_product WHERE product_code = '$product_code'");
    if($delete) {
        redirect("../../Owner/main.php?view-product", "Product Deleted Successfully");
    } else {
        errorRedirect("../../Owner/main.php?view-product", "Something Went Wrong");
    }
} elseif (isset($_POST['create_voucher'])) {
    $vID = $_POST['vID'];
    $title = $_POST['title'];
    $redeemCode = $_POST['redeemCode'];
    $vValue = $_POST['vValue'];
    $maxValue = $_POST['maxValue'];
    $minSpend = $_POST['minSpend'];
    $quantity = $_POST['quantity'];
    $vStatus = $_POST['vStatus'];

    $insert = $conn->query("INSERT INTO sell_voucher (voucherId, title, redeemCode, voucher_value, max_redeem, minSpend, quantity, voucher_status) 
    VALUES ('$vID', '$title', '$redeemCode', '$vValue', '$maxValue', '$minSpend', '$quantity', '$vStatus')");

    if($insert) {
        redirect("../../Owner/main.php?view-voucher", "Voucher Added Successfully");
    } else {
        errorRedirect("../../Owner/main.php?view-voucher", "Something Went Wrong");
    }
} elseif (isset($_POST['edit_voucher'])) {
    $vID = $_POST['vID'];
    $title = $_POST['title'];
    $redeemCode = $_POST['redeemCode'];
    $vValue = $_POST['vValue'];
    $maxValue = $_POST['maxValue'];
    $minSpend = $_POST['minSpend'];
    $quantity = $_POST['quantity'];
    $vStatus = $_POST['vStatus'];

    $update = $conn->query("UPDATE sell_voucher SET title = '$title', redeemCode = '$redeemCode', voucher_value = '$vValue', max_redeem = '$maxValue', minSpend = '$minSpend', quantity = '$quantity', voucher_status = '$vStatus' WHERE voucherId = '$vID'");
    if($update) {
        redirect("../../Owner/main.php?view-voucher", "Voucher Edit Successfully");
    } else {
        errorRedirect("../../Owner/main.php?view-voucher", "Something Went Wrong");
    }
} elseif (isset($_POST['delete_voucher'])) {
    $voucherId = $_POST['voucherId'];
    $delete = $conn->query("DELETE FROM sell_voucher WHERE voucherId = '$voucherId'");
    if($delete) {
        redirect("../../Owner/main.php?view-voucher", "Voucher Deleted Successfully");
    } else {
        errorRedirect("../../Owner/main.php?view-voucher", "Something Went Wrong");
    }
}
?>