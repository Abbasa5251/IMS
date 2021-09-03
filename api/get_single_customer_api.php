<?php
    require("../common/db.php");

    $customer_id = $_REQUEST["customer_id"];

    $query = "SELECT * FROM customer WHERE customer_id=".$customer_id;
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_array($result))
    {
        $response["success"]  = true;
        $response["message"]  = "Customer fetched successfully!";
        $response["data"]     = array("customer_id"=>$row["customer_id"], "customer_name"=>$row["customer_name"],  "customer_address"=>$row["customer_address"], "customer_number"=>$row["customer_number"]);
    }
    else{

        $response["success"]  = false;
        $response["message"]  = "Sorry, Unable to fetch customer!";
        $response["data"]     = null;
    }

    echo json_encode($response);
?>