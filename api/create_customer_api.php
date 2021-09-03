<?php
    session_start();
    require("../common/db.php");

    $customer_name = $_POST["customer_name"];
    $customer_address = $_POST["customer_address"];
    $customer_number = $_POST["customer_number"];

    $query = "INSERT INTO `customer` (`customer_name`, `customer_address`, `customer_number`) VALUES ('$customer_name', '$customer_address', '$customer_number')";

    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Customer added successfully";
    } else {
        $response["success"] = false;
        $response["message"] = "Try again later";
    }

    echo json_encode($response);
?>