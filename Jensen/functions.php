<?php

function pdo_connect_mysql() {
    if (!isset($_SESSION['customerID'])) {
        echo "<h1>Warning</h1>";
        echo "<h2>No permission allowed to access this page</h2>";
        echo "<p>Click here to<a href=\"login.php\">Login</a></p>";
        exit(); // Quit the script.
    }
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost:3306';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    $DATABASE_NAME = 'r_s';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}

// Template header, feel free to customize this
function template_header($title) {
    // Get the amount of items in the shopping cart, this will be displayed in the header.

    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="./CSS/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <header>
           
                </nav>
                <div class="link-icons">
                    <a href="index.php?page=cart">
        
					
					</a>
                </div>
            </div>
        </header>
        <main>
EOT;
}

// Template footer
function template_footer() {
    $year = date('Y');
    echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year, Shopping Cart System</p>
            </div>
        </footer>
    </body>
</html>
EOT;
}

?>
