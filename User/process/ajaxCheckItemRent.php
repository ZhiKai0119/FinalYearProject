<?php
include '../../config/dbConnect.php';

if(isset($_GET['prodID'])){
    $prodID = $_GET['prodID'];
    $db = new DBConfig();

    $sql = "Select * from pending_rent WHERE prodId = '$prodID' AND status = 'Pending Return'";
    $result = $db->selectQuery($sql);

    if(count($result) > 0){
        return json_encode($result);
    }elseif(count($result) == 0){
        return json_encode('no item');
    }

    exit();
}
?>