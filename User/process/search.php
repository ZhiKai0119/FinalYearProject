<?php
include '../../config/constant.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Keywords = $_POST['keywords'];
    $sql = $conn->query("SELECT DISTINCT meta_keywords FROM products WHERE meta_keywords LIKE '%".$Keywords."%' ORDER BY meta_keywords");
    
    if(mysqli_num_rows($sql)) {
        while($row = $sql->fetch_assoc()) {
            echo '<a href="#" class="list-group list-group-item-action border p-2" style="text-decoration: none;">'.$row['meta_keywords'].'</a>';
        }
    } else {
        echo '<p class="list-group list-group-item">Record Not Found</p>';
    }
}
?>