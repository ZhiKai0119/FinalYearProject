
<html>
   
    <body>
        <?php
        // logout_sessions.php 
// This page lets the user logout.

        session_start(); // Access the existing session.
// If no session variable exists, redirect the user:
        if (!isset($_SESSION['customerID'])) {
            echo "<h1>Warning</h1>";
            echo "<h2>No permission allowed to access this page</h2>";
              echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
            exit(); // Quit the script.
        } else { // Cancel the session.
           unset($_SESSION['customerID']);
        }

// Set the page title and include the HTML header:
           

// Print a customized message:

        echo "<h1>Logged Out (Using Sessions)</h1>
<p>You are now logged out!</p>";
         echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
         
        ?>
