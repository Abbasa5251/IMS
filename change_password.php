<?php
	require("includes/session.php");
	require("includes/head.php");
    require("common/db.php");
?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
        <div class="col-lg-6">
            <div class="p-5">
                <div id="alertMsg" class="d-none alert" role="alert"></div>
                <form name="form" id="form">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Old Password</label>
                        <input type="password" required class="form-control" id="old_password" placeholder="Password">
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" required  class="form-control" id="new_password" placeholder="New Password">
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" required class="form-control" id="confirm_new_password" placeholder="Confirm New Password">
                    </div>
                    <input type="submit" class="btn btn-primary" id="btnChangePassword" value="Change Password" />
                </form>
            </div>
        </div>
    </div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>
<script>
    const url = "api/change_password_api.php";

    $("#form").on("submit", function(e) {
        e.preventDefault();
        
        if($("#new_password").val() === $("#confirm_new_password").val()) {
            $.post({
                url: url,
                data: {
                    old_password: $("#old_password").val(),
                    new_password: $("#new_password").val(),
                },
                success: (data) => {
                    data = JSON.parse(data);

                    if(data.success){
                        alertMsg.innerHTML = data.message;
                        alertMsg.classList.add('alert-success');
                        alertMsg.classList.remove('d-none');

                        setTimeout(() => {
                            alertMsg.classList.remove('alert-success');
                            alertMsg.classList.add('d-none');
                        }, 5000);
                    }
                    else{
                        alertMsg.innerHTML = data.message;
                        alertMsg.classList.add('alert-danger');
                        alertMsg.classList.remove('d-none');

                        setTimeout(() => {
                            alertMsg.classList.remove('alert-danger');
                            alertMsg.classList.add('d-none');
                        }, 5000);
                    }
                },
                error: function() {
                    alert("Server Error, Please try again later.");
                }
            });
        }
        else {
            alertMsg.innerHTML = "Password doesn't match";
            alertMsg.classList.add('alert-danger');
            alertMsg.classList.remove('d-none');

            setTimeout(() => {
                alertMsg.classList.remove('alert-danger');
                alertMsg.classList.add('d-none');
            }, 5000);
        }
        this.reset();
    });
</script>