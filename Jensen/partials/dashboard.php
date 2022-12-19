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
                        <img src="../../Images/R&S_Logo.png">
                        <h2>R&S <span class="danger">Service</span></h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-symbols-sharp">close</span>
                    </div>
                </div>
                
                <div class="sidebar">
                    <a href="#">
                        <span class="material-symbols-sharp">dashboard</span>
                        <h3>Dashboard</h3>
                    </a>
                    <a href="#" class="active">
                        <span class="material-symbols-sharp">person_outline</span>
                        <h3>Customers</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">receipt_long</span>
                        <h3>Orders</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">insights</span>
                        <h3>Analytics</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">mail_outline</span>
                        <h3>Messages</h3>
                        <span class="message-count">26</span>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">inventory</span>
                        <h3>Products</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">report_gmailerrorred</span>
                        <h3>Reports</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">settings</span>
                        <h3>Settings</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">add</span>
                        <h3>Add Product</h3>
                    </a>
                    <a href="#">
                        <span class="material-symbols-sharp">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>
            
            <main>
                <h1>Dashboard</h1>
                
                <div class="date">
                    <input type="date">
                </div>
                
                <div class="insights">
                    <div class="sales">
                        <span class="material-symbols-sharp">analytics</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Sales</h3>
                                <h1>RM25,024</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy='38' r='36'></circle>
                                </svg>
                                <div class="number">
                                    <p>81%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    
                    <div class="expenses">
                        <span class="material-symbols-sharp">bar_chart</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Expenses</h3>
                                <h1>RM14,160</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy='38' r='36'></circle>
                                </svg>
                                <div class="number">
                                    <p>62%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                    
                    <div class="income">
                        <span class="material-symbols-sharp">stacked_line_chart</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Income</h3>
                                <h1>RM10,864</h1>
                            </div>
                            <div class="progress">
                                <svg>
                                    <circle cx='38' cy='38' r='36'></circle>
                                </svg>
                                <div class="number">
                                    <p>44%</p>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                </div>
            </main>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
