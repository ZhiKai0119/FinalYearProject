<?php
$conn = mysqli_connect("localhost", "root", "root", "r&s");
if(!$conn) {
    die("Connection Error: ". mysqli_error($conn));
}

function insertData($data) {
    $email = $data['email'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $checkUser = mysqli_query($conn, $sql);
    $info = mysqli_fetch_assoc($checkUser);

    if(!$info) {
        echo "Correct";
    } else {
        echo "Exists";
    }
}

class Connect extends PDO {
    public function __construct() {
        parent::__construct("mysql:host=localhost;dbname=google_login", "root", "root", 
                array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    }
}

class Controller {
    
    function generateCode() {
        $chars = "vWyzABC0123456";
        $code = "";
        $clean = strlen($chars) - 1;
        while(strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clean)];
        }
        return $code;
    }
    
    function insertData($data) {
        $db = new Connect;
        $email = $data['email'];
        $sql = "SELECT * FROM users WHERE email='$email'";
        $checkUser = mysqli_query($this->conn, $sql);
        $info = mysqli_fetch_assoc($checkUser);
        
        if(!$info) {
            echo "Correct";
        } else {
            echo "Exists";
        }
    }
}
?>