<?php
    session_start();
    require("../common/db.php");

    $customer_id = $_POST["customer_id"];
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];
    $paid = $_POST["paid"];

    $query = "SELECT `product_unit_price` AS 'amount' FROM `product` WHERE `product_id`='$product_id'";
    $result = mysqli_query($conn, $query);

    $price = mysqli_fetch_assoc($result)['amount'];
    $amount = (int)$price * (int)$quantity;

    $query = "INSERT INTO `order` (`customer_id`, `product_id`, `quantity`, `amount`, `paid`) VALUES ('$customer_id', '$product_id', '$quantity', '$amount', $paid)";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Ordered placed successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>