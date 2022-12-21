<?php
include '../../config/dbConnect.php';
$tempArray = array();

if(isset($_GET['prodID'])){
    $prodID = $_GET['prodID'];
    $db = new DBConfig();

    $sql = "Select * from pending_rent WHERE prodId = '$prodID' AND status = 'Pending Return'";
    $result = $db->selectQuery($sql);

    if(count($result) > 0){

        for($i=0; $i < count($result); $i++){
            $tempArray[] = array(
                "startDate" => $result[$i]['startDate'], 
                "endDate" => $result[$i]['endDate'],
                "status" => $result[$i]['status']
            );
        }

        echo json_encode($tempArray);
        
    }elseif(count($result) == 0){
        echo json_encode('no item');
    } 
    exit();
}
?>