<?php
    $page = explode("/",$_SERVER["PHP_SELF"]);
    $page = $page[count($page)-1];
    $page = explode(".",$page)[0];
?>
<nav class="navbar navbar-expand-md navbar-dark mb-5" style="background-color: #0044b0;">
    <div class="container-md">
        <a class="navbar-brand" href="index.php"><strong>IMS</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link <?php if($page=="index") { ?> active <?php } ?>" href="index.php">
                        <i class="bi bi-house-fill"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link <?php if($page=="products") { ?> active <?php } ?>" href="products.php">
                        <i class="bi bi-file-ruled-fill"></i>
                        Products
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link <?php if($page=="customers") { ?> active <?php } ?>" href="customers.php">
                        <i class="bi bi-people-fill"></i>
                        Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($page=="orders") { ?> active <?php } ?>" href="orders.php">
                        <i class="bi bi-bag-check-fill"></i>
                        Orders
                    </a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link disabled text-white-50" href="#"><?=$_SESSION["user"]["role_name"];?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=$_SESSION["user"]['user_first_name'];?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="profile.php">
                                    <i class="bi bi-person-fill me-2"></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="change_password.php">
                                    <i class="bi bi-lock-fill me-2"></i>
                                    Change Password
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#LogoutModal">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="LogoutModalLabel">Ready to Leave?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Select "Logout" below if you are ready to end your current session.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a class="btn btn-primary" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>