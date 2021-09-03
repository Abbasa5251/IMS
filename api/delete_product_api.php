<?php
    session_start();
    require("../common/db.php");

    $product_id = $_POST["product_id"];

    $query = "DELETE FROM `product` WHERE `product_id`='$product_id'";

    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Product deleted Successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>