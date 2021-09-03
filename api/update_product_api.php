<?php
    require("../common/db.php");

    $product_id = $_REQUEST["product_id"];
    $product_name = $_POST["product_name"];
    $product_unit_price = $_POST["product_unit_price"];

    $query = "UPDATE `product` SET `product_name`='$product_name', `product_unit_price`='$product_unit_price', WHERE `product_id`='$product_id'";
    $result = mysqli_query($conn, $query);

    if($result)
    {
        $response["success"]  = true;
        $response["message"]  = "Product updated successfully!";
    }
    else{

        $response["success"]  = false;
        $response["message"]  = "Sorry, Unable to update Product!";
    }

    echo json_encode($response);
?>