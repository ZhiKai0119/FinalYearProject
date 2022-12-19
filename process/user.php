<?php
include '../config/constant.php';
require '../phpmailer/PHPMailerAutoload.php';

function redirect($url, $message) {
    setcookie("status", $message, time()+1, "/", NULL);
    header('Location: '.$url);
    exit();
}

function errorRedirect($url, $message) {
    setcookie("failureStatus", $message, time()+1, "/", NULL);
    header('Location: '.$url);
    exit();
}

function validateCard($number) {
    global $type;
    
    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$number)) {
        $type= "visa";
        return 'visa';
    } else if (preg_match($cardtype['mastercard'],$number)) {
        $type= "mastercard";
        return 'mastercard';
    } else if (preg_match($cardtype['amex'],$number)) {
        $type= "amex";
        return 'amex';
    } else if (preg_match($cardtype['discover'],$number)) {
        $type= "discover";
        return 'discover';
    } else {
        echo "false";
    } 
}

function validDate($year, $month) {
    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    if (! preg_match('/^20\d\d$/', $year)) {
        return false;
    }
    if (! preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
        return false;
    }
    // past date
    if ($year < date('Y') || $year == date('Y') && $month < date('m')) {
        return false;
    }
    return true;
}

if(isset($_FILES["image"]["name"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $old_image = $_POST["old_image"];
    $path = "../Images";

    $imageName = $_FILES["image"]["name"];
    $imageSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    //Image Validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));
    if(!in_array($imageExtension, $validImageExtension)) {
        echo "<script>alert('Invalid Image Extension'); document.location.href = './userProfile.php';</script>";
        $update_filename = $old_image;
    } elseif ($imageSize > 12000000000) {
        echo "<script>alert('Image Size is Too Large'); document.location.href = './userProfile.php';</script>";
        $update_filename = $old_image;
    } else {
        $image_ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$image_ext;

        $updateImage = $conn->query("UPDATE users SET picture = '$update_filename' WHERE email = '$email'");
        if($updateImage) {
            move_uploaded_file($tmpName, $path.'/'.$update_filename);
            // if(file_exists("../Images/".$old_image)) {
            //     unlink("../Images/".$old_image);
            // }
        }
        echo "<script>document.location.href = '../User/userProfile.php';</script>";
    }
} elseif (isset($_POST['deleteProfile'])) {
    $email = $_POST['email'];
    
    $user_query = $conn->query("SELECT * FROM users WHERE email = '$email' LIMIT 1");
    $userDetail = mysqli_fetch_array($user_query);
    $picture = $userDetail['picture'];
    
    $deleteUser = $conn->query("DELETE FROM users WHERE email = '$email'");
    if($deleteUser) {
        if(file_exists("../Images/".$image)) {
            unlink("../Images/".$image);
        }
        redirect("../logout.php", "Delete Account Successfully");
    } else {
        errorRedirect("../User/main.php", "Something Went Wrong");
    }
} elseif (isset($_POST['updateProfile'])) {
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $fullName = $lname . ' ' . $fname;
    
    $updateUser = $conn->query("UPDATE users SET fname = '$fname', lname = '$lname', fullName = '$fullName' WHERE email = '{$email}'");
    if($updateUser) {
        redirect("../User/userProfile.php", "User Details Update Successfully");
    } else {
        errorRedirect("../User/main.php", "Something Went Wrong");
    }
} elseif (isset ($_POST['email']) && isset($_POST['oldPassword']) && isset($_POST['newPassword1'])) {
    $email = $_POST['email'];
    $oldPwd = $_POST['oldPassword'];
    $newPwd1 = $_POST['newPassword1'];
    $newPwd2 = $_POST['newPassword2'];
    
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $newPwd1);
    $lowercase = preg_match('@[a-z]@', $newPwd1);
    $number    = preg_match('@[0-9]@', $newPwd1);
    $specialChars = preg_match('@[^\w]@', $newPwd1);
   
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if(mysqli_num_rows($checkResult) == 1) {
        $userData = mysqli_fetch_assoc($checkResult);
        if($userData['password'] != null) {
            if(password_verify($oldPwd, $userData['password'])) {
                if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newPwd1) < 8) {
                    echo 'invalid';
                } else if ($newPwd1 != $newPwd2) {
                    echo 'nMatch';
                }else{
                    $sPwd = password_hash($newPwd1, PASSWORD_BCRYPT, array('cost' => 12));
                    $update = $conn->query("UPDATE users SET password = '$sPwd' WHERE email = '$email'");
                    if($update) {
                        echo 'true';
                    } else {
                        echo 'false';
                    }
                }
            } else {
                echo "nSame";
            }
        } else {
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newPwd1) < 8) {
                echo 'invalid';
            } else if ($newPwd1 != $newPwd2) {
                echo 'nMatch';
            }else{
                $sPwd = password_hash($newPwd1, PASSWORD_BCRYPT, array('cost' => 12));
                $update = $conn->query("UPDATE users SET password = '$sPwd' WHERE email = '$email'");
                if($update) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            }
        }
    }
} elseif (isset($_POST['addCard'])) { //isset($_POST['email']) && isset($_POST['cardholderName']) && isset($_POST['cardNo'])
    $query = "SELECT * FROM paymentmethod ORDER BY methodId desc limit 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['methodId'];
    if($lastId == "") {
        $methodId = "PM7001";
    } else {
        $methodId = substr($lastId, 2);
        $methodId = intval($methodId);
        $methodId = "PM".($methodId + 1);
    }
    
    $email = $_POST['email'];
    $cardholderName = $_POST['cardholderName'];
    $cardNo = $_POST['cardNo'];
    $expMth = $_POST['expMth'];
    $expYear = $_POST['expYear'];
    $cvv = $_POST['cvv'];
    
    if(strlen($cardNo) < 16 || strlen($expMth) < 2 || strlen($expYear) < 4 || strlen($cvv) < 3) {
        echo 'short';
    } else {
        if(validateCard($cardNo) != false) {
            if(validDate($expYear, $expMth)) {
                $search_query = "SELECT * FROM paymentmethod WHERE email = '$email' AND cardNo = '$cardNo'";
                $search_result = mysqli_query($conn, $search_query);
                if(mysqli_fetch_row($search_result) == 0) {
                    $type = validateCard($cardNo);
                    $addMethod = $conn->query("INSERT INTO paymentmethod (methodId, cardholderName, cardNo, type, expMth, expYear, cvv, email) "
                            . "VALUES ('$methodId', '$cardholderName', '$cardNo', '$type', '$expMth', '$expYear', '$cvv', '$email')");
                    if($addMethod) {
                        echo 'true';
                    } else {
                        echo 'false';
                    }
                } else {
                    echo 'exist';
                }                    
            } else {
                echo 'expired';
            }
        } else {
            echo 'invalid';
        }
    }
} elseif (isset($_POST['delete_payment_method'])) {
    $methodId = mysqli_real_escape_string($conn, $_POST['methodId']);

    $delete_method = $conn->query("DELETE FROM paymentmethod WHERE methodId = '$methodId'");
    if($delete_method) {
        redirect("../User/userProfile.php", "Payment Method Delete Successfully");
    } else {
        errorRedirect("../User/userProfile.php", "Something Went Wrong");
    }
} elseif (isset($_POST['addUserAddress'])) {  //ADD ADDRESS
    $query = "SELECT * FROM address ORDER BY addId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['addId'];
    if($lastId == "") {
        $addId = "ADD1001";
    } else {
        $addId = substr($lastId, 3);
        $addId = intval($addId);
        $addId = "ADD".($addId + 1);
    }
    
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $phoneNo = $_POST['phoneNo'];
    $stateCity = $_POST['stateCity'];
    $postalCode = $_POST['postalCode'];
    $detailAdd = $_POST['detailAdd'];
    $labelAs = $_POST['labelAs'];
    if($_POST['defaultAdd'] == "yes"){
        $defaultAdd = '1';
        $update_default = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_default->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET defaultAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $defaultAdd = '0';
    }
    if($_POST['pickupAdd'] == "yes"){
        $pickupAdd = '1';
        $update_pickup = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_pickup->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET pickupAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $pickupAdd = '0';
    }
    if($_POST['returnAdd'] == "yes"){
        $returnAdd = '1';
        $update_return = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_return->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET returnAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $returnAdd = '0';
    }

    if($fullname = "" || $phoneNo = "" || $stateCity = "" || $postalCode == "" || $detailAdd == "") {
        echo "missing";
    } else {
        $address_query = $conn->query("INSERT INTO address (addId, fullName, phoneNo, stateCity, postalCode, detailAdd, labelAs, defaultAdd, pickupAdd, returnAdd, email, available) VALUES ('$addId', '$fullname', '$phoneNo', '$stateCity', '$postalCode', '$detailAdd', '$labelAs', '$defaultAdd', '$pickupAdd', '$returnAdd', '$email', '1')");
        if($address_query) {
            echo "true";
        } else {
            echo "false";
        }
    }
} elseif (isset($_POST['id'])) {    //GET ADDRESS INFO
    $addressId = $_POST['id'];

    $address = $conn->query("SELECT * FROM address WHERE addId = '$addressId' LIMIT 1");
    if(mysqli_num_rows($address) > 0) {
        $userAdd = mysqli_fetch_array($address);
        $userInfo = [
            'addId'=>$userAdd['addId'],
            'fullName'=>$userAdd['fullName'],
            'phoneNo'=>$userAdd['phoneNo'],
            'stateCity'=>$userAdd['stateCity'],
            'postalCode'=>$userAdd['postalCode'],
            'detailAdd'=>$userAdd['detailAdd'],
            'labelAs'=>$userAdd['labelAs'],
            'defaultAdd'=>$userAdd['defaultAdd'],
            'pickupAdd'=>$userAdd['pickupAdd'],
            'returnAdd'=>$userAdd['returnAdd']
        ];
        // echo implode(" ", $userInfo);
        echo json_encode($userInfo);
    } else {
        echo "false";
    }

    
} elseif (isset($_POST['updateAddress'])) {     //EDIT ADDRESS
    $query = "SELECT * FROM address ORDER BY addId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['addId'];
    if($lastId == "") {
        $addId = "ADD1001";
    } else {
        $newAddId = substr($lastId, 3);
        $newAddId = intval($newAddId);
        $newAddId = "ADD".($newAddId + 1);
    }

    $email = $_POST['email'];
    $addId = $_POST['addId'];
    $fullName = $_POST['fullName'];
    $phoneNo = $_POST['phoneNo'];
    $stateCity = $_POST['stateCity'];
    $postalCode = $_POST['postalCode'];
    $detailAdd = $_POST['detailAdd'];
    $labelAs = $_POST['labelAs'];
    if($_POST['defaultAdd'] == "yes"){
        $defaultAdd = '1';
        $update_default = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_default->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET defaultAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $defaultAdd = '0';
    }
    if($_POST['pickupAdd'] == "yes"){
        $pickupAdd = '1';
        $update_pickup = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_pickup->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET pickupAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $pickupAdd = '0';
    }
    if($_POST['returnAdd'] == "yes"){
        $returnAdd = '1';
        $update_return = $conn->query("SELECT * FROM address WHERE email = '$email'");
        while($result = $update_return->fetch_assoc()) {
            $address_id = $result['addId'];
            $conn->query("UPDATE address SET returnAdd = '0' WHERE addId = '$address_id'");
        }
    } else {
        $returnAdd = '0';
    }

    $address_query = $conn->query("INSERT INTO address (addId, fullName, phoneNo, stateCity, postalCode, detailAdd, labelAs, defaultAdd, pickupAdd, returnAdd, email, available) 
    VALUES ('$newAddId', '$fullName', '$phoneNo', '$stateCity', '$postalCode', '$detailAdd', '$labelAs', '$defaultAdd', '$pickupAdd', '$returnAdd', '$email', '1')");

    $update_address = $conn->query("UPDATE address SET available = '0' WHERE addId = '$addId'");

    if($address_query && $update_address) {
        echo "true";
    } else {
        echo "false";
    }
} elseif (isset($_POST['delete_address'])) {    //DELETE ADDRESS
    $addId = mysqli_real_escape_string($conn, $_POST['eId']);

    $delete_address = $conn->query("UPDATE address SET available = '0' WHERE addId = '$addId'");
    if($delete_address) {
        redirect("../User/userProfile.php", "Address Delete Successfully");
    } else {
        errorRedirect("../User/userProfile.php", "Something Went Wrong");
    }
} elseif (isset($_POST['addToWishlist'])) {
    $query = "SELECT * FROM wishlist ORDER BY wishId desc limit 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['wishId'];
    if($lastId == "") {
        $wishId = "WISH1001";
    } else {
        $wishId = substr($lastId, 4);
        $wishId = intval($wishId);
        $wishId = "WISH".($wishId + 1);
    }
    
    $prodId = $_POST['prodId'];
    $email = $_POST['email'];

    $check_exist = $conn->query("SELECT * FROM wishlist WHERE email = '$email' AND prodId = '$prodId' LIMIT 1");
    if(mysqli_num_rows($check_exist) > 0) {
        echo "exists";
    } else {
        $wishlist_query = $conn->query("INSERT INTO wishlist (wishId, email, prodId) VALUES ('$wishId', '$email', '$prodId')");
        if($wishlist_query) {
            echo "true";
        } else {
            echo "false";
        }
    }
} elseif (isset($_POST['btnRemoveWish'])) {
    $wishId = $_POST['wishId'];

    $delete_wish = $conn->query("DELETE FROM wishlist WHERE wishId = '$wishId'");
    if($delete_wish) {
        redirect("../User/wishlist.php", "Product Removed From Wishlist");
    } else {
        errorRedirect("../User/userProfile.php", "Something Went Wrong");
    }
} elseif (isset($_POST['rentalConfirmed'])) {
    $email = $_POST['email'];
    $prodId = $_POST['prodId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $rentPeriod = $_POST['rentPeriod'];
    $range = $_POST['range'];
    $rentDay = $_POST['rentDay'];
    $rentFees = $_POST['rentFees'];

    if($startDate == null) {
        echo "missing";
    } else {
        $check_pending = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND prodId = '$prodId' AND confirmRent = 0 AND status = 'Pending' LIMIT 1");
        if(mysqli_num_rows($check_pending) > 0) {
            echo "pending";
        } else {
            $check_existing = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND status = 'Pending'");
            if(mysqli_num_rows($check_existing) > 0) {
                $row = $check_existing->fetch_assoc();
                $rentId = $row['rentId'];
                $pending_rent = $conn->query("INSERT INTO pending_rent (rentId, email, prodId, startDate, endDate, rentPeriod, dateRange, rentDay, rentFees, confirmRent, status) 
                VALUES ('$rentId', '$email', '$prodId', '$startDate', '$endDate', '$rentPeriod', '$range', '$rentDay', '$rentFees', 0, 'Pending')");
                if($pending_rent) {
                    echo "true";
                } else {
                    echo "false";
                }
            } else {
                $query = "SELECT * FROM pending_rent ORDER BY rentId desc limit 1";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                $lastId = $row['rentId'];
                if($lastId == "") {
                    $rentId = "RENT1001";
                } else {
                    $rentId = substr($lastId, 4);
                    $rentId = intval($rentId);
                    $rentId = "RENT".($rentId + 1);
                }

                $pending_rent = $conn->query("INSERT INTO pending_rent (rentId, email, prodId, startDate, endDate, rentPeriod, dateRange, rentDay, rentFees, confirmRent, status) 
                VALUES ('$rentId', '$email', '$prodId', '$startDate', '$endDate', '$rentPeriod', '$range', '$rentDay', '$rentFees', 0, 'Pending')");
                if($pending_rent) {
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }
} elseif (isset($_POST['getProductInfo'])) {
    $email = $_POST['email'];
    $prodId = $_POST['prodId'];

    $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
    if(mysqli_num_rows($product) > 0) {
        $prodDetail = mysqli_fetch_array($product);

        $disableDate = $conn->query("SELECT * FROM pending_rent WHERE prodId = '$prodId' AND status = 'Pending'");
        $dates_ar = [];

        if(mysqli_num_rows($disableDate) > 0) {
            while ($ddate = $disableDate->fetch_array()) {
                $begin = new DateTime($ddate['startDate']);
                $end = new DateTime($ddate['endDate']);
                $end = $end->modify('+1 day');
                $interval = new DateInterval('P1D');
                $daterange = new DatePeriod($begin, $interval, $end);
                foreach ($daterange as $date) {
                    $dates_ar[] = $date->format("Y-m-d");
                }
            }
            $prodInfo = [
                'rentalPrice'=>$prodDetail['rental_price'],
                'prodPrice'=>$prodDetail['prodPrice'],
                'rentDate'=>$dates_ar
            ];
        } else {
            $dates_ar = [];
            $prodInfo = [
                'rentalPrice'=>$prodDetail['rental_price'],
                'prodPrice'=>$prodDetail['prodPrice'],
                'rentDate'=>$dates_ar
            ];
        }
        echo json_encode($prodInfo);
    } else {
        echo "false";
    }
} elseif (isset($_POST['cancelRental'])) {
    $rentId = $_POST['rentId'];

    $update_rent = $conn->query("UPDATE pending_rent SET status = 'Cancelled' WHERE rentId = '$rentId'");

    if($update_rent) {
        echo "true";
    } else {
        echo "false";
    }
} elseif (isset($_POST['getRentalDetails'])) {
    $email = $_POST['email'];
    $rentId = $_POST['rentId'];
    $addId = [];
    $methodId = [];

    $address = $conn->query("SELECT * FROM address WHERE email = '$email'");
    if(mysqli_num_rows($address) > 0) {
        while($addDetail = $address->fetch_array()) {
            $addId[] = $addDetail['addId'];
        }
    }

    $payMethod = $conn->query("SELECT * FROM paymentmethod WHERE email = '$email'");
    if(mysqli_num_rows($payMethod) > 0) {
        while($payDetail = $payMethod->fetch_array()) {
            $methodId[] = $payDetail['methodId'];
        }
    }

    $rentInfo = [
        // 'prodId'=>$rentDetail['prodId'],
        // 'startDate'=>$rentDetail['startDate'],
        // 'endDate'=>$rentDetail['endDate'],
        // 'rentFees'=>$rentDetail['rentFees'],
        // 'prodImg'=>$prodDetail['image'],
        'rentId'=>$rentId,
        'email'=>$email,
        'addId'=>$addId,
        'methodId'=>$methodId
    ];
    echo json_encode($rentInfo);
} elseif (isset($_POST['getAddress'])) {
    $addId = $_POST['addId'];

    $address = $conn->query("SELECT * FROM address WHERE addId = '$addId'");
    if(mysqli_num_rows($address) > 0) {
        $addDetail = mysqli_fetch_array($address);
        $addInfo = [
            'fullName'=>$addDetail['fullName'],
            'phoneNo'=>$addDetail['phoneNo'],
            'stateCity'=>$addDetail['stateCity'],
            'postalCode'=>$addDetail['postalCode'],
            'detailAdd'=>$addDetail['detailAdd'],
        ];
        echo json_encode($addInfo);
        // echo $addDetail['fullName'];
    } else {
        echo "false";
    }
} elseif (isset($_POST['getPayMethod'])) {
    $methodId = $_POST['methodId'];

    $payMethod = $conn->query("SELECT * FROM paymentmethod WHERE methodId = '$methodId'");
    $payMethodDetail = mysqli_fetch_array($payMethod);
    $methodInfo = [
        'cardholderName'=>$payMethodDetail['cardholderName'],
        'cardNo'=>$payMethodDetail['cardNo'],
        'expMth'=>$payMethodDetail['expMth'],
        'expYear'=>$payMethodDetail['expYear'],
        'cvv'=>$payMethodDetail['cvv']
    ];
    echo json_encode($methodInfo);
} elseif (isset($_POST['makePayment'])) { //MAKE PAYMENT BY PAYPAL
    $query = "SELECT * FROM loan ORDER BY loanId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['loanId'];
    if($lastId == "") {
        $loanId = "LOAN5001";
    } else {
        $loanId = substr($lastId, 4);
        $loanId = intval($loanId);
        $loanId = "LOAN".($loanId + 1);
    }
    
    $email = $_POST['email'];
    $totalPay = $_POST['totalPay'];
    $rentId = $_POST['rentId'];
    $addId = $_POST['addId'];
    $payment_mode = $_POST['payment_mode'];
    $payment_id = $_POST['payment_id'];

    $tracking_no = uniqid('TRACK');
    $pending_rent = $conn->query("UPDATE pending_rent SET confirmRent = '1', status = 'Pending Return' WHERE rentId = '$rentId'");
    $payment = $conn->query("INSERT INTO payments (payment_id, payer_email, amount, currency, payment_mode, payment_status) VALUES ('$payment_id', '$email', '$totalPay', 'MYR', '$payment_mode', 'Successful')");
    $rental_detail = $conn->query("INSERT INTO rental_details (rental_id, payment_id, email, address_id, tracking_no, rental_status) VALUES ('$rentId', '$payment_id', '$email', '$addId', '$tracking_no', 'Pending Delivery')");
    $loan = $conn->query("INSERT INTO loan (loanId, rentId, email, loan_status) VALUES ('$loanId', '$rentId', '$email', 'Incomplete')");
    echo "success";
} elseif (isset($_POST['requestTAC'])) {
    $email = $_POST['email'];
    $methodId = $_POST['methodId'];
    $cardholderName = $_POST['cardholderName'];
    $cardNo = $_POST['cardNo'];
    $expMth = $_POST['expMth'];
    $expYear = $_POST['expYear'];
    $cvv = $_POST['cvv'];

    if($cardholderName == "" || $cardNo == "" || $expMth == "" || $expYear == "" || $cvv == "") {
        echo "short";
    } else {
        $tacNum = rand(100000, 999999);
        setcookie("tac", $tacNum, time()+60*2, "/", NULL);
        
        $message = "$tacNum";
        $headers = "From: fyp.rnsservice@gmail.com<br>";
        // $headers .= "MIME-Version: 1.0<br>";
        // $headers .= "Content-type:text/html;charset=UTF-8<br>";

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "fyp.rnsservice@gmail.com";
        $mail->Password = 'gvwkiyvkdtlevhdc';    
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";

        $mail->isHTML(true);
        $mail->setFrom($email);
        $mail->addAddress($email);
        $mail->Subject = "R&S - Verify Email";
        $mail->Body = "$headers<br><br>"
                    . "<br>TAC Number: "
                    . "$message <br><br>"
                    . "-- <br> This e-mail was sent from a registered company, R&S Service (http://localhost/FinalYearProject/User/contactUs.php)";

        if($mail->send()){
            $status = "success";
            $response = "Email is sent";
            echo 'true';
        }else{
            $status = "failed";
            $response = "Something is wrong <br>".$mail->ErrorInfo;
            echo 'false';
        }
    }    
} elseif (isset($_POST['verifyTAC'])) { //MAKE PAYMENT BY CARD
    $query = "SELECT * FROM loan ORDER BY loanId desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['loanId'];
    if($lastId == "") {
        $loanId = "LOAN5001";
    } else {
        $loanId = substr($lastId, 4);
        $loanId = intval($loanId);
        $loanId = "LOAN".($loanId + 1);
    }

    $email = $_POST['email'];
    $tac = $_POST['tac'];
    $totalPay = $_POST['totalPay'];
    $rentId = $_POST['rentId'];
    $addId = $_POST['addId'];

    if(isset($_COOKIE['tac'])) {
        if($tac == $_COOKIE['tac']) {
            $payment_id = md5(time() . mt_rand(1, 1000000));
            $tracking_no = uniqid('TRACK');
            $pending_rent = $conn->query("UPDATE pending_rent SET confirmRent = '1' AND status = 'Pending Return' WHERE rentId = '$rentId'");
            $payment = $conn->query("INSERT INTO payments (payment_id, payer_email, amount, currency, payment_mode, payment_status) VALUES ('$payment_id', '$email', '$totalPay', 'MYR', 'Card', 'Successful')");
            $rental_detail = $conn->query("INSERT INTO rental_details (rental_id, payment_id, email, address_id, tracking_no, rental_status) VALUES ('$rentId', '$payment_id', '$email', '$addId', '$tracking_no', 'Pending Delivery')");
            $loan = $conn->query("INSERT INTO loan (loanId, rentId, email, loan_status) VALUES ('$loanId', '$rentId', '$email', 'Incomplete')");
            echo "match";
        } else {
            echo "nMatch";
        }
    } else {
        echo "error";
    }
} elseif (isset($_POST['payFine'])) {
    $fineId = $_POST['fineId'];
    $rentId = $_POST['rentId'];

    $update_fine = $conn->query("UPDATE fine SET pay_status = 'Paid' WHERE fineId = '$fineId'");
    $update_rent = $conn->query("UPDATE pending_rent SET status = 'Completed' WHERE fineId = '$fineId'");
    if($update_fine && $update_rent) {
        $check_status = $conn->query("SELECT * FROM pending_rent WHERE fineId = '$fineId' AND status = 'Pending Return' OR status = 'Pending Fine'");
        if(mysqli_num_rows($check_status) == 0) {

            $update_loan = $conn->query("UPDATE loan SET loan_status = 'Completed' WHERE rentId = '$rentId'");
        }
        echo "success";
    }
} elseif (isset($_POST['getCurrentStatus'])) {
    $trackNo = $_POST['trackNo'];
    $track = $conn->query("SELECT * FROM rental_details WHERE tracking_no = '$trackNo'");
    $result = $track->fetch_assoc();
    $trackInfo = [
        'status'=>$result['rental_status']
    ];
    echo json_encode($trackInfo);
}
?>