<?php 
include '../config/db.php';

if(isset($_POST['checkVoucher'])) {
    $grand_total = $_POST['grand_total'];
    $redeemCode = $_POST['redeemCode'];

    $check_voucher = $conn->query("SELECT * FROM sell_voucher WHERE redeemCode = '$redeemCode'");
    $data = $check_voucher->fetch_assoc();
    if($grand_total > $data['minSpend']) {
        $value = $data['voucher_value'];
        
        echo $value;
    } else {
        echo "0.00";
    }
} else {
    echo "error";
}
?>