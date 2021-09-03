<?php
	require("includes/session.php");
	require("includes/head.php");

    $iterator = 1;
    $query = "SELECT `order_id`, `customer_name`, `amount`, `product_name`, `quantity`, `paid`, DATE_FORMAT(`order_date`,'%d-%m-%y %h:%m %p') as `order_date`, `order_date` as `date` 
    FROM `order` 
    JOIN `customer` ON `customer`.`customer_id`=`order`.`customer_id` 
    JOIN `product` ON `product`.`product_id`=`order`.`product_id`
    ORDER BY `date` DESC";
    $result = mysqli_query($conn, $query);

    $query = "SELECT  `customer_id`, `customer_name` FROM `customer`";
    $cutomer_name_result = mysqli_query($conn, $query);

    $query = "SELECT  `product_id`, `product_name` FROM `product`";
    $product_name_result = mysqli_query($conn, $query);
?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <div class="d-flex justify-content-between my-4">
            <h3>Orders</h3>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">Create Order</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <?php if(($result) and ($rowcount=mysqli_num_rows($result) > 0)) { ?>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">#</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                    <th scope="col">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=mysqli_fetch_assoc($result)) { ?>
                                
                                    <tr class="<?php if($row['paid']) { ?>table-success <?php } else { ?>table-danger<?php } ?>">
                                    <th scope="row"><?=$iterator?></th>
                                    <th scope="row"><?=$row['order_id']?></th>
                                    <td><?=$row['customer_name']?></td>
                                    <td><?=$row['product_name']?></td>
                                    <td><?=$row['quantity']?></td>
                                    <td>₹ <?=$row['amount']?></td>
                                    <td><?=$row['order_date']?></td>
                                    <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editOrder(<?=$row['order_id']?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteOrder(<?=$row['order_id']?>)">Delete</button>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php $iterator++;} ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-primary text-center">No orders to show</div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrder" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createOrder">Create Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id" value="">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer Name</label>
                            <select required id="customer_id" name="customer_id" class="form-select">
                                <option selected hidden value="">Select Customer</option>
                                <?php while($row = mysqli_fetch_assoc($cutomer_name_result)) { ?> 
                                    <option value="<?=$row["customer_id"]?>"> <?=$row["customer_name"]?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product Name</label>
                            <select required id="product_id" name="product_id" class="form-select">
                                <option selected hidden value="">Select Product</option>
                                <?php while($row = mysqli_fetch_assoc($product_name_result)) { ?> 
                                    <option value="<?=$row["product_id"]?>"> <?=$row["product_name"]?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <select required name="quantity" id="quantity" class="form-select">
                                <option selected hidden value="">Select Quantity</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount" disabled vlaue="">
                        </div>
                        <div class="mb-2 form-check">
                            <label class="form-check-label" for="paid">Paid</label>
                            <input class="form-check-input" type="checkbox" id="paid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>
<script>

    let price = 0;
    let quantity = 0;
    let update_amount;
    $('#product_id').on('change', (e) => {
        if ($('#product_id').val() !== "" ) {
            $.post({
				url: "api/fetch_product_price_api.php",
				data: {
					product_id: $('#product_id').val()
				},
				success: (response) => {
					response = JSON.parse(response);

					if(response.success){
                        price = parseInt(response.data);
                    }
					else{
                        $('#amount').val("Amount Unavailable");
					}
				},
				error: () => {
					alert("Server Error, Please try again later.");
				}
			});
        }
    });

    $("#createOrderModal").on("shown.bs.modal", (e) => {
        if ($("#createOrderModal #amount").val() == "") {
            update_amount = setInterval(() => {
                quantity = parseInt($('#quantity').val());
                if(($('#product_name').val() !== "") && ($('#quantity').val() !== "")) {
                    $("#amount").val(`₹ ${parseInt(price) * parseInt(quantity)}`);
                } else {
                    $("#amount").val(`₹ ${0}`);
                }
            }, 500);
        }
    });

    $("#createOrderModal").on("hide.bs.modal", (e) => {
        clearInterval(update_amount);
    });

    $("#form").on('submit', (e) => {
        e.preventDefault();
        if ($("#form #order_id").val() == "") {
            $.post({
                url: "api/create_order_api.php",
                data: {
                    customer_id: $("#customer_id").val(),
                    product_id: $("#product_id").val(),
                    quantity: $("#quantity").val(),
                    paid: $('#paid').is(":checked") ? true : false,
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
                url: "api/update_order_api.php",
                data: {
                    order_id: $("#order_id").val(),
                    customer_id: $("#customer_id").val(),
                    product_id: $("#product_id").val(),
                    quantity: $("#quantity").val(),
                    paid: $('#paid').is(":checked") ? true : false,
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

    
    function editOrder(ordId){
        $.post({
            url : "api/get_single_order_api.php",
            data : {
                "order_id" : ordId
            },
            success : function(response) {
                    
                response = JSON.parse(response);

                if(response.success == true){
                
                    $("#createOrderModal #order_id").val(ordId);
                    $("#createOrderModal #customer_id").val(response.data.customer_id);
                    $("#createOrderModal #product_id").val(response.data.product_id);
                    $("#createOrderModal #quantity").val(response.data.quantity);
                    $("#createOrderModal #amount").val(`₹ ${response.data.amount}`);
                    $("#createOrderModal #paid").val(response.data.paid);
                    $("#createOrderModal #submit_action_type").val("update");
                    $("#createOrderModal #createCustomer").html("Update Customer");
                    $("#createOrderModal").modal("show");                   
                }
            } 
        });
    }

    function deleteOrder(orderId){
        if(confirm("Do you want to delete Order with ID : " + orderId)){
            $.post({
                url : "api/delete_order_api.php",
                data : {
                    "order_id" : orderId
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

</script>