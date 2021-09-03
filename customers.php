<?php
	require("includes/session.php");
	require("includes/head.php");

    $iterator = 1;
    $query = "SELECT * FROM `customer` ORDER BY `created_at` DESC";
    $result = mysqli_query($conn, $query);
?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <div class="d-flex justify-content-between my-4">
            <h3>Customers</h3>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">Create Customer</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <?php if(($result) and ($rowcount=mysqli_num_rows($result) > 0)) { ?>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Number</th>
                                <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                    <th scope="col">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?=$iterator?></th>
                                    <td><?=$row['customer_name']?></td>
                                    <td><?=$row['customer_address']?></td>
                                    <td><?=$row['customer_number']?></td>
                                    <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editCustomer(<?=$row['customer_id']?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteCustomer(<?=$row['customer_id']?>)">Delete</button>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php $iterator++;} ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-primary text-center">No customers to show</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomer" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCustomer">Create Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <input type="hidden" name="customer_id" id="customer_id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Name</label>
                            <input type="text" required class="form-control" id="customer_name">
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">Address</label>
                            <input type="text" required class="form-control" id="customer_address">
                        </div>
                        <div class="mb-3">
                            <label for="customer_number" class="form-label">Mobile Number</label>
                            <input type="text" required class="form-control" id="customer_number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit_action_type">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>
<script>
    const customer_number = document.querySelector("#customer_number");

    $("#customer_number").on('input', () => {
        if (!Number(customer_number.value.slice(-1)) || (customer_number.value.length > 10)) {
            customer_number.value = customer_number.value.slice(0, -1)
        }
    });

    $("#form").on('submit', (e) => {
        e.preventDefault();
        if ($("#form #customer_id").val() == "") { 
            $.post({
                url: "api/create_customer_api.php",
                data: {
                    customer_name: $("#customer_name").val(),
                    customer_address: $("#customer_address").val(),
                    customer_number: $("#customer_number").val(),
                },
                success: (data) => {
                    data = JSON.parse(data);

                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            });
        } else {
            $.post({
                url: "api/update_customer_api.php",
                data: {
                    customer_id: $("#customer_id").val(),
                    customer_name: $("#customer_name").val(),
                    customer_address: $("#customer_address").val(),
                    customer_number: $("#customer_number").val(),
                },
                success: (data) => {
                    data = JSON.parse(data);

                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });

    function deleteCustomer(customerId){
        if(confirm("Do you want to delete Customer with ID : " + customerId)){
            $.post({
                url : "api/delete_customer_api.php",
                data : {
                    "customer_id" : customerId
                },
                success : function(response) {
                        
                    response = JSON.parse(response);

                    if(response.success == true){
                        location.reload();  
                    }
                } 
            });
        }    
    }

    function editCustomer(custId){
        $.post({
            url : "api/get_single_customer_api.php",
            data : {
                "customer_id" : custId
            },
            success : function(response) {
                    
                response = JSON.parse(response);

                if(response.success == true){
                
                    $("#createCustomerModal #customer_id").val(custId);
                    $("#createCustomerModal #customer_name").val(response.data.customer_name);
                    $("#createCustomerModal #customer_address").val(response.data.customer_address);
                    $("#createCustomerModal #customer_number").val(response.data.customer_number);
                    $("#createCustomerModal #submit_action_type").val("update");
                    $("#createCustomerModal #createCustomer").html("Update Customer");
                    $("#createCustomerModal").modal("show");                   
                }
            } 
        });
    }

</script>