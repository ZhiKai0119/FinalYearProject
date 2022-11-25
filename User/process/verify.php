<!-- CHECK DATE AND DISABLE IT -->
<?php
if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
    $email = $userInfo['email'];
    $rentPending = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND status = 'Pending'");

    if (mysqli_num_rows($rentPending) > 0) {
        while ($record = $rentPending->fetch_assoc()):
            $date1 = $record['endDate'];
            $endDate = strtotime(date('Y-m-d', strtotime($date1)));
            $currentDate = strtotime(date('Y-m-d'));
            $rentId = $record['rentId'];

            if ($endDate < $currentDate) {
                $update_status = $conn->query("UPDATE pending_rent SET status = 'Cancelled' WHERE rentId = '$rentId'");
                if($update_status) {
                    echo "<script>location.reload();</script>";
                }
            } 
            // elseif ($startDate > $currentDate) {
                
            // }
        endwhile;
    }
}
?>