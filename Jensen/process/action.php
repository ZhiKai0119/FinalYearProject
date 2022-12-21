<?php 
include '../config/constant.php';

if(isset($_POST['addCart'])) {
    $email = $_POST['email'];
    $prodCode = $_POST['prodCode'];
    $prodQty = $_POST['prodQty'];
    $prodPrice = $_POST['prodPrice'];      
    $subtotal = $prodQty * $prodPrice;

    $find = $conn->query("SELECT * FROM cart WHERE email = '$email' AND status = 'Pending'");
    if($find->num_rows > 0) {
        $num = $find->fetch_assoc();
        $cartId = $num['cartId'];

        if($current = $conn->query("SELECT * FROM cart WHERE email = '$email' AND prodCode = '$prodCode' AND status = 'Pending'")) {
            if($current->num_rows > 0) {
                $current = $current->fetch_assoc();
                $newQty = $num['qty'] + $prodQty;

                $product = $conn->query("SELECT * FROM sell_product WHERE product_code = '$prodCode' LIMIT 1");
                $data = $product->fetch_assoc();

                if($newQty > $data['product_qty']) {
                    echo "over";
                    exit();
                } else {
                    $subtotal = $newQty * $prodPrice;
                    $update = $conn->query("UPDATE cart SET qty = '$newQty', subtotal = '$subtotal' WHERE email = '$email' AND prodCode = '$prodCode' AND status = 'Pending'");
                    if($update) {
                        echo "success";
                    } else {
                        echo "error";
                    }
                }
            } else {
                $conn->query("INSERT INTO cart (cartId, email, prodCode, qty, prodPrice, subtotal, status) VALUES ('$cartId', '$email', '$prodCode', '$prodQty', '$prodPrice', '$subtotal', 'Pending')");
                echo "success";
            }
        }
    } else {
        $query = "SELECT * FROM cart ORDER BY cartId desc limit 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $lastId = $row['cartId'];
        if($lastId == "") {
            $cartId = "C4001";
        } else {
            $cartId = substr($lastId, 1);
            $cartId = intval($cartId);
            $cartId = "C".($cartId + 1);
        }

        $conn->query("INSERT INTO cart (cartId, email, prodCode, qty, prodPrice, subtotal, status) VALUES ('$cartId', '$email', '$prodCode', '$prodQty', '$prodPrice', '$subtotal', 'Pending')");
    }
} elseif(isset($_POST['deleteItem'])) {
    $email = $_POST['email'];
    $prodCode = $_POST['prodCode'];

    $delete = $conn->query("DELETE FROM cart WHERE email = '$email' AND prodCode = '$prodCode' AND status = 'Pending'");

    if($delete) {
        echo "success";
    } else {
        echo "error";
    }
} elseif(isset($_POST['updateQty'])) {
    $email = $_POST['email'];
    $prodCode = $_POST['prodCode'];
    $qty = $_POST['qty'];

    $get_price = $conn->query("SELECT * FROM sell_product WHERE product_code = '$prodCode' LIMIT 1");
    $price = $get_price->fetch_assoc();
    $prodPrice = $price['product_price'];
    $subtotal = $qty * $prodPrice;

    $update = $conn->query("UPDATE cart SET qty = '$qty', subtotal = '$subtotal' WHERE email = '$email' AND prodCode = '$prodCode' AND status = 'Pending'");
    if($update) {
        echo "success";
    } else {
        echo "error";
    }
}
?>