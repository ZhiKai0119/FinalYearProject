<?php

include '../../config/constant.php';
include './myfunctions.php';

if(isset($_POST['btnConfirm'])) {
    $rental_id = $_POST['rental_id'];
    $rental_status = $_POST['rental_status'];

    if($rental_status == "Pending Delivery")
        $newStatus = "Delivering";
    elseif($rental_status == "Delivering")
        $newStatus = "Received";
    elseif($rental_status == "Received")
        $newStatus = "Pending Return";
    elseif($rental_status == "Pending Return")
        $newStatus = "Returned";

    $update_status = $conn->query("UPDATE rental_details SET rental_status = '$newStatus' WHERE rental_id = '$rental_id'");
    if($update_status) {
        redirect("../main.php?view-rental", $rental_id." has been " . $rental_status . "!");
    }
}

?>