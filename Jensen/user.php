<?php
include '../config/constant.php';

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
            if(file_exists("../Images/".$old_image)) {
                unlink("../Images/".$old_image);
            }
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
} elseif (isset($_POST['email']) && isset($_POST['cardholderName']) && isset($_POST['cardNo'])) {
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
        $addId = "ADD1";
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
    } else {
        $defaultAdd = '0';
    }
    if($_POST['pickupAdd'] == "yes"){
        $pickupAdd = '1';
    } else {
        $pickupAdd = '0';
    }
    if($_POST['returnAdd'] == "yes"){
        $returnAdd = '1';
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
    } else {
        $defaultAdd = '0';
    }
    if($_POST['pickupAdd'] == "yes"){
        $pickupAdd = '1';
    } else {
        $pickupAdd = '0';
    }
    if($_POST['returnAdd'] == "yes"){
        $returnAdd = '1';
    } else {
        $returnAdd = '0';
    }

    $address_query = $conn->query("INSERT INTO address (addId, fullName, phoneNo, stateCity, postalCode, detailAdd, labelAs, defaultAdd, pickupAdd, returnAdd, email, available) 
    VALUES ('$newAddId', '$fullName', '$phoneNo', '$stateCity', '$postalCode', '$detailAdd', '$labelAs', '$defaultAdd', '$pickupAdd', '$returnAdd', '$email', '1')");

    $update_address = $conn->query("UPDATE address SET available = 0 WHERE addId = '$addId'");

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
} elseif (isset($_POST['rentalConfirmed'])) { //TODO: validation check
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
    
    $email = $_POST['email'];
    $prodId = $_POST['prodId'];
    $startDate = $_POST['startDate'];
    $rentPeriod = $_POST['rentPeriod'];
    $range = $_POST['range'];
    $rentDay = $_POST['rentDay'];
    $rentFees = $_POST['rentFees'];
    $deposit = $_POST['deposit'];
    $totalFees = $_POST['totalFees'];

    if($startDate == null) {
        echo "missing";
    } else {
        $check_pending = $conn->query("SELECT * FROM pending_rent WHERE email = '$email' AND prodId = '$prodId' AND confirmRent = 0 AND status = 'Pending' LIMIT 1");
        if(mysqli_num_rows($check_pending) > 0) {
            echo "pending";
        } else {
            $pending_rent = $conn->query("INSERT INTO pending_rent (rentId, email, prodId, startDate, rentPeriod, range, rentDay, rentFees, deposit, totalFees, confirmRent, status) 
            VALUES ('$rentId', '$email', '$prodId', '$startDate', '$rentPeriod', '$range', '$rentDay', '$rentFees', '$deposit', '$totalFees', 0, 'Pending')");
            if($pending_rent) {
                echo "true";
            } else {
                echo "false";
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

    $rental = $conn->query("SELECT * FROM pending_rent WHERE rentId = '$rentId' LIMIT 1");
    if(mysqli_num_rows($rental) > 0) {
        $rentDetail = mysqli_fetch_array($rental);

        $prodId = $rentDetail['prodId'];
        $product = $conn->query("SELECT * FROM products WHERE prodId = '$prodId' LIMIT 1");
        if(mysqli_num_rows($product) > 0) {
            $prodDetail = mysqli_fetch_array($product);

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
                'prodId'=>$rentDetail['prodId'],
                'startDate'=>$rentDetail['startDate'],
                'endDate'=>$rentDetail['endDate'],
                'rentFees'=>$rentDetail['rentFees'],
                'deposit'=>$rentDetail['deposit'],
                'totalFees'=>$rentDetail['totalFees'],
                'prodImg'=>$prodDetail['image'],
                'addId'=>$addId,
                'methodId'=>$methodId
            ];
        }

        echo json_encode($rentInfo);
    } else {
        echo "false";
    }
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
} elseif (isset($_POST['makePayment'])) {
    echo "success";
} elseif (isset($_POST['registerUser'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    echo "register completed";
}
?>