<?php
session_start();
require_once "../config/constant.php";

$sql_fetch_todos = "SELECT * FROM product ORDER BY id ASC";
$query = mysqli_query($conn, $sql_fetch_todos);
?>
<!doctype html>
<html lang="en">

    <head>
        <title>CRUD Operation</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="dp.png">
        <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: "Mitr", sans-serif;
                background-color: rgb(240, 187, 228);
            }
            .header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px;
                height: 50px;
                padding: 5px 13px 11px 0px;
                width: 100%;
                color: white;
                font-family: "Mitr", sans-serif;
                margin-top: 0px;
                bottom: 0;
                background-color: rgb(248, 140, 210);
            }
            .header p {
                margin-left: 20px;
                text-align: left;
            }
            .button-logout {
                position: relative;
                margin-top: -50px;
                margin-right: 20px;
                float: right;
                text-decoration: none;
                border: transparent;
                border-radius: 15px;
                background-color: #e60000;
                padding: 10px 10px 10px 10px;
                color: white;
                transition: 0.5s;
            }
            .button-logout:hover {
                background-color: #D9ddd4;
                color: red;
            }
            .container {
                margin: 90px auto;
                margin-bottom: 50px;
                border-radius: 30px;
                text-align: center;
                background-color: white;
                width: 40%;
                padding-bottom: 10px;
            }

            table th,
            tr,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 10px 0px 10px 0px;
            }

            table {
                width: 100%;
            }

            th {
                color: white;
                background-color: rgb(248, 140, 210);
            }

            tr {
                background-color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .timeregis {
                text-align: center;
            }

            .form-group {
                margin-left: 600px;
            }

            [type=text], [type=number] {
                font-family: "Mitr", sans-serif;
                border-radius: 15px;
                border: transparent;
                padding: 7px 200px 7px 5px;
            }

            .return {
                border-radius: 15px;
                background-color: #ffcc33;
                color: black;
                text-decoration: none;
                padding: 4px 40px 4px 40px;
                margin: 0px 0px 50px 100px;
                font-size: 20px;
                transition: 0.5s;

            }

            .return:hover {
                background-color: #fdb515;
                color: white;
            }

            .modify {
                border-radius: 15px;
                border: transparent;
                color: white;
                padding: 4px 40px 4px 40px;
                margin: 0px 50px 50px 100px;
                font-size: 20px;
                border-collapse: collapse;
                background-color: #00A600;
                font-family: "Mitr", sans-serif;
                transition: 0.5s;

            }

            .modify:hover {
                color: black;
                background-color: #BBFFBB;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <h1>List of product:</h1>

        </div>
        <div class="table-product">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Order</th>
                        <th scope="col">ID:Product</th>
                        <th scope="col">List</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date Regis:</th>
                        <th scope="col">Product code:</th>
                    </tr>
                </thead>
                <tbody>
<?php
$idpro = 1;
while ($row = mysqli_fetch_array($query)) {
    ?>
                        <tr>
                            <td scope="row"><?php echo $idpro ?></td>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['product_name'] ?></td>
                            <td><?php echo $row['product_price'] ?></td>
                            <td class="timeregis"><?php echo $row['product_image'] ?></td>
                            <td><?php echo $row['product_code'] ?></td>
                        </tr>
                        <?php
                        $idpro++;
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <div class="addproduct">
                <form method="POST" action="addlist.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">List product : </label>
                        <br>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Amount : </label>
                        <br>
                        <input type="number" class="form-control" name="amount" required> </div> <br>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Product quantity : </label>
                        <br>
                        <input type="number" class="form-control" name="qty" required> </div> <br>
                    <div class="form-group">
                        <label for="">Upload Image: </label>
                        <br>
                        <input type="file" class="form-control" name="image" required> </div> <br>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Product code : </label>
                        <br>
                        <input type="text" class="form-control" name="code" required> </div> <br>
                         <div class="form-group">
                        <label for="exampleInputPassword1">Desc: </label>
                        <br>
                        <input type="text" class="form-control" name="desc" required> </div> <br>
                    <div class="form-group">
                        <label for="exampleInputPassword1">type : </label>
                        <br>
                        <select name="type">  
                            <option value="mobile">mobile</option>}  
                            <option value="grocery">grocery</option>  
                            <option value="electronic">electronic</option>  
                            <option value="fashion">fashion</option>  
                            
                        </select>   
                        <div class="form-button">
                            <button type="submit" class="modify" style="float:right">Add</button>
                            <a name="" id="" class="return" href="indexAdmin.php" role="button" style="float:left">Return</a>
                        </div>
                </form>
            </div>
        </div>
        <?php
        mysqli_close($conn);
        ?>
    </body>

</html>