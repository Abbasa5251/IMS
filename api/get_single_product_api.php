<?php
    require("../common/db.php");

    $product_id = $_REQUEST["product_id"];

    $query = "SELECT * FROM `product` WHERE `product_id`='$product_id'";
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_array($result))
    {
        $response["success"]  = true;
        $response["message"]  = "Customer fetched successfully!";
        $response["data"]     = array("product_id"=>$row["product_id"], "product_name"=>$row["product_name"],  "product_unit_price"=>$row["product_unit_price"]);
    }
    else{

        $response["success"]  = false;
        $response["message"]  = "Sorry, Unable to fetch customer!";
        $response["data"]     = null;
    }

    echo json_encode($response);
?>