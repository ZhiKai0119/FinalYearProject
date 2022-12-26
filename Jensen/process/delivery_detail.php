<?php 
include '../config/constant.php';

if(isset($_POST['getDetail'])) {
    $cartId = $_POST['cartId'];
    $receiver_id = $_POST['receiver_id'];
    $tracking_no = $_POST['tracking_no'];

    $receiver_detail = $conn->query("SELECT * FROM receiver_details WHERE receiverId = '$receiver_id'");
    $receiver = $receiver_detail->fetch_assoc();
    $address = $receiver['address'] .', '.$receiver['zip'] .', '.$receiver['city'] .', '.$receiver['state'] .', '.$receiver['country'];

    $delInfo = [
        'cartId' => $cartId,
        'address' => $address,
        'receiver_name' => $receiver['receiver_name'],
        'phoneNo' => $receiver['phone'],
        'tracking_no' => $tracking_no
    ];

    echo json_encode($delInfo);
} elseif (isset($_POST['updateStatus'])) {
    $status = $_POST['status'];
    $tracking_no = $_POST['tracking_no'];

    $update = $conn->query("UPDATE order_details SET status = '$status' WHERE tracking_no = '$tracking_no'");
    if($update) {
        echo 'success';
    } else {
        echo 'failed';
    }
}
?>
