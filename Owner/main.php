<?php include '../config/constant.php'; ?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>R&S Service Admin</title>
        <link rel="stylesheet" href="CSS/sidebar.css">
        
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Alertify Js-->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    </head>
    <body>
        <?php include './Partials/sidebar.php'; ?>
        
        <section class="home-section">
            <div class="home-content row">
                <i class='bx bx-menu' ></i><span class="text">Admin</span>
            </div>
            <div class="row main">
                <?php 
                if(isset($_GET['categories'])) {
                    include 'view-category.php';
                } 
                if(isset($_GET['add-category'])) {
                    include 'add-category.php';
                } 
                if(isset($_GET['edit-category'])) {
                    include "edit-category.php";
                } 
                if(isset($_GET['view-product'])) {
                    include "view-product.php";
                } 
                if(isset($_GET['add-product'])) {
                    include "add-product.php";
                } 
                if(isset($_GET['edit-product'])) {
                    include "edit-product.php";
                } 
                if(isset($_GET['donate'])) {
                    include "add_donation.php";
                } 
                if(isset($_GET['edit-donation'])) {
                    include "edit_donation.php";
                } 
                if(isset($_GET['subscribe'])) {
                    include "subscribers.php";
                }
                ?>
            </div>
        </section>
        <script type="text/javascript">
            let arrow = document.querySelectorAll(".arrow");
            for (var i = 0; i < arrow.length; i++) {
                arrow[i].addEventListener("click", (e)=>{
                let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
                });
            }
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".bx-menu");
            console.log(sidebarBtn);
            sidebarBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("close");
            });
        </script>
        
        <!--Alertify Js-->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <script>
            <?php if(isset($_COOKIE['status'])) { ?>
                alertify.set('notifier','position', 'top-right');
                alertify.success('<?php echo $_COOKIE['status']; ?>'); 
            <?php } ?>
        </script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $(document).on('click', '.delete_product_btn', function (e) {
                    e.preventDefault();
                    
                    var id = $(this).val();
                                        
                    swal({
                          title: "Are you sure?",
                          text: "Once deleted, you will not be able to recover",
                          icon: "warning",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            $.ajax({
                               method: "POST",
                               url: "process/product.php",
                               data: {
                                   'product_id': id,
                                   'delete_product_btn': true
                               },
                               success: function(response) {
                                   console.log(response);
                                   if(response == "success") {
                                       swal("Success!", "Product Delete Successfully", "success");
                                       $("#products_table").load(Location.href = "main.php?view-product" + " #products_table");
                                   } else if(response == "error") {
                                       swal("Error!", "Something Went Wrong", "error");
                                   }
                               }
                            });
                          }
                        });
                });
            });
        </script>
        
        <script>
            $(document).ready(function () {
                $(document).on('click', '.delete_category_btn', function (e) {
                    e.preventDefault();
                    
                    var id = $(this).val();
                    
                    swal({
                          title: "Are you sure?",
                          text: "Once deleted, you will not be able to recover",
                          icon: "warning",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            $.ajax({
                               method: "POST",
                               url: "process/category.php",
                               data: {
                                   'category_id': id,
                                   'delete_category_btn': true
                               },
                               success: function(response) {
                                   console.log(response);
                                   if(response == 'success') {
                                       swal("Success!", "Category Delete Successfully", "success");
                                       $("#category_table").load(Location.href = "main.php?categories" + " #category_table");
                                   } else if(response == "error") {
                                       swal("Error!", "Something Went Wrong", "error");
                                   } else {
                                       swal("Error!", response, "error");
                                   }
                               }
                            });
                          }
                        });
                });
            });
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>
