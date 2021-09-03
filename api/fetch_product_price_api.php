<?php
    session_start();
    require("../common/db.php");

    $product_id = $_POST['product_id'];

    $query = "SELECT `product_unit_price` AS 'amount' FROM `product` WHERE `product_id`='$product_id'";
    $result = mysqli_query($conn, $query);


    if($row=mysqli_fetch_assoc($result)) {
        $response['data'] = $row['amount'];
        $response['success'] = true;
        $response['message'] = "Amount fetched";
    } else {
        $response['success'] = false;
        $response['message'] = "Error fetching amount";
    }

    echo json_encode($response);
?>