<?php
require_once './google-api/vendor/autoload.php';
session_start();

$gClient = new Google_Client();
$gClient->setClientId("64874558551-bong1m216ibjfsuaqsdi8sko5mp8t0aq.apps.googleusercontent.com");
$gClient->setClientSecret("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");
$gClient->setApplicationName("R&S Login");
$gClient->setRedirectUri("http://localhost/FinalYearProject/controller.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

$login_url = $gClient->createAuthUrl();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "r&s";

$conn = mysqli_connect($hostname, $username, $password, $database);
?>

<?php
//require_once './Core/controller.Class';
//require_once './Core/controlDB.php';
//require_once 'config.php';
//if(isset($_GET["code"])) {
//    $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
//} else {
//    header("location: index.php");
//    exit();
//}
//
//if(isset($token["error"]) != "invalid_grant") {
//    $oAuth = new Google_Service_Oauth2($gClient);
//    $userData = $oAuth->userinfo_v2_me->get();
//
////    echo "<pre>";
////    var_dump($userData);
////    echo "</pre>";
//    
//    $Controller = new Controller;
//    echo $Controller->insertData(array(
//        'email'=>$userData['email'],
//        'avatar'=>$userData['picture'],
//        'familyName'=>$userData['familyName'],
//        'givenName'=>$userData['givenName']
//    ));
//} else {
//    header("Location: index.php");
//    exit();
//}

?>