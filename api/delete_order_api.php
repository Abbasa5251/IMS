<?php
    session_start();
    require("../common/db.php");

    $order_id = $_POST["order_id"];

    $query = "DELETE FROM `order` WHERE `order_id`='$order_id'";

    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Order deleted Successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>