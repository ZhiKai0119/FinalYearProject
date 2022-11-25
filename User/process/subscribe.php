<?php
include '../../config/constant.php';

$sEmail = $_POST['sEmail'];

//Validation
if (strlen($sEmail) < 2) {
    echo 'eshort';
} elseif (filter_var($sEmail, FILTER_VALIDATE_EMAIL) === false) {
    echo 'eformat';
} else {
    //Auto Generate ID
    $query = "SELECT * FROM subscribe ORDER BY sID desc limit 1";
    $idResult = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($idResult);
    $lastId = $row['sID'];
    if($lastId == " ") {
        $sID = "S1";
    } else {
        $sID = substr($lastId, 1);
        $sID = intval($sID);
        $sID = "S".($sID + 1);
    }
    
//    $sEmail = $conn->real_escape_string($sEmail);
    
    $sql = "SELECT * FROM subscribe WHERE sEmail='$sEmail'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        echo "exist";
    } else {
        $insert = $conn->query("INSERT INTO subscribe (sID, sEmail) VALUES ('$sID', '$sEmail')");
        if($insert) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
}

?>