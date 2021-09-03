<?php
    session_start();
    require("../common/db.php");

    $userName = mysqli_real_escape_string($conn, trim($_POST['username']));
    $userPassword = mysqli_real_escape_string($conn, trim($_POST['password']));

    $query = "SELECT * FROM `user` JOIN `role` ON `user`.`role_id`=`role`.`role_id` WHERE `user_name`='$userName' AND `user_password`='$userPassword'";

    $result = mysqli_query($conn, $query);

    $response = array();
    if($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $row;
        
        $response['message'] = "Logged In Successfully";
        $response['success'] = true;
        $response['user'] = array(
            "userName" => $row['user_first_name']." ".$row['user_last_name'],
            "userId" => $row['user_id'],
        );
    }
    else {
        $response['message'] = "Invalid User, Please try again";
        $response['success'] = false;
    }

    echo json_encode($response);
?>