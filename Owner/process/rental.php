<?php

include '../../config/constant.php';
include './myfunctions.php';

if(isset($_POST['btnConfirm'])) {
    $rental_id = $_POST['rental_id'];
    $rental_status = $_POST['rental_status'];

    if($rental_status == "Pending Delivery")
        $newStatus = "Delivering";
    elseif($rental_status == "Delivering")
        $newStatus = "Customer Received";
    // elseif($rental_status == "Received")
    //     $newStatus = "Pending Return";
    // elseif($rental_status == "Pending Return")
    //     $newStatus = "Returned";

    $update_status = $conn->query("UPDATE rental_details SET rental_status = '$newStatus' WHERE rental_id = '$rental_id'");
    if($update_status) {
        redirect("../main.php?view-delivery", $rental_id." has been " . $rental_status . "!");
    }
} elseif(isset($_POST['btnReturn'])) {
    $remainDay = $_POST['remainDay'];
    $rental_id = $_POST['rental_id'];
    $prodId = $_POST['prodId'];
    $email = $_POST['email'];

    $query = "SELECT * FROM return_prod ORDER BY returnId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['returnId'];
    if($lastId == "") {
        $returnId = "RTN7001";
    } else {
        $returnId = substr($lastId, 3);
        $returnId = intval($returnId);
        $returnId = "RTN".($returnId + 1);
    }

    if($remainDay < 0) {
        $query = "SELECT * FROM fine ORDER BY fineId desc LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $lastId = $row['fineId'];
        if($lastId == "") {
            $fineId = "FINE8001";
        } else {
            $fineId = substr($lastId, 4);
            $fineId = intval($fineId);
            $fineId = "FINE".($fineId + 1);
        }

        $late_days = abs($remainDay); 
        $find_price = $conn->query("SELECT * FROM products WHERE prodId = '$prodId'");
        if(mysqli_num_rows($find_price)) {
            $prodInfo = $find_price->fetch_assoc();
            $rental_price = $prodInfo['rental_price'];
            $total_fine = $rental_price * $late_days;
        }

        $new_fine = $conn->query("INSERT INTO fine (fineId, email, rentId, prodId, late_days, total_fine, pay_status) VALUES ('$fineId', '$email', '$rental_id', '$prodId', '$late_days', '$total_fine', 'Pending')");
        $record_return = $conn->query("INSERT INTO return_prod (returnId, email, rentId, prodId, days_diff) VALUES ('$returnId', '$email', '$rental_id', '$prodId', '$late_days')");
        $update_rent = $conn->query("UPDATE pending_rent SET status = 'Pending Fine', returnId = '$returnId', fineId = '$fineId' WHERE rentId = '$rental_id' AND prodId = '$prodId'");
        redirect("../main.php?view-return", "Please ask customer to pay the fine.");
    } else {
        $record_return = $conn->query("INSERT INTO return_prod (returnId, email, rentId, prodId, days_diff) VALUES ('$returnId', '$email', '$rental_id', '$prodId', '$late_days')");
        $update_rent = $conn->query("UPDATE pending_rent SET status = 'Completed', returnId = '$returnId' WHERE rentId = '$rental_id' AND prodId = '$prodId'");

        $check_status = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rental_id' AND status = 'Pending Return' OR status = 'Pending Fine'");
        if(mysqli_num_rows($check_status) == 0) {
            $update_loan = $conn->query("UPDATE loan SET loan_status = 'Completed' WHERE rentId = '$rental_id'");
        }

        if($record_return && $update_rent) {
            redirect("../main.php?view-return", $rental_id." has been returned!");
        }
    }
}

?>