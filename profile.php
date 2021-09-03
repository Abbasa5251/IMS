<?php
	require("includes/session.php");
	require("includes/head.php");
    require("common/db.php");

    $message = "";

    if(isset($_POST["btnUpdate"])) {

        $user_fname = $_POST["user_fname"];
        $user_lname = $_POST["user_lname"];
        $user_email = $_POST["user_email"];
        $role_id = $_POST["role_id"];

        $query = "UPDATE user SET user_first_name='$user_fname', user_last_name='$user_lname', user_email='$user_email', role_id='$role_id' WHERE user_id= ".$_SESSION["user"]["user_id"];
        $isUpdated = mysqli_query($conn, $query);

        if($isUpdated){
            $message = "Profile Updated Successfully!";
        }
    }

    $query = "SELECT * FROM user WHERE user_id = ".$_SESSION["user"]["user_id"];
    $result = mysqli_query($conn, $query);
    $loggedInUser = mysqli_fetch_assoc($result); 

    $query = "SELECT * FROM role";
    $resultRoles = mysqli_query($conn, $query);
?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="h4 mb-4">Profile</h1>
                
                <?php if($message!=""){ ?>
                    <p class="alert alert-success"> <?=$message?> </p>
                <?php } ?>

                <form class="user" action="" method="POST">

                    <div class="form-group row">
                        <div class="col-sm-6 mb-4">
                            <label for="user_fname" class="form-label">First Name</label>
                            <input id="user_fname" type="text" class="form-control" name="user_fname" value="<?=$loggedInUser["user_first_name"]?>">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="user_lname" class="form-label">Last Name</label>
                            <input id="user_lname" type="text" class="form-control" name="user_lname" value="<?=$loggedInUser["user_last_name"]?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 mb-4">
                            <label for="user_email" class="form-label">Email</label>
                            <input id="user_email" type="email" class="form-control" name="user_email" value="<?=$loggedInUser["user_email"]?>">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="role_id" class="form-label">User Role</label>
                            <select id="role_id" name="role_id" class="form-select" <?php if($_SESSION["user"]["role_id"] != 1) { ?> disabled <?php } ?>>
                                <?php while($row = mysqli_fetch_assoc($resultRoles)) { ?> 
                                    <option <?php if($row["role_id"]==$loggedInUser["role_id"]){ ?> selected <?php } ?> value="<?=$row["role_id"]?>"> <?=$row["role_name"]?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="submit" name="btnUpdate" value="Update Profile" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>