<?php
function printHTMLInput($name, $value, $type, $maxlength, $required, $placeholder, $class) {
    echo "<input name='$name' value='$value' type='$type' maxlength='$maxlength' required='$required' placeholder='$placeholder' class=$class />";
}


function validateStudentID($customerID) {
    $errorMessageCustomerID = array();

    if ($customerID == "" || $customerID == null) {
        $errorMessageCustomerID[] = "please fill out the Customer ID.";
    }

   
    return $errorMessageCustomerID;
}

function validateUsername($Username) {
    $errorMsgUsername = array();

    $pattern = "/^[A-Za-z @,'.-\/]+$/";
    if (preg_match($pattern, $Username) == false) {
        $errorMsgUsername[] = "Username invalid format. Format : Username should not include with any numbers.";
    }
    return $errorMsgUsername;
}

function validateEmail($Email) {
    $errorMsgEmail = array();

    $pattern = "/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/";
    if (preg_match($pattern, $Email) == false) {
        $errorMsgEmail[] = "Invalid email format. Format = xxx@xxx.com.";
    }
    return $errorMsgEmail;
}

function validatePhone($Phone) {
    $errorMsgPhone = array();

    if ($Phone == "" || $Phone == null) {
        $errorMsgPhone[] = "Please enter your contact number.";
    }

    $pattern = "/^\d{3}-\d{7}$/";

    if (preg_match($pattern, $Phone) == false) {
        $errorMsgPhone[] = "Invalid Contact Number entered.";
    }

    return $errorMsgPhone;
}

function validatePassword($Password) {
    $errorMsgPassword = array();

    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/";
    if (preg_match($pattern, $Password) == false) {
        $errorMsgPassword[] = "Password must between 8 to 15 characters with atleast 1 uppercase , 1 lowercase , 1 speacial character and 1 number";
    }
    return $errorMsgPassword;
}

function validateComPass($ComPass, $Password) {
    $errorMsgComPass = array();

    if ($ComPass != $Password) {
        $errorMsgComPass[] = "Comfirm Password must match the password.";
    }
    return $errorMsgComPass;
}
function validateNewPassword($newPass) {
    $errorMsgNewPassword = array();

    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/";
    if (preg_match($pattern, $newPass) == false) {
       $errorMsgNewPassword[] = "Password must between 8 to 15 characters with atleast 1 uppercase , 1 lowercase , 1 speacial character and 1 number";
    }
    return $errorMsgNewPassword;
}

?>