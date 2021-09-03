<?php
	require("includes/session.php");
	require("includes/head.php");

	// $query = "SELECT COUNT(`customer_id`) as customers, COUNT(`product_id`) as products FROM `customer`, `product`";
	$query = "SELECT
		(SELECT COUNT(*) FROM `customer`) AS 'customers',
		(SELECT COUNT(*) FROM `product`) AS 'products',
		(SELECT COUNT(*) FROM `order`) AS 'orders'";
	
    $result = mysqli_query($conn, $query);

    if($result) {
        $row = mysqli_fetch_assoc($result);
    }

    $query = "SELECT `order_id`, `customer_name`, `amount`, `paid`, DATE_FORMAT(`order_date`,'%d-%m-%y %h:%m %p') as `order_date`, `order_date` as `date` FROM `order` JOIN `customer` ON `customer`.`customer_id`=`order`.`customer_id` ORDER BY `date` DESC LIMIT 5";
    $recentOrders = mysqli_query($conn, $query);

?>
<body>
    <?php require("includes/navbar.php"); ?>
    <div class="container mx-auto">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <h3 class="card-text">
                            <strong>
                            <?php
                                if(isset($row)) { 
                                    echo $row['products'];
                                } else {
                                    echo "0";
                                }
                            ?>
                            </strong>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <h3 class="card-text">
                            <strong>
                            <?php
                                if(isset($row)) { 
                                    echo $row['orders'];
                                } else {
                                    echo "0";
                                }
                            ?>
                            </strong>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <h5 class="card-title">Customers</h5>
                        <h3 class="card-text">
                            <strong>
                            <?php
                                if(isset($row)) { 
                                    echo $row['customers'];
                                } else {
                                    echo "0";
                                }
                            ?>
                            </strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col text-center">
                <h4>Recent Orders</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <?php if(($recentOrders) and (mysqli_num_rows($recentOrders) > 0)) { ?>
                <table class="table table-hover text-center">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">#</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row=mysqli_fetch_assoc($recentOrders)) { ?>      
                            <tr class="<?php if($row['paid']) { ?>table-success <?php } else { ?>table-danger<?php } ?>">
                                <th scope="row"><?=$row['order_id']?></th>
                                <td><?=$row['customer_name']?></td>
                                <td>₹ <?=$row['amount']?></td>
                                <td><?=$row['order_date']?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="alert alert-primary text-center">No Orders</div>
                <?php } ?>
            </div>
        </div>

    </div>

    <?php require("includes/scripts.php"); ?>
</body>
</html>