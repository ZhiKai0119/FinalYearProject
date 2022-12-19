<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R&S Service Admin Dashboard</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">
        <!--        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />-->
        <link rel="stylesheet" href="../CSS/dashboard.css">
    </head>
    <body>
        <div class="container">
            <aside>
                <div class="top">
                    <div class="logo">
                        <img src="../imgs/R&S_Logo.png">
                        <h2>R&S <span class="danger">Service</span></h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-symbols-sharp">close</span>
                    </div>
                </div>

                <div class="sidebar">

                    <a href="customer.php" class="active">
                        <span class="material-symbols-sharp">person_outline</span>
                        <h3>Customers</h3>
                    </a>
                    <a href="manageOrder.php">
                        <span class="material-symbols-sharp">receipt_long</span>
                        <h3>Orders</h3>
                    </a>
                  
                    
                    <a href="addProduct.php">
                        <span class="material-symbols-sharp">add</span>
                        <h3>Add Product</h3>
                    </a>
                    <a href="../logout.php">
                        <span class="material-symbols-sharp">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>

            <main>
                <h1>Dashboard</h1>



                <div class="insights">


                    <div class="customer">
                        <span class="material-symbols-sharp">stacked_line_chart</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Customers</h3>
                                <?php
                                include '../config/constant.php';
                                $stmt = $conn->prepare('SELECT count(*) FROM users where UserType = "User"');
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()):
                                ?>
                                

                                <h1><?php echo $row['count(*)']?></h1>
                            </div>
                           
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                </div>
            </main>
        </div>
<?php endwhile; ?>
    </body>
</html>
