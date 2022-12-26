<?php 
include '../config/constant.php';

if(isset($_POST['checkVoucher'])) {
    $total = $_POST['total'];
    $redeemCode = $_POST['redeemCode'];

    $check_voucher = $conn->query("SELECT * FROM sell_voucher WHERE redeemCode = '$redeemCode'");
    $data = $check_voucher->fetch_assoc();
    if($total > $data['minSpend']) {
        $value = $data['voucher_value'];
        $discount = [
            'value' => $value,
            'total' => $total - $value,
        ];

        $update_voucher = $conn->query("UPDATE sell_voucher SET quantity = quantity - 1 WHERE redeemCode = '$redeemCode'");

        echo json_encode($discount);
    } else {
        $discount = [
            'value' => '0.00',
            'total' => $total,
        ];
        echo json_encode($discount);
    }
} elseif(isset($_POST['makePayment'])) {
    $query = "SELECT * FROM receiver_details ORDER BY receiverId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['receiverId'];
    if($lastId == "") {
        $receiverId = "RE5001";
    } else {
        $receiverId = substr($lastId, 2);
        $receiverId = intval($receiverId);
        $receiverId = "RE".($receiverId + 1);
    }

    $email = $_POST['email'];
    $cartId = $_POST['cartId'];
    $total = $_POST['total'];
    $payment_mode = $_POST['payment_mode'];
    $payment_id = $_POST['payment_id'];

    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $rName = $_POST['rName'];
    $phone = $_POST['phone'];

    $payment = $conn->query("INSERT INTO payments (payment_id, payer_email, amount, currency, payment_mode, payment_status) VALUES ('$payment_id', '$email', '$total', 'MYR', '$payment_mode', 'Successful')");
    $receiver = $conn->query("INSERT INTO receiver_details (receiverId, email, address, city, state, zip, country, receiver_name, phone) VALUES ('$receiverId', '$email', '$address', '$city', '$state', '$zip', '$country', '$rName', '$phone')");
    if($payment && $receiver) {
        $tracking_no = uniqid('TRACK');
        $cart = $conn->query("UPDATE cart SET status = 'Done' WHERE cartId = '$cartId'");

        $query_product = $conn->query("SELECT * FROM cart WHERE cartId = '$cartId'");
        while($product = $query_product->fetch_assoc()) {
            $productCode = $product['prodCode'];
            $prodQty = $product['qty'];
            $conn->query("UPDATE sell_product SET product_qty = product_qty - $prodQty WHERE product_code = '$productCode'");
        }
        

        $order_details = $conn->query("INSERT INTO order_details (cartId, payment_id, email, receiver_id, tracking_no, status) VALUES ('$cartId', '$payment_id', '$email', '$receiverId', '$tracking_no', 'Pending Delivery')");
        if($cart && $order_details) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}

else {
    echo "error";
}
?>