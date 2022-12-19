<?php

session_start();
require_once "../config/constant.php";

if ($_POST['name'] != null && $_POST['amount'] != null) {
   
    $name = $_POST['name'];
    $email = $_POST['amount'];
    $phone = $_POST['qty'];
    $products = $_POST['image'];
    $grand_total = $_POST['code'];
    $address = $_POST['desc'];
    $pmode = $_POST['type'];
  

    $data = '';

    $stmt = $conn->prepare('INSERT INTO `product` ( `product_name`, `product_price`, `product_qty`, `product_image`, `product_code`, `desc`, `type`) VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss', $name, $email, $phone, $products, $grand_total, $address, $pmode);
    $stmt->execute();

   
        echo "<script>alert('Success added')</script>";
        header("Refresh:0 , url = ../admin/addProduct.php");
        exit();
    
       
    
} else {
    echo "<script>alert('Please fill in information.')</script>";
    header("Refresh:0 , url = ../admin/addProduct.php");
    exit();
}
mysqli_close($conn);
?>