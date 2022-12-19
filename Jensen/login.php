<html>
    <head>
        <meta charset="UTF-8">
        <meta name="Green Society" content="green,Events,society,participants"/>
        <title>Login</title>
       <link rel="shortcut icon" href="pic/buylogo.jpg" type="image/gif">
        <link href="./CSS/register.css" rel="stylesheet" type="text/css"/>
    </head>

    <?php
     session_start();
     include './helper.php';
    require_once './config/constant.php';
   $conn = mysqli_connect($hostname, $username, $password, $database);

    if (isset($_GET['btnSubmit'])) {
        $customerID = isset($_GET['customerID']) ? ($_GET['customerID']) : null;
        $Username = isset($_GET['Username']) ? ($_GET['Username']) : null;
        $Password = isset($_GET['Password']) ? ($_GET['Password']) : null;
        $UserType = isset($_GET['UserType']) ? ($_GET['UserType']) : null;

        $query = "SELECT * FROM users WHERE customerID ='$customerID' AND Username= '$Username' AND Password ='$Password'";
        $result = mysqli_query($conn, $query);
        $_SESSION['customerID'] = $_GET['customerID'];

       if($result){
            if($result && $rows = mysqli_num_rows($result) >0){
                
               
              
                $user_data = mysqli_fetch_assoc($result);
                if($user_data['UserType'] == 'User'){
                    header("Location: index.php");
                    exit();
                }
                if($user_data['UserType'] == 'Admin'){
                    header("Location: ./admin/indexAdmin.php");
                    exit();
                }
            } else {
            echo "<div class = 'form'>
            <h3>Incorrect CustomerID /Username/password.</h3><br/>
                  <p class='link'>please try again.</p>
                    
                  </div>";
        
            

        }
        }
    }
    ?>
    <body>
        <div class="content-wrapper">
            <div class="form-box">
                <div class="formLogo">             
                    <img src="./imgs/RNS_white.png" class="text-danger">
                    <li class="title"> R&S (RENT & SELL) </li>
                </div>
                <p class="login head">Log in</p>

                <form method ="GET" action="">
                    <span onclick="" class="close" title="home page"> <a href="index.php">&times;</a></span>
                    <?php printHTMLInput("customerID", isset($_POST['customerID']) ? $_POST['customerID'] : '', "text", " ", "text", "customerID", "input-field") ?>
                    <?php printHTMLInput("Username",  isset($_POST['Username']) ? $_POST['Username']   : '', "text", " ", "text", "Username", "input-field") ?>
                    <?php printHTMLInput("Password",  isset($_POST['Password']) ? $_POST['Password']   : '', "password", " ", "password", "Password", "input-field") ?>
       
                    <button type="submit" class="submit-btn" name="btnSubmit">Login</button>
                    <a href="forget_password.html" class="text-info forgot" >Forgot password?</a>
                    <p class="text-danger small"> Didn't have an account? <a href="register.php">Click here for register</a>.</p>
                </form>
            </div>
        </div>
    </body>
</html>