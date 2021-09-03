<?php
    session_start();
    require("../common/db.php");

    $order_id = $_POST["order_id"];
    $customer_id = $_POST["customer_id"];
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];
    $paid = $_POST["paid"];

    $query = "SELECT `product_unit_price` AS 'amount' FROM `product` WHERE `product_id`='$product_id'";
    $result = mysqli_query($conn, $query);

    $price = mysqli_fetch_assoc($result)['amount'];
    $amount = (int)$price * (int)$quantity;

    $query = "UPDATE `order` SET `customer_id`='$customer_id', `product_id`='$product_id', `quantity`='$quantity', `amount`='$amount', `paid`='$paid' WHERE `order_id`='$order_id'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Ordered updated successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>