<?php
	require("includes/session.php");
	require("includes/head.php");
?>
<body>

	<div class="container mt-5 p-5">
		<div class="row text-center align-items-center justify-content-center">
			<div class="col-md-6">
				<h3>IMS Login</h3>
			</div>
		</div>
		<div class="row align-items-center justify-content-center">
			<div class="col-md-6">
			<form id="form">
				<div class="mb-3">
					<label for="txtUser" class="form-label">User Name</label>
					<input type="text" class="form-control" id="txtUser">
				</div>
				<div class="mb-3">
					<label for="txtPassword" class="form-label">Password</label>
					<input type="password" class="form-control" id="txtPassword">
				</div>
				<div class="text-center">
					<input id="btnSubmit" type="submit" class="btn btn-primary" value="Log In">
				</div>
			</form>
			</div>
		</div>
	</div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>

<script>

    $("#form").on("submit", function(e) {
		e.preventDefault();
		const txtUser = $("#txtUser").val(); 
      	const txtPassword = $("#txtPassword").val();
		const url = "api/login_api.php";
		
		console.log(txtUser, txtPassword);

		if(txtUser==""){
			alert("Please enter username!");
		}
		else if(txtPassword == ""){
			alert("Please enter password!");
		}
		else{
			$.post({
				url: url,
				data: {
					username: txtUser,
					password: txtPassword,
				},
				success: function(data) {
					data = JSON.parse(data);
					console.log(data);

					if(data.success){
						$("#btnSubmit").prop('value', 'Logging in...');
						
						setTimeout( function(){
							window.location = "";
						}, 2000);
					}
					else{
						alert(data.message);
					}
				},
				error: function() {
					alert("Server Error, Please try again later.");
				}
			});
		}
    })
</script>