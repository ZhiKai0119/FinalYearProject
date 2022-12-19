
<html>
    <head>
    <head>
        <meta charset="UTF-8">
     
        <title>Register</title>
        <link rel="shortcut icon" href="imgs/RNS_white.png" type="image/gif">
        <link href="./CSS/register.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include "helper.php";
        require_once './config/constant.php';
       $conn = mysqli_connect($hostname, $username, $password, $database);


        if (isset($_POST['btnSubmit'])) {
            $customerID= isset($_POST['customerID']) ? trim($_POST['customerID']) : null;
            $Username = isset($_POST['Username']) ? trim($_POST['Username']) : null;
            $Email = isset($_POST['Email']) ? trim($_POST['Email']) : null;
            $Phone = isset($_POST['Phone']) ? trim($_POST['Phone']) : null;
            $Password = isset($_POST['Password']) ? trim($_POST['Password']) : null;
            $ComPass = isset($_POST['ComPass']) ? trim($_POST['ComPass']) : null;


            $errorMsgCustomerID = validateStudentID($customerID);
            $errorMsgUsername = validateUsername($Username);
            $errorMsgEmail = validateEmail($Email);
            $errorMsgPhone = validatePhone($Phone);
            $errorMsgPassword = validatePassword($Password);
            $errorMsgComPass = validateComPass($ComPass, $Password);

            $finalErrorMessages = array_merge(array_merge(array_merge(array_merge(array_merge($errorMsgCustomerID, $errorMsgUsername), $errorMsgEmail), $errorMsgPhone), $errorMsgPassword), $errorMsgComPass);

            if (count($finalErrorMessages) == 0) {
                require_once './config/constant.php';

                $query = "INSERT INTO users(customerID,Username, Email, Phone, Password, Registration_date, UserType) VALUES ('$customerID','$Username','$Email','$Phone','$Password',NOW(),'User')";
                $r = mysqli_query($conn, $query);

                if ($r) { // If it ran OK.
                    // Print a message:
                    echo '<h1>Thank you!</h1><p>You are now registered. <br /></p>';
                    echo '<p class="link" >Click here to <a href="login.php">Login</a></p>';

//		
                } else { // If it did not run OK.
                    // Public message:
                    echo '<h1>System Error</h1>
			<p class="error"> ' . $customerID . ' already registered, Try to key in another ID';
                } // End of if ($r) IF.

                mysqli_close($conn); // Close the database connection.


                exit();
            } else { // Report the errors
                echo "<div class='error'>";
                echo "<ul>";
                foreach ($finalErrorMessages as $errorMessage) {
                    echo "<li style='color: red;'>" . $errorMessage . "</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            echo '</p><p>Please try again.</p><p><br/></p>';
        } // End of if (empty($errors)) IF.
        ?>



        <form method ="POST" action="">
            <div class="content-wrapper">
                <div class="form-box">
                    <div class="formLogo">
                        <img src="imgs/RNS_white.png" alt="Green Society Logo">
                        <li class="title">RNS sell&rent</li>
                    </div>
                    <p class="register head">Sign up</p>
                    <span onclick="" class="close"> <a href="index.php">&times;</a></span>
                    <?php printHTMLInput("customerID", isset($_POST['customerID']) ? $_POST['customerID'] : '', "text", " ", "text", "customerID", "input-field") ?>
                    <?php printHTMLInput("Username",  isset($_POST['Username']) ? $_POST['Username']   : '', "text", " ", "text", "Username", "input-field") ?>
                    <?php printHTMLInput("Email",     isset($_POST['Email']) ? $_POST['Email']         : '', "text", " ", "text", "Email", "input-field") ?>
                    <?php printHTMLInput("Phone",     isset($_POST['Phone']) ? $_POST['Phone']         : '', "text", " ", "text", "Phone Number", "input-field") ?>
                    <?php printHTMLInput("Password",  isset($_POST['Password']) ? $_POST['Password']   : '', "password", " ", "password", "Password", "input-field") ?>
                    <?php printHTMLInput("ComPass",   isset($_POST['ComPass']) ? $_POST['ComPass']     : '', "password", " ", "password", "Confirm Password", "input-field") ?>
                    <button type="submit" class="submit-btn" name="btnSubmit">Sign up</button>
                    <p class="small"> Already have a account? <a href="login.php">Click here for log in</a></p>
                    </form>
                </div>
            </div>
    </body> 
</html>