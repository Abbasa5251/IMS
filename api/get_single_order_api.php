<?php
    require("../common/db.php");

    $order_id = $_REQUEST["order_id"];

    $query = "SELECT * FROM `order` WHERE `order_id`='$order_id'";
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_array($result))
    {
        $response["success"]  = true;
        $response["message"]  = "Customer fetched successfully!";
        $response["data"]     = array("order_id"=>$row["order_id"], "customer_id"=>$row["customer_id"],  "product_id"=>$row["product_id"], "quantity"=>$row["quantity"], "amount"=>$row["amount"], "paid"=>$row["paid"]);
    }
    else{

        $response["success"]  = false;
        $response["message"]  = "Sorry, Unable to fetch customer!";
        $response["data"]     = null;
    }

    echo json_encode($response);
?>