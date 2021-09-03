<?php
	require("includes/session.php");
	require("includes/head.php");

    $iterator = 1;
    $query = "SELECT * FROM `product` ORDER BY `created_at` DESC";
    $result = mysqli_query($conn, $query);
?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <div class="d-flex justify-content-between my-4">
            <h3>Products</h3>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">Create Product</button>
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
                                <th scope="col">Price</th>
                                <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                    <th scope="col">Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?=$iterator?></th>
                                    <td><?=$row['product_name']?></td>
                                    <td>₹ <?=$row['product_unit_price']?></td>
                                    <?php if($_SESSION['user']['role_id'] == 1) { ?>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editProduct(<?=$row['product_id']?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteProduct(<?=$row['product_id']?>)">Delete</button>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php $iterator++;} ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-primary text-center">No products to show</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProduct" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProduct">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="product_id" value="product_id">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Name</label>
                            <input type="text" required class="form-control" id="product_name">
                        </div>
                        <div class="mb-3">
                            <label for="product_unit_price" class="form-label">Unit Price</label>
                            <input type="text" required class="form-control" id="product_unit_price">
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
    $("#form").on('submit', (e) => {
        e.preventDefault();
        if ($("#product_id").val() == "") {
            $.post({
                url: "api/create_product_api.php",
                data: {
                    product_name: $("#product_name").val(),
                    product_unit_price: $("#product_unit_price").val(),
                },
                success: (data) => {
                    data = JSON.parse(data);
                    console.log(data);

                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            });
        } else {
            $.post({
                url: "api/update_product_api.php",
                data: {
                    product_id: $("#product_id").val(),
                    product_name: $("#product_name").val(),
                    product_unit_price: $("#product_unit_price").val(),
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

    function deleteProduct(productId){
        if(confirm("Do you want to delete Product with ID : " + productId)){
            $.post({
                url : "api/delete_product_api.php",
                data : {
                    "product_id" : productId
                },
                success : function(response) {
                        
                    response = JSON.parse(response);

                    if(response.success == true){
                        location.reload();  
                    } else {
                        alert(data.message);
                    }
                } 
            });
        }    
    }

    function editProduct(proId){
        $.post({
            url : "api/get_single_product_api.php",
            data : {
                "product_id" : proId
            },
            success : function(response) {
                    
                response = JSON.parse(response);

                if(response.success == true){
                
                    $("#createProductModal #product_id").val(proId);
                    $("#createProductModal #product_name").val(response.data.product_name);
                    $("#createProductModal #product_unit_price").val(response.data.product_unit_price);
                    $("#createProductModal #submit_action_type").val("update");
                    $("#createProductModal #createCustomer").html("Update Product");
                    $("#createProductModal").modal("show");                   
                }
            } 
        });
    }


</script>