<?php
//require_once './Core/controller.Class';
//require_once './Core/controlDB.php';
require_once 'config.php';
if(isset($_GET["code"])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
    //$gClient->setAccessToken($token['access_token']);
} else {
    header("Location: index.php");
    exit();
}

if(isset($token["error"]) != "invalid_grant") {
    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

//    echo "<pre>";
//    var_dump($userData);
//    echo "</pre>";
    
    $userInfo = [
        'email'=>$userData['email'],
        'picture'=>$userData['picture'],
        'fname'=>$userData['familyName'],
        'lname'=>$userData['givenName'],
        'fullName'=>$userData['name'],
        'verifiedEmail'=>$userData['verifiedEmail'],
        'token'=>$userData['id']
    ];
    
    //Cecking if user is already exists in database
    $sql = "SELECT * FROM users WHERE email ='{$userInfo['email']}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        
        $userInfo = mysqli_fetch_assoc($result);
        setcookie("id", $userInfo['id'], time()+60*60*24*30, "/", NULL);
        setcookie("token", $userInfo['token'], time()+60*60*24*30, "/", NULL);
        $_SESSION['user_token'] = $userInfo['token']; 
        
//        $loginSQL = "SELECT * FROM login WHERE username = '{$userInfo['fullName']}' AND logoutDateTime = '0000-00-00 00:00:00' LIMIT 1";
//        $loginResult = mysqli_query($conn, $loginSQL);
//        if($loginResult) {
//            $loginInfo = mysqli_fetch_assoc($loginResult);
//            $loginId = $loginInfo['id'];
//            $updateLogin = $conn->query("UPDATE login SET logoutDateTime = now() WHERE id = '{$loginId}'");
//            
//            $recordLogin = $conn->query("INSERT INTO login (username, role) VALUES ('{$userInfo['fullName']}', '{$userInfo['role']}')");
//        } else {
//            $recordLogin = $conn->query("INSERT INTO login (username, role) VALUES ('{$userInfo['fullName']}', '{$userInfo['role']}')");
//        }
        
        if($userInfo['role'] == 'Admin') {
            $recordLogin = $conn->query("INSERT INTO login (username, role) VALUES ('{$userInfo['fullName']}', '{$userInfo['role']}')");
            header("Location: Owner/main.php?dashboard");
        } else {
            $recordLogin = $conn->query("INSERT INTO login (username, role) VALUES ('{$userInfo['fullName']}', '{$userInfo['role']}')");
            header("Location: User/main.php");
        }
    } else {
        $url_img = $userInfo['picture'];
        $img_dir = 'Images/';
        $image_ext = pathinfo($url_img, PATHINFO_EXTENSION);
        $filename = time().'.'.$image_ext.'png';
        $complete_save = $filename;
        
        $sql = "INSERT INTO users (fname, lname, fullName, picture, email, verifiedEmail, token, role) "
                . "VALUES ('{$userInfo['fname']}', '{$userInfo['lname']}', '{$userInfo['fullName']}', '{$complete_save}', '{$userInfo['email']}', '{$userInfo['verifiedEmail']}', '{$userInfo['token']}', 'Customer')";
        $insertUser = mysqli_query($conn, $sql);
        
        if($insertUser) {
            file_put_contents('Images/'.$complete_save, file_get_contents($url_img));
            setcookie("id", $conn->insert_id, time()+60*60*24*30, "/", NULL);
            setcookie("token", $userInfo['token'], time()+60*60*24*30, "/", NULL);
            $_SESSION['user_token'] = $userInfo['token'];
            $recordLogin = $conn->query("INSERT INTO login (username, role) VALUES ('{$userInfo['fullName']}', '{$userInfo['role']}')");
            header("Location: User/main.php");
            exit();
        } else {
            return "Error inserting user!";
        }
    }
    
//    $Controller = new Controller;
//    echo $Controller->insertData(array(
//        'email'=>$userData['email'],
//        'avatar'=>$userData['picture'],
//        'familyName'=>$userData['familyName'],
//        'givenName'=>$userData['givenName']
//    ));

} else {
    header("Location: index.php");
    exit();
}

?>