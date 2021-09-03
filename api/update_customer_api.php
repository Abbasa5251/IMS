<?php
    require("../common/db.php");

    $customer_id = $_REQUEST["customer_id"];
    $customer_name = $_POST["customer_name"];
    $customer_address = $_POST["customer_address"];
    $customer_number = $_POST["customer_number"];

    $query = "UPDATE `customer` SET `customer_name`='$customer_name', `customer_address`='$customer_address', `customer_number`='$customer_number' WHERE `customer_id`='$customer_id'";
    $result = mysqli_query($conn, $query);

    if($result)
    {
        $response["success"]  = true;
        $response["message"]  = "Customer updated successfully!";
    }
    else{

        $response["success"]  = false;
        $response["message"]  = "Sorry, Unable to fetch customer!";
    }

    echo json_encode($response);