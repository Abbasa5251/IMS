<?php
    session_start();
    require("../common/db.php");

    $customer_id = $_POST["customer_id"];

    $query = "DELETE FROM `customer` WHERE `customer_id`='$customer_id'";

    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Customer deleted Successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>