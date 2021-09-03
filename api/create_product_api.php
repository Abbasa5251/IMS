<?php
    session_start();
    require("../common/db.php");

    $product_name = $_POST["product_name"];
    $product_unit_price = $_POST["product_unit_price"];

    $query = "INSERT INTO `product` (`product_name`, `product_unit_price`) VALUES ('$product_name', '$product_unit_price')";

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