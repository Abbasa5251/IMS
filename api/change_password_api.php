<?php
    session_start();
    require("../common/db.php");

    $userId = $_SESSION['user']['user_id'];

    $old_password = mysqli_real_escape_string($conn, trim($_POST['old_password']));
    $new_password = mysqli_real_escape_string($conn, trim($_POST['new_password']));

    $query = "SELECT `user_password` FROM `user` WHERE `user_id`='$userId'";
    $result = mysqli_query($conn, $query);

    $current_password = mysqli_fetch_assoc($result)["user_password"];

    if($current_password === $old_password) {
        $query = "UPDATE `user` SET `user_password`='$new_password' WHERE `user_id`='$userId'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_affected_rows($conn);
        if ($rows === 1) {
            $response['message'] = "Password updated successfully";
            $response['success'] = true;
        }
        else {
            $response['message'] = "Try again later";
            $response['success'] = false;
        }
    } else {
        $response['message'] = "Wrong current password";
        $response['success'] = false;
    }

    echo json_encode($response);
?>